#!/bin/bash

# Script per eseguire i test Pest per tutti i moduli del progetto SaluteOra
# Seguendo le best practice architetturali definite

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzioni di utility
print_header() {
    echo -e "\n${BLUE}=== $1 ===${NC}\n"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Verifica che siamo nella directory corretta
if [ ! -f "artisan" ]; then
    print_error "Questo script deve essere eseguito dalla root directory di Laravel"
    exit 1
fi

# Verifica che Pest sia installato
if [ ! -f "vendor/bin/pest" ]; then
    print_error "Pest non è installato. Eseguire: composer require pestphp/pest --dev"
    exit 1
fi

print_header "Test Suite per Moduli SaluteOra"

# Array dei moduli da testare
declare -a CORE_MODULES=("User" "Xot" "UI")
declare -a BUSINESS_MODULES=("SaluteOra" "SaluteMo")
declare -a UTILITY_MODULES=("Cms" "Media" "Geo" "Lang" "Notify" "Activity" "Tenant" "Job" "Gdpr")

# Funzione per verificare se un modulo è abilitato
is_module_enabled() {
    local module=$1
    if [ -f "modules_statuses.json" ]; then
        local status=$(jq -r ".${module} // false" modules_statuses.json)
        [ "$status" = "true" ]
    else
        print_warning "File modules_statuses.json non trovato"
        return 1
    fi
}

# Funzione per eseguire test di un modulo
run_module_tests() {
    local module=$1
    local test_path="tests/Feature/Modules/${module}"
    
    if [ ! -d "$test_path" ]; then
        print_warning "Directory test non trovata per modulo $module: $test_path"
        return 0
    fi
    
    if ! is_module_enabled "$module"; then
        print_warning "Modulo $module è disabilitato, saltando i test"
        return 0
    fi
    
    print_header "Test Modulo: $module"
    
    # Esegui test del modulo con report dettagliato
    if ./vendor/bin/pest "$test_path" --colors=always --verbose; then
        print_success "Test modulo $module completati con successo"
        return 0
    else
        print_error "Test modulo $module falliti"
        return 1
    fi
}

# Funzione per eseguire test per categoria di moduli
run_module_category_tests() {
    local category_name=$1
    shift
    local modules=("$@")
    local failed_modules=()
    
    print_header "Test Categoria: $category_name"
    
    for module in "${modules[@]}"; do
        if ! run_module_tests "$module"; then
            failed_modules+=("$module")
        fi
    done
    
    if [ ${#failed_modules[@]} -eq 0 ]; then
        print_success "Tutti i test della categoria $category_name sono passati"
        return 0
    else
        print_error "Test falliti per moduli: ${failed_modules[*]}"
        return 1
    fi
}

# Funzione per eseguire test di performance
run_performance_tests() {
    print_header "Test di Performance"
    
    # Test di performance per componenti critici
    local performance_tests=(
        "tests/Feature/Modules/User/Feature/Filament/Widgets/LoginWidgetTest.php"
        "tests/Feature/Modules/SaluteOra/Feature/Filament/Widgets/DoctorCalendarWidgetTest.php"
    )
    
    for test in "${performance_tests[@]}"; do
        if [ -f "$test" ]; then
            echo "Eseguendo test di performance: $test"
            ./vendor/bin/pest "$test" --filter="performance" --colors=always
        fi
    done
}

# Funzione per generare report di coverage
generate_coverage_report() {
    print_header "Generazione Report Coverage"
    
    if command -v xdebug >/dev/null 2>&1; then
        ./vendor/bin/pest --coverage --coverage-html=storage/app/coverage --colors=always
        print_success "Report coverage generato in storage/app/coverage"
    else
        print_warning "Xdebug non installato, saltando report coverage"
    fi
}

# Parsing degli argomenti della riga di comando
CATEGORIES=()
PERFORMANCE=false
COVERAGE=false
VERBOSE=false

while [[ $# -gt 0 ]]; do
    case $1 in
        --core)
            CATEGORIES+=("core")
            shift
            ;;
        --business)
            CATEGORIES+=("business")
            shift
            ;;
        --utility)
            CATEGORIES+=("utility")
            shift
            ;;
        --all)
            CATEGORIES=("core" "business" "utility")
            shift
            ;;
        --performance)
            PERFORMANCE=true
            shift
            ;;
        --coverage)
            COVERAGE=true
            shift
            ;;
        --verbose)
            VERBOSE=true
            shift
            ;;
        --help|-h)
            echo "Uso: $0 [OPZIONI]"
            echo ""
            echo "OPZIONI:"
            echo "  --core         Esegui test per moduli core (User, Xot, UI)"
            echo "  --business     Esegui test per moduli business (SaluteOra, SaluteMo)"
            echo "  --utility      Esegui test per moduli utility (Cms, Media, Geo, etc.)"
            echo "  --all          Esegui test per tutti i moduli"
            echo "  --performance  Esegui test di performance"
            echo "  --coverage     Genera report di coverage"
            echo "  --verbose      Output dettagliato"
            echo "  --help, -h     Mostra questo messaggio"
            echo ""
            echo "Esempi:"
            echo "  $0 --core --performance"
            echo "  $0 --all --coverage"
            echo "  $0 --business --verbose"
            exit 0
            ;;
        *)
            print_error "Opzione sconosciuta: $1"
            echo "Usa --help per vedere le opzioni disponibili"
            exit 1
            ;;
    esac
