#!/bin/bash

# Colori per l'output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Livello massimo di analisi PHPStan
MAX_LEVEL=8

echo "================================================="
echo "   Analisi dei moduli Laravel con PHPStan         "
echo "================================================="

# Trova tutti i moduli nella directory Modules
for module_dir in Modules/*/; do
    module_name=$(basename "$module_dir")

    # Verifica se esiste la directory app
    if [ ! -d "Modules/$module_name/app" ]; then
        echo -e "${RED}Directory app non trovata in $module_name, modulo saltato${NC}"
        continue
    fi

    echo -e "\n${YELLOW}Analisi del modulo $module_name${NC}"

    # Crea la directory docs/phpstan se non esiste
    docs_dir="Modules/${module_name}/docs/phpstan"
    if [ ! -d "$docs_dir" ]; then
        mkdir -p "$docs_dir"
        echo -e "${GREEN}Creata directory $docs_dir${NC}"
    fi

    # Analizza ogni livello
    for level in $(seq 1 $MAX_LEVEL); do
        echo -e "\n${YELLOW}Esecuzione analisi livello $level per $module_name${NC}"

        json_output="$docs_dir/level_${level}.json"
        md_output="$docs_dir/level_${level}.md"

        # Esegui PHPStan
        php vendor/bin/phpstan analyse "Modules/${module_name}/app" -l "$level" --error-format=json > "$json_output" 2>/dev/null

        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ Nessun errore trovato al livello $level${NC}"
            create_markdown_report "$module_name" "$level" "$json_output"
        else
            echo -e "${RED}✗ Trovati errori al livello $level${NC}"
            create_markdown_report "$module_name" "$level" "$json_output"
        fi
    done
done

echo -e "\n${GREEN}Analisi completata! I risultati sono disponibili nelle directory docs/phpstan di ogni modulo.${NC}"
