#!/bin/bash

# Script per Verificare Conversione PHPUnit → Pest
# Controlla che tutti i test siano stati convertiti correttamente

echo "🚀 Verifica Conversione da PHPUnit a Pest"
echo "========================================"

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Contatori
ERRORS=0
WARNINGS=0
SUCCESS=0

# Funzione per stampare sezioni
print_section() {
    echo -e "\n${BLUE}📋 $1${NC}"
    echo "----------------------------------------"
}

# Funzione per errori
print_error() {
    echo -e "${RED}❌ $1${NC}"
    ((ERRORS++))
}

# Funzione per warning
print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
    ((WARNINGS++))
}

# Funzione per successo
print_success() {
    echo -e "${GREEN}✅ $1${NC}"
    ((SUCCESS++))
}

# 1. Verifica File Pest.php
print_section "Verifica File Pest.php per Moduli"

modules=("SaluteOra" "Cms" "Xot")
for module in "${modules[@]}"; do
    pest_file="Modules/${module}/tests/Pest.php"
    echo "Debug: Verificando $pest_file"
    if [[ -f "$pest_file" ]]; then
        print_success "File Pest.php presente per modulo $module"
        
        # Verifica contenuto
        if grep -q "uses(" "$pest_file"; then
            print_success "Configurazione uses() presente in $module"
        else
            print_error "File Pest.php in $module manca configurazione uses()"
        fi
    else
        print_error "File Pest.php mancante per modulo $module"
    fi
done

# 2. Cerca Classi PHPUnit Rimanenti
print_section "Ricerca Classi PHPUnit Rimanenti"

echo "Debug: Cercando classi PHPUnit rimanenti..."
phpunit_classes=$(find Modules/*/tests/ -name "*.php" -exec grep -l "class.*extends.*TestCase" {} \; 2>/dev/null || true)

if [[ -z "$phpunit_classes" ]]; then
    print_success "Nessuna classe PHPUnit trovata nei test dei moduli"
else
    print_error "Classi PHPUnit ancora presenti:"
    while IFS= read -r file; do
        echo "  - $file"
    done <<< "$phpunit_classes"
fi

# 3. Cerca Assertions PHPUnit Rimanenti
print_section "Ricerca Assertions PHPUnit Rimanenti"

echo "Debug: Cercando assertions PHPUnit rimanenti..."
phpunit_assertions=$(find Modules/*/tests/ -name "*.php" -exec grep -l '\$this->assert' {} \; 2>/dev/null || true)

if [[ -z "$phpunit_assertions" ]]; then
    print_success "Nessuna assertion PHPUnit trovata nei test"
else
    print_warning "Assertions PHPUnit ancora presenti:"
    while IFS= read -r file; do
        echo "  - $file"
        # Mostra le linee problematiche
        grep -n '\$this->assert' "$file" | head -3
    done <<< "$phpunit_assertions"
fi

# 4. Verifica Sintassi test() Functions
print_section "Verifica Sintassi Pest"

echo "Debug: Verificando sintassi Pest..."
test_files=$(find Modules/*/tests/ -name "*.php" -type f 2>/dev/null || true)

while IFS= read -r file; do
    if [[ -n "$file" ]]; then
        # Verifica se ha test() functions
        if grep -q "test(" "$file"; then
            # Verifica sintassi corretta
            if grep -q "test('.*', function" "$file"; then
                # File sembra corretto
                continue
            else
                print_warning "File $file ha test() ma sintassi potrebbe essere incorretta"
            fi
        fi
        
        # Verifica uso di expect()
        if grep -q "expect(" "$file"; then
            continue # Ha expect(), probabilmente Pest
        fi
        
        # Se ha test ma non expect(), potrebbe essere problematico
        if grep -q "test(" "$file" && ! grep -q "expect(" "$file"; then
            print_warning "File $file ha test() ma non usa expect()"
        fi
    fi
done <<< "$test_files"

echo "Debug: Completata verifica sintassi Pest"

# 5. Verifica Namespace
print_section "Verifica Namespace dei Test"

incorrect_namespaces=$(find Modules/*/tests/ -name "*.php" -exec grep -l "namespace Tests\\\\" {} \; 2>/dev/null || true)

if [[ -z "$incorrect_namespaces" ]]; then
    print_success "Namespace dei test corretti"
else
    print_error "File con namespace 'Tests\\' trovati (dovrebbero essere 'Modules\\ModuleName\\Tests'):"
    while IFS= read -r file; do
        echo "  - $file"
    done <<< "$incorrect_namespaces"
