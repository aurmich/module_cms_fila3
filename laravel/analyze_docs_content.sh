#!/bin/bash

# Script per analisi sistematica del contenuto delle cartelle docs/
# Identifica problemi di qualità, organizzazione e compliance Laraxot

set -e

echo "🔍 ANALISI SISTEMATICA DOCUMENTAZIONE LARAXOT"
echo "=============================================="
echo ""

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Contatori
total_docs=0
issues_found=0
duplicates_found=0

# Funzione per analizzare un file di documentazione
analyze_doc_file() {
    local file="$1"
    local issues=""
    
    # Controlla se il file contiene esempi obsoleti
    if grep -q "extends Resource" "$file" 2>/dev/null; then
        issues="${issues}❌ Estende Resource invece di XotBaseResource\n"
    fi
    
    if grep -q "->label(" "$file" 2>/dev/null; then
        issues="${issues}❌ Usa ->label() invece di traduzioni automatiche\n"
    fi
    
    if grep -q "level: [1-8]" "$file" 2>/dev/null; then
        issues="${issues}❌ PHPStan livello < 9\n"
    fi
    
    if grep -q "array()" "$file" 2>/dev/null; then
        issues="${issues}❌ Usa array() invece di []\n"
    fi
    
    if grep -q "namespace.*App\\\\" "$file" 2>/dev/null; then
        issues="${issues}❌ Namespace con segmento 'App'\n"
    fi
    
    # Controlla struttura traduzioni
    if grep -q "'field_name' => 'Label'" "$file" 2>/dev/null; then
        issues="${issues}❌ Struttura traduzioni piatta invece di espansa\n"
    fi
    
    # Controlla se mancano strict types negli esempi PHP
    if grep -q "<?php" "$file" 2>/dev/null && ! grep -q "declare(strict_types=1)" "$file" 2>/dev/null; then
        issues="${issues}⚠️  Esempi PHP senza declare(strict_types=1)\n"
    fi
    
    if [ -n "$issues" ]; then
        echo -e "${RED}📄 $file${NC}"
        echo -e "$issues"
        echo ""
        ((issues_found++))
    fi
}

# Funzione per trovare duplicati
find_duplicates() {
    local docs_dir="$1"
    echo -e "${BLUE}🔍 Ricerca duplicati in: $docs_dir${NC}"
    
    # Trova file con contenuto simile (stesso nome base)
    find "$docs_dir" -name "*.md" -type f | while read file; do
        basename_file=$(basename "$file" .md)
        # Cerca file con nomi simili (con underscore vs trattini)
        similar_name=$(echo "$basename_file" | sed 's/-/_/g')
        similar_file=$(find "$docs_dir" -name "${similar_name}.md" -type f | grep -v "^$file$" | head -1)
        
        if [ -n "$similar_file" ] && [ -f "$similar_file" ]; then
            echo -e "${YELLOW}🔄 Possibili duplicati:${NC}"
            echo "   - $file"
            echo "   - $similar_file"
            ((duplicates_found++))
        fi
    done
}

# Funzione per analizzare struttura cartelle
analyze_folder_structure() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    
    echo -e "${BLUE}📁 Analisi struttura: $module_name${NC}"
    
    # Verifica presenza README.md
    if [ ! -f "$docs_dir/README.md" ]; then
        echo -e "${RED}❌ Manca README.md${NC}"
        ((issues_found++))
    fi
    
    # Conta file e cartelle
    local file_count=$(find "$docs_dir" -name "*.md" -type f | wc -l)
    local dir_count=$(find "$docs_dir" -type d | wc -l)
    
    echo "   📊 File: $file_count, Cartelle: $dir_count"
    
    # Verifica organizzazione logica
    if [ "$file_count" -gt 20 ] && [ "$dir_count" -lt 3 ]; then
        echo -e "${YELLOW}⚠️  Molti file ($file_count) ma poche sottocartelle ($dir_count) - considerare riorganizzazione${NC}"
    fi
}

echo "🎯 FASE 1: ANALISI MODULI CORE"
echo "=============================="

# Analizza moduli core
for module in "Xot" "UI" "User"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        echo -e "${GREEN}🔍 Modulo Core: $module${NC}"
        analyze_folder_structure "$docs_dir"
        find_duplicates "$docs_dir"
        
        find "$docs_dir" -name "*.md" -type f | while read file; do
            analyze_doc_file "$file"
            ((total_docs++))
        done
    fi
done

echo ""
echo "🎯 FASE 2: ANALISI MODULI APPLICATIVI"
echo "====================================="

# Analizza moduli applicativi
for module in "SaluteOra" "SaluteMo"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        echo -e "${GREEN}🔍 Modulo Applicativo: $module${NC}"
        analyze_folder_structure "$docs_dir"
        find_duplicates "$docs_dir"
        
        find "$docs_dir" -name "*.md" -type f | while read file; do
            analyze_doc_file "$file"
            ((total_docs++))
        done
    fi
done

echo ""
echo "🎯 FASE 3: ANALISI ROOT DOCS"
echo "============================"

root_docs="/var/www/html/_bases/base_saluteora/laravel/docs"
if [ -d "$root_docs" ]; then
    echo ""
    echo -e "${GREEN}🔍 Documentazione Root${NC}"
    analyze_folder_structure "$root_docs"
    find_duplicates "$root_docs"
    
    find "$root_docs" -name "*.md" -type f | while read file; do
        analyze_doc_file "$file"
        ((total_docs++))
    done
fi

echo ""
echo "📊 RIEPILOGO ANALISI"
echo "===================="
echo "📄 Documenti analizzati: $total_docs"
echo "❌ Issues trovati: $issues_found"
echo "🔄 Duplicati trovati: $duplicates_found"

if [ "$issues_found" -gt 0 ] || [ "$duplicates_found" -gt 0 ]; then
    echo ""
    echo -e "${RED}🚨 AZIONE RICHIESTA: Correggere gli issues identificati${NC}"
    exit 1
else
    echo ""
    echo -e "${GREEN}✅ Documentazione conforme agli standard Laraxot${NC}"
fi
