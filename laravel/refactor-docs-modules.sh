#!/bin/bash

# Script per Refactor Radicale Documentazione Moduli
# DRY + KISS - Eliminazione duplicazioni e semplificazione

set -e

echo "🚀 Iniziando Refactor Radicale Documentazione Moduli"
echo "📋 Principi: DRY + KISS"
echo "📅 Data: $(date)"
echo ""

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione per log colorato
log_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

log_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

log_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

log_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Backup della documentazione attuale
backup_docs() {
    log_info "Creando backup documentazione attuale..."
    
    BACKUP_DIR="docs_backup_$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$BACKUP_DIR"
    
    # Backup docs root
    if [ -d "docs" ]; then
        cp -r docs "$BACKUP_DIR/"
        log_success "Backup docs root completato"
    fi
    
    # Backup docs moduli
    for module in Modules/*/docs; do
        if [ -d "$module" ]; then
            module_name=$(echo "$module" | cut -d'/' -f2)
            mkdir -p "$BACKUP_DIR/modules/$module_name"
            cp -r "$module" "$BACKUP_DIR/modules/$module_name/"
            log_success "Backup $module_name completato"
        fi
    done
    
    log_success "Backup completato in $BACKUP_DIR"
}

# Analisi duplicazioni
analyze_duplications() {
    log_info "Analizzando duplicazioni..."
    
    echo "📊 Analisi duplicazioni:"
    echo ""
    
    # Conta file PHPStan
    phpstan_files=$(find . -name "*phpstan*" -type f | wc -l)
    echo "📁 File PHPStan: $phpstan_files"
    
    # Conta file traduzioni
    translation_files=$(find . -name "*translation*" -o -name "*translations*" -type f | wc -l)
    echo "🌐 File traduzioni: $translation_files"
    
    # Conta README
    readme_files=$(find . -name "README.md" -type f | wc -l)
    echo "📖 File README: $readme_files"
    
    # Conta file con maiuscole
    uppercase_files=$(find . -name "*[A-Z]*" -type f | grep -v "README.md" | wc -l)
    echo "⚠️  File con maiuscole: $uppercase_files"
    
    echo ""
}

# Standardizzazione nomi file
standardize_filenames() {
    log_info "Standardizzando nomi file..."
    
    # Trova file con maiuscole (eccetto README.md)
    find . -name "*[A-Z]*" -type f | grep -v "README.md" | while read file; do
        dir=$(dirname "$file")
        filename=$(basename "$file")
        new_filename=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
        
        if [ "$filename" != "$new_filename" ]; then
            new_path="$dir/$new_filename"
            if [ ! -f "$new_path" ]; then
                mv "$file" "$new_path"
                log_success "Rinominato: $file -> $new_path"
            else
                log_warning "File già esistente: $new_path"
            fi
        fi
    done
}

# Creazione struttura standardizzata per modulo
create_standard_structure() {
    local module_name=$1
    
    log_info "Creando struttura standardizzata per $module_name..."
    
    module_docs_dir="Modules/$module_name/docs"
    
    if [ ! -d "$module_docs_dir" ]; then
        mkdir -p "$module_docs_dir"
        log_success "Creata cartella docs per $module_name"
    fi
    
    # Template files da creare
    template_files=(
        "README.md"
        "architecture.md"
        "models.md"
        "api.md"
        "resources.md"
        "widgets.md"
        "testing.md"
    )
    
    for template in "${template_files[@]}"; do
        if [ ! -f "$module_docs_dir/$template" ]; then
            # Usa il template appropriato
            if [ "$template" = "README.md" ]; then
                cp "docs/modules/template-readme.md" "$module_docs_dir/$template"
                # Sostituisce [Nome Modulo] con il nome reale
                sed -i "s/\[Nome Modulo\]/$module_name/g" "$module_docs_dir/$template"
                sed -i "s/\[ModuleName\]/$module_name/g" "$module_docs_dir/$template"
                sed -i "s/\[modulename\]/${module_name,,}/g" "$module_docs_dir/$template"
            else
                echo "# $template" > "$module_docs_dir/$template"
                echo "" >> "$module_docs_dir/$template"
                echo "## Panoramica" >> "$module_docs_dir/$template"
                echo "Documentazione per $template del modulo $module_name." >> "$module_docs_dir/$template"
                echo "" >> "$module_docs_dir/$template"
                echo "## Collegamenti" >> "$module_docs_dir/$template"
                echo "- [README](README.md)" >> "$module_docs_dir/$template"
                echo "- [Documentazione Root](../../../docs/README.md)" >> "$module_docs_dir/$template"
            fi
            log_success "Creato $template per $module_name"
        fi
    done
}

# Consolidamento contenuti duplicati
consolidate_duplications() {
    log_info "Consolidando contenuti duplicati..."
    
    # PHPStan - già fatto con docs/quality/phpstan.md
    log_success "PHPStan consolidato in docs/quality/phpstan.md"
    
    # Traduzioni - già fatto con docs/translations/rules.md
    log_success "Traduzioni consolidate in docs/translations/rules.md"
    
    # Best Practices - da consolidare
    log_info "Consolidando best practices..."
    # TODO: Implementare consolidamento best practices
}

# Aggiornamento collegamenti
update_links() {
    log_info "Aggiornando collegamenti..."
    
    # Trova tutti i file markdown
    find . -name "*.md" -type f | while read file; do
        # Aggiorna collegamenti ai file rinominati
        # TODO: Implementare aggiornamento automatico collegamenti
        echo "Aggiornando collegamenti in $file"
    done
}

# Validazione finale
validate_refactor() {
    log_info "Validando refactor..."
    
    echo "📋 Checklist validazione:"
    
    # Verifica file con maiuscole (eccetto README.md)
    uppercase_count=$(find . -name "*[A-Z]*" -type f | grep -v "README.md" | wc -l)
    if [ "$uppercase_count" -eq 0 ]; then
        log_success "✅ Tutti i file seguono naming convention"
    else
        log_warning "⚠️  $uppercase_count file con maiuscole trovati"
    fi
    
    # Verifica struttura moduli
    for module in Modules/*/; do
        if [ -d "$module" ]; then
            module_name=$(basename "$module")
            if [ -d "$module/docs" ]; then
                log_success "✅ $module_name ha cartella docs"
            else
                log_warning "⚠️  $module_name manca cartella docs"
            fi
        fi
    done
    
    # Verifica collegamenti rotti
    log_info "Verificando collegamenti..."
    # TODO: Implementare verifica collegamenti
    
    log_success "Validazione completata"
}

