#!/bin/bash

# Script per riorganizzare sistematicamente la documentazione Laraxot
# Consolida file duplicati, organizza per tematiche, migliora la struttura

set -e

echo "🔧 RIORGANIZZAZIONE SISTEMATICA DOCUMENTAZIONE LARAXOT"
echo "======================================================"
echo ""

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Contatori
files_moved=0
duplicates_removed=0
folders_created=0

# Funzione per consolidare duplicati
consolidate_duplicates() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    
    echo -e "${BLUE}🔄 Consolidamento duplicati in: $module_name${NC}"
    
    # Trova e consolida file con nomi simili
    find "$docs_dir" -name "*.md" -type f | while read file; do
        basename_file=$(basename "$file" .md)
        
        # Cerca versione con underscore
        underscore_version=$(echo "$basename_file" | sed 's/-/_/g')
        underscore_file="$docs_dir/${underscore_version}.md"
        
        if [ -f "$underscore_file" ] && [ "$file" != "$underscore_file" ]; then
            # Confronta dimensioni e mantieni il più grande
            size1=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file")
            size2=$(stat -f%z "$underscore_file" 2>/dev/null || stat -c%s "$underscore_file")
            
            if [ "$size1" -gt "$size2" ]; then
                echo "  📄 Rimuovo duplicato più piccolo: $(basename "$underscore_file")"
                rm "$underscore_file"
            else
                echo "  📄 Rimuovo duplicato più piccolo: $(basename "$file")"
                rm "$file"
            fi
            ((duplicates_removed++))
        fi
    done
}

# Funzione per creare struttura organizzata
create_organized_structure() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    
    echo -e "${BLUE}📁 Creazione struttura organizzata per: $module_name${NC}"
    
    # Crea cartelle tematiche standard se non esistono
    local standard_folders=("architecture" "best-practices" "examples" "troubleshooting" "api" "configuration")
    
    for folder in "${standard_folders[@]}"; do
        if [ ! -d "$docs_dir/$folder" ]; then
            mkdir -p "$docs_dir/$folder"
            echo "  ✅ Creata cartella: $folder"
            ((folders_created++))
        fi
    done
    
    # Sposta file in base al contenuto/nome
    find "$docs_dir" -maxdepth 1 -name "*.md" -type f | while read file; do
        filename=$(basename "$file")
        moved=false
        
        # Regole di categorizzazione
        case "$filename" in
            *architecture*|*structure*|*design*)
                if [ ! -f "$docs_dir/architecture/$filename" ]; then
                    mv "$file" "$docs_dir/architecture/"
                    echo "  📄 $filename → architecture/"
                    ((files_moved++))
                    moved=true
                fi
                ;;
            *best-practice*|*guideline*|*convention*)
                if [ ! -f "$docs_dir/best-practices/$filename" ]; then
                    mv "$file" "$docs_dir/best-practices/"
                    echo "  📄 $filename → best-practices/"
                    ((files_moved++))
                    moved=true
                fi
                ;;
            *example*|*sample*|*demo*)
                if [ ! -f "$docs_dir/examples/$filename" ]; then
                    mv "$file" "$docs_dir/examples/"
                    echo "  📄 $filename → examples/"
                    ((files_moved++))
                    moved=true
                fi
                ;;
            *troubleshoot*|*error*|*fix*|*debug*)
                if [ ! -f "$docs_dir/troubleshooting/$filename" ]; then
                    mv "$file" "$docs_dir/troubleshooting/"
                    echo "  📄 $filename → troubleshooting/"
                    ((files_moved++))
                    moved=true
                fi
                ;;
            *api*|*endpoint*|*route*)
                if [ ! -f "$docs_dir/api/$filename" ]; then
                    mv "$file" "$docs_dir/api/"
                    echo "  📄 $filename → api/"
                    ((files_moved++))
                    moved=true
                fi
                ;;
            *config*|*setting*|*environment*)
                if [ ! -f "$docs_dir/configuration/$filename" ]; then
                    mv "$file" "$docs_dir/configuration/"
                    echo "  📄 $filename → configuration/"
                    ((files_moved++))
                    moved=true
                fi
                ;;
        esac
    done
}

# Funzione per creare/aggiornare README principale
create_main_readme() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    
    echo -e "${BLUE}📝 Aggiornamento README principale per: $module_name${NC}"
    
    cat > "$docs_dir/README.md" << EOF
# $module_name Module Documentation

## Overview

This directory contains comprehensive documentation for the $module_name module in the Laraxot framework.

## Documentation Structure

### 📁 Core Documentation
- [Architecture](./architecture/) - Module architecture and design patterns
- [Best Practices](./best-practices/) - Development guidelines and conventions
- [Configuration](./configuration/) - Setup and configuration guides

### 🔧 Development
- [API Documentation](./api/) - API endpoints and usage
- [Examples](./examples/) - Code examples and samples
- [Troubleshooting](./troubleshooting/) - Common issues and solutions

### 📋 Standards
- **Naming**: All files use lowercase with hyphens (kebab-case)
- **Language**: Documentation in English for consistency
- **Format**: Markdown with proper structure and linking

## Quick Start

1. Read the [Architecture Overview](./architecture/README.md)
2. Review [Best Practices](./best-practices/README.md)
3. Check [Configuration Guide](./configuration/README.md)

## Contributing

When adding documentation:
- Follow the established structure
- Use lowercase filenames with hyphens
- Create bidirectional links
- Update this README if adding new sections

## Links

### Related Modules
- [Xot Module](../Xot/docs/)
- [UI Module](../UI/docs/)
- [User Module](../User/docs/)

### Project Documentation
- [Root Documentation](../../../docs/)
- [Laraxot Framework Guide](../../../docs/laraxot-framework.md)

---

*Last updated: $(date +%Y-%m-%d)*
*Module: $module_name*
*Framework: Laraxot*
EOF

    echo "  ✅ README.md aggiornato"
}

# Funzione per rimuovere cartelle vuote
cleanup_empty_folders() {
    local docs_dir="$1"
    
    echo -e "${BLUE}🧹 Pulizia cartelle vuote${NC}"
    
    # Rimuovi cartelle vuote (ricorsivamente)
    find "$docs_dir" -type d -empty -delete 2>/dev/null || true
    
    echo "  ✅ Cartelle vuote rimosse"
}

echo "🎯 FASE 1: MODULI CORE"
echo "====================="

# Riorganizza moduli core
for module in "Xot" "UI" "User"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        echo -e "${GREEN}🔧 Riorganizzazione: $module${NC}"
        
        consolidate_duplicates "$docs_dir"
        create_organized_structure "$docs_dir"
        create_main_readme "$docs_dir"
        cleanup_empty_folders "$docs_dir"
    fi
done

echo ""
echo "🎯 FASE 2: MODULI APPLICATIVI"
echo "============================="

# Riorganizza moduli applicativi
for module in "SaluteOra" "SaluteMo"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        echo -e "${GREEN}🔧 Riorganizzazione: $module${NC}"
        
        consolidate_duplicates "$docs_dir"
        create_organized_structure "$docs_dir"
        create_main_readme "$docs_dir"
        cleanup_empty_folders "$docs_dir"
    fi
done

echo ""
echo "📊 RIEPILOGO RIORGANIZZAZIONE"
echo "============================="
echo "📄 File spostati: $files_moved"
echo "🗑️  Duplicati rimossi: $duplicates_removed"
echo "📁 Cartelle create: $folders_created"

echo ""
echo -e "${GREEN}✅ Riorganizzazione completata!${NC}"
echo "📝 Tutti i moduli ora hanno una struttura documentazione standardizzata"