fi

# 6. Verifica Import Laravel Helpers
print_section "Verifica Import Laravel Helpers per Pest"

pest_files_needing_helpers=$(find Modules/*/tests/ -name "*.php" -exec grep -l "get('/" {} \; 2>/dev/null || true)

while IFS= read -r file; do
    if [[ -n "$file" ]]; then
        if ! grep -q "use function Pest\\Laravel" "$file"; then
            print_warning "File $file usa get() ma non ha import Pest\\Laravel helpers"
        fi
    fi
done <<< "$pest_files_needing_helpers"

# 7. Verifica Duplicati o File Obsoleti
print_section "Verifica File Duplicati"

duplicate_patterns=(
    "AuthenticationTest.pest.php"
    "*Test.bak.php"
    "*Test.old.php"
)

for pattern in "${duplicate_patterns[@]}"; do
    duplicates=$(find Modules/*/tests/ -name "$pattern" 2>/dev/null || true)
    if [[ -n "$duplicates" ]]; then
        print_warning "File duplicati/obsoleti trovati:"
        while IFS= read -r file; do
            echo "  - $file"
        done <<< "$duplicates"
    fi
done

# 8. Verifica TestCase Usage
print_section "Verifica TestCase nei Moduli"

for module in "${modules[@]}"; do
    testcase_file="Modules/${module}/tests/TestCase.php"
    if [[ -f "$testcase_file" ]]; then
        print_success "TestCase presente per modulo $module"
        
        # Verifica che usi CreatesApplication correttamente
        if grep -q "CreatesApplication" "$testcase_file"; then
            if [[ "$module" == "SaluteOra" ]]; then
                if grep -q "Modules\\Xot\\Tests\\CreatesApplication" "$testcase_file"; then
                    print_success "Import CreatesApplication corretto per $module"
                else
                    print_error "Import CreatesApplication errato per $module"
                fi
            fi
        fi
    else
        print_warning "TestCase mancante per modulo $module"
    fi
done

# 9. Test di Esecuzione Rapida
print_section "Test di Esecuzione Rapida"

if command -v ./vendor/bin/pest &> /dev/null; then
    echo "Esecuzione test rapidi per verifica sintassi..."
    
    for module in "${modules[@]}"; do
        if [[ -d "Modules/${module}/tests" ]]; then
            echo "Testing $module..."
            if timeout 30s ./vendor/bin/pest "Modules/${module}/tests/" --dry-run &>/dev/null; then
                print_success "Sintassi Pest corretta per $module"
            else
                print_error "Errori di sintassi Pest in $module"
            fi
        fi
    done
else
    print_warning "Pest non installato - impossibile verificare sintassi"
fi

# 10. Verifica Configurazioni CI/CD
print_section "Verifica Configurazioni CI/CD"

if [[ -f ".github/workflows/test.yml" ]] || [[ -f ".github/workflows/tests.yml" ]]; then
    ci_file=$(find .github/workflows/ -name "*test*.yml" | head -1)
    if grep -q "vendor/bin/pest" "$ci_file"; then
        print_success "CI/CD configurato per Pest"
    else
        print_warning "CI/CD potrebbe ancora usare PHPUnit invece di Pest"
    fi
else
    print_warning "Nessun file CI/CD trovato"
fi

# Riepilogo Finale
print_section "Riepilogo Verifica"

echo "📊 Risultati:"
echo "  ✅ Successi: $SUCCESS"
echo "  ⚠️  Warning: $WARNINGS"  
echo "  ❌ Errori:   $ERRORS"

if [[ $ERRORS -eq 0 ]]; then
    if [[ $WARNINGS -eq 0 ]]; then
        echo -e "\n${GREEN}🎉 Conversione a Pest COMPLETATA con successo!${NC}"
        echo -e "${GREEN}Tutti i test sono stati convertiti correttamente.${NC}"
        exit 0
    else
        echo -e "\n${YELLOW}⚠️  Conversione a Pest COMPLETATA con warning minori.${NC}"
        echo -e "${YELLOW}Rivedere i warning sopra per possibili miglioramenti.${NC}"
        exit 0
    fi
else
    echo -e "\n${RED}❌ Conversione a Pest NON COMPLETATA.${NC}"
    echo -e "${RED}Correggere gli errori sopra prima di procedere.${NC}"
    exit 1
fi 