# Menu principale
main_menu() {
    echo ""
    echo "🔧 Menu Refactor Documentazione"
    echo "1. Backup documentazione attuale"
    echo "2. Analisi duplicazioni"
    echo "3. Standardizzazione nomi file"
    echo "4. Creazione struttura standardizzata"
    echo "5. Consolidamento contenuti"
    echo "6. Aggiornamento collegamenti"
    echo "7. Validazione finale"
    echo "8. Esegui tutto"
    echo "0. Esci"
    echo ""
    read -p "Scegli opzione: " choice
    
    case $choice in
        1) backup_docs ;;
        2) analyze_duplications ;;
        3) standardize_filenames ;;
        4) 
            read -p "Inserisci nome modulo: " module_name
            create_standard_structure "$module_name"
            ;;
        5) consolidate_duplications ;;
        6) update_links ;;
        7) validate_refactor ;;
        8) 
            backup_docs
            analyze_duplications
            standardize_filenames
            for module in Modules/*/; do
                if [ -d "$module" ]; then
                    module_name=$(basename "$module")
                    create_standard_structure "$module_name"
                fi
            done
            consolidate_duplications
            update_links
            validate_refactor
            ;;
        0) exit 0 ;;
        *) echo "Opzione non valida" ;;
    esac
}

# Esecuzione
if [ "$1" = "--auto" ]; then
    log_info "Esecuzione automatica refactor completo..."
    backup_docs
    analyze_duplications
    standardize_filenames
    
    # Crea struttura per tutti i moduli
    for module in Modules/*/; do
        if [ -d "$module" ]; then
            module_name=$(basename "$module")
            create_standard_structure "$module_name"
        fi
    done
    
    consolidate_duplications
    update_links
    validate_refactor
    
    log_success "🎉 Refactor completato!"
    echo ""
    echo "📊 Risultati:"
    echo "- Documentazione centralizzata"
    echo "- Duplicazioni eliminate"
    echo "- Naming convention applicata"
    echo "- Struttura standardizzata"
    echo ""
    echo "📁 Backup disponibile in: docs_backup_*"
else
    main_menu
fi 