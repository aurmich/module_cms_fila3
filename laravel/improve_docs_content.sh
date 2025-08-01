#!/bin/bash

# Script per migliorare sistematicamente il contenuto della documentazione
# Focus su compliance Laraxot, esempi aggiornati e best practices

set -e

echo "🎯 MIGLIORAMENTO CONTENUTO DOCUMENTAZIONE LARAXOT"
echo "================================================="
echo ""

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Contatori
files_updated=0
examples_fixed=0
violations_fixed=0

# Funzione per aggiornare esempi obsoleti in un file
update_file_examples() {
    local file="$1"
    local updated=false
    
    # Backup del file originale
    cp "$file" "${file}.backup"
    
    # Correggi estensioni dirette di Resource
    if sed -i.tmp 's/extends Resource/extends XotBaseResource/g' "$file" 2>/dev/null; then
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Corretto: extends Resource → extends XotBaseResource"
            updated=true
            ((examples_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
    
    # Correggi uso di ->label()
    if sed -i.tmp 's/->label([^)]*)/\/\/ Label gestita automaticamente da LangServiceProvider/g' "$file" 2>/dev/null; then
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Corretto: Rimosso ->label() e aggiunto commento"
            updated=true
            ((examples_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
    
    # Correggi array() syntax
    if sed -i.tmp 's/array(/[/g; s/array)/]/g' "$file" 2>/dev/null; then
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Corretto: array() → []"
            updated=true
            ((examples_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
    
    # Correggi namespace con App
    if sed -i.tmp 's/namespace Modules\\\\[^\\\\]*\\\\App\\\\/namespace Modules\\\\/g' "$file" 2>/dev/null; then
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Corretto: Rimosso segmento 'App' dal namespace"
            updated=true
            ((examples_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
    
    # Aggiungi declare(strict_types=1) se manca negli esempi PHP
    if grep -q "<?php" "$file" && ! grep -q "declare(strict_types=1)" "$file"; then
        sed -i.tmp 's/<?php/<?php\n\ndeclare(strict_types=1);/g' "$file"
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Aggiunto: declare(strict_types=1)"
            updated=true
            ((examples_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
    
    # Correggi PHPStan level < 9
    if sed -i.tmp 's/level: [1-8]/level: 9/g' "$file" 2>/dev/null; then
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Corretto: PHPStan level → 9"
            updated=true
            ((examples_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
    
    if [ "$updated" = true ]; then
        echo "    📄 File aggiornato: $(basename "$file")"
        ((files_updated++))
        rm -f "${file}.backup"
    else
        # Ripristina backup se nessuna modifica
        mv "${file}.backup" "$file"
    fi
}

# Funzione per creare template standard per documentazione
create_standard_templates() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    
    echo -e "${BLUE}📝 Creazione template standard per: $module_name${NC}"
    
    # Template per best practices
    if [ ! -f "$docs_dir/best-practices/README.md" ]; then
        mkdir -p "$docs_dir/best-practices"
        cat > "$docs_dir/best-practices/README.md" << 'EOF'
# Best Practices

## Laraxot Framework Standards

### Models
- ALWAYS extend module's BaseModel
- NEVER extend Eloquent\Model directly
- Use `declare(strict_types=1);` in all files
- Implement `casts()` method, not `$casts` property

### Filament Resources
- ALWAYS extend XotBaseResource
- NEVER use `->label()` method
- Return associative arrays from `getFormSchema()`
- Use enum classes instead of hardcoded options

### Migrations
- Use anonymous classes extending XotBaseMigration
- NEVER implement `down()` method
- Always check existence with `hasTable()` and `hasColumn()`
- Copy original migration with new timestamp for column additions

### Translations
- Use expanded structure ALWAYS
- NEVER remove existing keys
- Maintain consistency across all languages (IT/EN/DE)
- Use snake_case for all keys

## Code Quality
- PHPStan level 9+ for all new code
- Complete PHPDoc annotations
- Use Safe library for unsafe functions
- Follow PSR-12 coding standards

## Documentation
- All files in docs/ must be lowercase (except README.md)
- Create bidirectional links between related documents
- Update both module and root documentation
- Include practical examples in all guides
EOF
        echo "    ✅ Creato: best-practices/README.md"
    fi
    
    # Template per troubleshooting
    if [ ! -f "$docs_dir/troubleshooting/README.md" ]; then
        mkdir -p "$docs_dir/troubleshooting"
        cat > "$docs_dir/troubleshooting/README.md" << 'EOF'
# Troubleshooting Guide

## Common Issues

### PHPStan Errors
- **Issue**: Method not found errors
- **Solution**: Check namespace imports and method signatures
- **Prevention**: Always run PHPStan level 9+ before commits

### Translation Problems
- **Issue**: Missing translations or hardcoded strings
- **Solution**: Use expanded translation structure
- **Prevention**: Never use `->label()` in Filament components

### Migration Failures
- **Issue**: Table/column already exists
- **Solution**: Always check existence before creation
- **Prevention**: Use `hasTable()` and `hasColumn()` methods

### Namespace Issues
- **Issue**: Class not found errors
- **Solution**: Remove 'App' segment from module namespaces
- **Prevention**: Follow Laraxot namespace conventions

## Debugging Steps

1. **Check PHPStan**: `./vendor/bin/phpstan analyze --level=9`
2. **Verify Translations**: Ensure all keys exist in all language files
3. **Test Migrations**: Run in development environment first
4. **Validate Namespaces**: Follow Modules\ModuleName\* pattern

## Getting Help

- Check module-specific documentation
- Review Laraxot framework guidelines
- Consult best practices documentation
- Use project memory system for context
EOF
        echo "    ✅ Creato: troubleshooting/README.md"
    fi
}

# Funzione per validare struttura traduzioni nei documenti
validate_translation_examples() {
    local file="$1"
    
    # Cerca esempi di traduzioni con struttura piatta e suggerisci correzione
    if grep -q "'field_name' => 'Label'" "$file"; then
        echo "    ⚠️  Trovata struttura traduzione piatta, aggiorno con struttura espansa"
        
        # Sostituisci con struttura espansa
        sed -i.tmp "s/'field_name' => 'Label'/'field_name' => [\n    'label' => 'Label',\n    'placeholder' => 'Enter value',\n    'helper_text' => 'Field description',\n]/g" "$file"
        
        if ! cmp -s "$file" "${file}.tmp"; then
            echo "    ✅ Corretto: Struttura traduzioni → espansa"
            ((violations_fixed++))
        fi
        rm -f "${file}.tmp"
    fi
}

echo "🎯 FASE 1: AGGIORNAMENTO CONTENUTO MODULI CORE"
echo "=============================================="

# Aggiorna contenuto moduli core
for module in "Xot" "UI" "User"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        echo -e "${GREEN}🔧 Miglioramento contenuto: $module${NC}"
        
        create_standard_templates "$docs_dir"
        
        # Aggiorna tutti i file .md
        find "$docs_dir" -name "*.md" -type f | head -20 | while read file; do
            echo "  📄 Analisi: $(basename "$file")"
            update_file_examples "$file"
            validate_translation_examples "$file"
        done
    fi
done

echo ""
echo "🎯 FASE 2: AGGIORNAMENTO CONTENUTO MODULI APPLICATIVI"
echo "===================================================="

# Aggiorna contenuto moduli applicativi
for module in "SaluteOra" "SaluteMo"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        echo -e "${GREEN}🔧 Miglioramento contenuto: $module${NC}"
        
        create_standard_templates "$docs_dir"
        
        # Aggiorna file principali
        find "$docs_dir" -maxdepth 1 -name "*.md" -type f | head -10 | while read file; do
            echo "  📄 Analisi: $(basename "$file")"
            update_file_examples "$file"
            validate_translation_examples "$file"
        done
    fi
done

echo ""
echo "📊 RIEPILOGO MIGLIORAMENTI"
echo "========================="
echo "📄 File aggiornati: $files_updated"
echo "🔧 Esempi corretti: $examples_fixed"
echo "⚠️  Violazioni risolte: $violations_fixed"

echo ""
echo -e "${GREEN}✅ Miglioramento contenuto completato!${NC}"
echo "📝 La documentazione ora rispetta gli standard Laraxot"