done

# Se nessuna categoria specificata, esegui tutti i test
if [ ${#CATEGORIES[@]} -eq 0 ]; then
    CATEGORIES=("core" "business" "utility")
fi

# Verifica prerequisiti
print_header "Verifica Prerequisiti"

# Verifica che le dipendenze siano installate
if [ ! -d "vendor" ]; then
    print_error "Dipendenze non installate. Eseguire: composer install"
    exit 1
fi

# Verifica configurazione database per test
if [ ! -f ".env.testing" ] && [ -z "$DB_CONNECTION" ]; then
    print_warning "File .env.testing non trovato. I test useranno la configurazione di default."
fi

print_success "Prerequisiti verificati"

# Esegui setup database per test
print_header "Setup Database Test"
php artisan migrate:fresh --env=testing --seed --quiet || {
    print_error "Errore durante setup database test"
    exit 1
}
print_success "Database test configurato"

# Contatori per statistiche finali
TOTAL_CATEGORIES=0
FAILED_CATEGORIES=0

# Esegui test per le categorie richieste
for category in "${CATEGORIES[@]}"; do
    TOTAL_CATEGORIES=$((TOTAL_CATEGORIES + 1))
    
    case $category in
        "core")
            if ! run_module_category_tests "Moduli Core" "${CORE_MODULES[@]}"; then
                FAILED_CATEGORIES=$((FAILED_CATEGORIES + 1))
            fi
            ;;
        "business")
            if ! run_module_category_tests "Moduli Business" "${BUSINESS_MODULES[@]}"; then
                FAILED_CATEGORIES=$((FAILED_CATEGORIES + 1))
            fi
            ;;
        "utility")
            if ! run_module_category_tests "Moduli Utility" "${UTILITY_MODULES[@]}"; then
                FAILED_CATEGORIES=$((FAILED_CATEGORIES + 1))
            fi
            ;;
    esac
done

# Esegui test di performance se richiesto
if [ "$PERFORMANCE" = true ]; then
    run_performance_tests
fi

# Genera report di coverage se richiesto
if [ "$COVERAGE" = true ]; then
    generate_coverage_report
fi

# Statistiche finali
print_header "Riepilogo Finale"

if [ $FAILED_CATEGORIES -eq 0 ]; then
    print_success "Tutti i test sono passati! ($TOTAL_CATEGORIES categorie testate)"
    
    # Mostra statistiche aggiuntive
    echo ""
    echo "Statistiche:"
    echo "- Categorie testate: $TOTAL_CATEGORIES"
    echo "- Moduli core: ${#CORE_MODULES[@]}"
    echo "- Moduli business: ${#BUSINESS_MODULES[@]}"
    echo "- Moduli utility: ${#UTILITY_MODULES[@]}"
    
    if [ "$PERFORMANCE" = true ]; then
        echo "- Test di performance: Eseguiti"
    fi
    
    if [ "$COVERAGE" = true ]; then
        echo "- Report coverage: Generato"
    fi
    
    exit 0
else
    print_error "Alcuni test sono falliti! ($FAILED_CATEGORIES/$TOTAL_CATEGORIES categorie fallite)"
    
    echo ""
    echo "Per maggiori dettagli sui test falliti, controllare l'output sopra."
    echo "Per eseguire test specifici:"
    echo "  ./vendor/bin/pest tests/Feature/Modules/[NomeModulo] --verbose"
    
    exit 1
fi











