#!/bin/bash

# Script per analizzare tutti i moduli Laravel con PHPStan
# Autore: Claude
# Data: $(date +%Y-%m-%d)

# Colori per l'output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione per trovare la directory Laravel
find_laravel_dir() {
    if [ -f "artisan" ]; then
        echo "."
        return 0
    elif [ -d "laravel" ] && [ -f "laravel/artisan" ]; then
        echo "laravel"
        return 0
    else
        echo ""
        return 1
    fi
}

# Banner
echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}   Analisi dei moduli Laravel con PHPStan         ${NC}"
echo -e "${BLUE}=================================================${NC}"
echo ""

# Trova la directory Laravel
LARAVEL_DIR=$(find_laravel_dir)

if [ -z "$LARAVEL_DIR" ]; then
    echo -e "${RED}Errore: Non è possibile trovare la directory Laravel.${NC}"
    echo -e "${RED}Assicurati di eseguire questo script dalla directory principale del progetto o dalla directory Laravel.${NC}"
    exit 1
fi

# Cambia alla directory Laravel se necessario
if [ "$LARAVEL_DIR" != "." ]; then
    cd "$LARAVEL_DIR"
    echo -e "${YELLOW}Cambiata directory in: $(pwd)${NC}"
fi

# Verifica che PHPStan sia installato
if [ ! -f "vendor/bin/phpstan" ]; then
    echo -e "${RED}Errore: PHPStan non trovato in vendor/bin/phpstan${NC}"
    echo -e "${RED}Assicurati che PHPStan sia installato correttamente.${NC}"
    exit 1
fi

# Verifica che la directory dei moduli esista
if [ ! -d "Modules" ]; then
    echo -e "${RED}Errore: Directory 'Modules' non trovata.${NC}"
    echo -e "${RED}Assicurati di essere nella directory corretta.${NC}"
    exit 1
fi

# Imposta il livello massimo di analisi
MAX_LEVEL=9
EXTRA_LEVELS=("max")

# Ottieni l'elenco dei moduli
MODULES=$(find "Modules" -maxdepth 1 -mindepth 1 -type d)

if [ -z "$MODULES" ]; then
    echo -e "${RED}Errore: Nessun modulo trovato nella directory Modules.${NC}"
    exit 1
fi

echo -e "${BLUE}Trovati i seguenti moduli:${NC}"
for MODULE in $MODULES; do
    echo -e "  - $(basename "$MODULE")"
done
echo ""

# Funzione per convertire gli errori JSON in markdown con suggerimenti
json_to_markdown() {
    local MODULE_NAME="$1"
    local LEVEL="$2"
    local JSON_FILE="$3"
    local MD_FILE="$4"

    # Leggi il file JSON
    if [ ! -f "$JSON_FILE" ]; then
        echo -e "${RED}Errore: File JSON non trovato: $JSON_FILE${NC}"
        return 1
    fi

    # Inizia a creare il file markdown
    echo "# Rapporto PHPStan Livello $LEVEL per il modulo $MODULE_NAME" > "$MD_FILE"
    echo "" >> "$MD_FILE"
    echo "Data analisi: $(date '+%Y-%m-%d %H:%M:%S')" >> "$MD_FILE"
    echo "" >> "$MD_FILE"

    # Estrai il numero di errori
    local ERROR_COUNT=$(grep -o '"file_errors":[0-9]*' "$JSON_FILE" | cut -d':' -f2)

    if [ -z "$ERROR_COUNT" ] || [ "$ERROR_COUNT" -eq "0" ]; then
        echo "🎉 **Congratulazioni!** Nessun errore trovato a questo livello." >> "$MD_FILE"
        return 0
    fi

    echo "## Riepilogo" >> "$MD_FILE"
    echo "" >> "$MD_FILE"
    echo "Trovati $ERROR_COUNT errori al livello $LEVEL." >> "$MD_FILE"
    echo "" >> "$MD_FILE"
    echo "## Errori e suggerimenti" >> "$MD_FILE"
    echo "" >> "$MD_FILE"

    # Analizza gli errori
    local CURRENT_FILE=""
    local IS_IN_MESSAGES=0

    # Usa jq se disponibile, altrimenti fallback a grep e sed
    if command -v jq &> /dev/null; then
        # Estrai gli errori con jq
        jq -r '.files | to_entries[] | "\(.key)|\(.value.messages[] | "\(.line)|\(.message)");"' "$JSON_FILE" | while IFS='|' read -r FILE LINE_MSG; do
            if [[ "$LINE_MSG" == *";"* ]]; then
                if [ "$FILE" != "$CURRENT_FILE" ]; then
                    CURRENT_FILE="$FILE"
                    echo "### File: \`$CURRENT_FILE\`" >> "$MD_FILE"
                    echo "" >> "$MD_FILE"
                fi

                LINE=$(echo "$LINE_MSG" | cut -d'|' -f1)
                MSG=$(echo "$LINE_MSG" | cut -d'|' -f2 | sed 's/;$//')

                echo "#### Linea $LINE: $MSG" >> "$MD_FILE"
                echo "" >> "$MD_FILE"

                # Aggiungi suggerimenti in base al tipo di errore
                if [[ "$MSG" == *"undefined method"* ]]; then
                    echo "**Suggerimento**: Questo metodo non esiste o non è accessibile. Verifica:" >> "$MD_FILE"
                    echo "- Se il metodo è definito nella classe" >> "$MD_FILE"
                    echo "- Se il metodo ha la visibilità corretta (public/protected/private)" >> "$MD_FILE"
                    echo "- Se stai importando la classe corretta" >> "$MD_FILE"
                    echo "- Se ci sono errori di digitazione nel nome del metodo" >> "$MD_FILE"
                elif [[ "$MSG" == *"undefined property"* ]]; then
                    echo "**Suggerimento**: Questa proprietà non esiste o non è accessibile. Verifica:" >> "$MD_FILE"
                    echo "- Se la proprietà è definita nella classe" >> "$MD_FILE"
                    echo "- Se la proprietà ha la visibilità corretta" >> "$MD_FILE"
                    echo "- Se stai usando un trait che definisce questa proprietà" >> "$MD_FILE"
                    echo "- Se la proprietà è impostata nel costruttore o in altri metodi" >> "$MD_FILE"
                elif [[ "$MSG" == *"typehint"* ]] || [[ "$MSG" == *"return type"* ]]; then
                    echo "**Suggerimento**: C'è un problema con i type hint. Considera:" >> "$MD_FILE"
                    echo "- Aggiungere type hints espliciti ai parametri" >> "$MD_FILE"
                    echo "- Aggiungere il tipo di ritorno al metodo" >> "$MD_FILE"
                    echo "- Usare union types (e.g., \`string|int\`) o nullable types (e.g., \`?string\`) se necessario" >> "$MD_FILE"
                    echo "- Verificare che i tipi siano coerenti con la documentazione PHPDoc" >> "$MD_FILE"
                else
                    echo "**Suggerimento generale**: Rivedi il codice per assicurarti che:" >> "$MD_FILE"
                    echo "- Tutte le classi/interfacce utilizzate siano importate correttamente" >> "$MD_FILE"
                    echo "- I tipi siano dichiarati e utilizzati in modo coerente" >> "$MD_FILE"
                    echo "- Le variabili siano inizializzate prima dell'uso" >> "$MD_FILE"
                    echo "- I nomi di metodi e proprietà siano corretti" >> "$MD_FILE"
                fi

                echo "" >> "$MD_FILE"
            fi
        done
    else
        # Fallback usando grep e sed
        grep -o '"[^"]*":{"messages":\[.*\]}' "$JSON_FILE" | while read -r LINE; do
            FILE=$(echo "$LINE" | grep -o '"[^"]*":{"messages"' | sed 's/":{"messages"//g' | sed 's/"//g')

            if [ "$FILE" != "$CURRENT_FILE" ]; then
                CURRENT_FILE="$FILE"
                echo "### File: \`$CURRENT_FILE\`" >> "$MD_FILE"
                echo "" >> "$MD_FILE"
            fi

            # Estrai messaggi
            echo "$LINE" | grep -o '{"line":[0-9]*,"message":"[^"]*"' | while read -r MSG_LINE; do
                LINE_NUM=$(echo "$MSG_LINE" | grep -o '"line":[0-9]*' | cut -d':' -f2)
                MSG=$(echo "$MSG_LINE" | grep -o '"message":"[^"]*"' | sed 's/"message":"//g' | sed 's/"$//g')

                echo "#### Linea $LINE_NUM: $MSG" >> "$MD_FILE"
                echo "" >> "$MD_FILE"

                # Aggiungi suggerimenti in base al tipo di errore
                if [[ "$MSG" == *"undefined method"* ]]; then
                    echo "**Suggerimento**: Questo metodo non esiste o non è accessibile. Verifica:" >> "$MD_FILE"
                    echo "- Se il metodo è definito nella classe" >> "$MD_FILE"
                    echo "- Se il metodo ha la visibilità corretta (public/protected/private)" >> "$MD_FILE"
                    echo "- Se stai importando la classe corretta" >> "$MD_FILE"
                    echo "- Se ci sono errori di digitazione nel nome del metodo" >> "$MD_FILE"
                elif [[ "$MSG" == *"undefined property"* ]]; then
                    echo "**Suggerimento**: Questa proprietà non esiste o non è accessibile. Verifica:" >> "$MD_FILE"
                    echo "- Se la proprietà è definita nella classe" >> "$MD_FILE"
                    echo "- Se la proprietà ha la visibilità corretta" >> "$MD_FILE"
                    echo "- Se stai usando un trait che definisce questa proprietà" >> "$MD_FILE"
                    echo "- Se la proprietà è impostata nel costruttore o in altri metodi" >> "$MD_FILE"
                elif [[ "$MSG" == *"typehint"* ]] || [[ "$MSG" == *"return type"* ]]; then
                    echo "**Suggerimento**: C'è un problema con i type hint. Considera:" >> "$MD_FILE"
                    echo "- Aggiungere type hints espliciti ai parametri" >> "$MD_FILE"
                    echo "- Aggiungere il tipo di ritorno al metodo" >> "$MD_FILE"
                    echo "- Usare union types (e.g., \`string|int\`) o nullable types (e.g., \`?string\`) se necessario" >> "$MD_FILE"
                    echo "- Verificare che i tipi siano coerenti con la documentazione PHPDoc" >> "$MD_FILE"
                else
                    echo "**Suggerimento generale**: Rivedi il codice per assicurarti che:" >> "$MD_FILE"
                    echo "- Tutte le classi/interfacce utilizzate siano importate correttamente" >> "$MD_FILE"
                    echo "- I tipi siano dichiarati e utilizzati in modo coerente" >> "$MD_FILE"
                    echo "- Le variabili siano inizializzate prima dell'uso" >> "$MD_FILE"
                    echo "- I nomi di metodi e proprietà siano corretti" >> "$MD_FILE"
                fi

                echo "" >> "$MD_FILE"
            done
        done
    fi

    # Aggiungi risorse utili
    echo "## Risorse utili" >> "$MD_FILE"
    echo "" >> "$MD_FILE"
    echo "- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)" >> "$MD_FILE"
    echo "- [Tipi in PHP](https://www.php.net/manual/en/language.types.declarations.php)" >> "$MD_FILE"
    echo "- [PSR-12: Standard di codifica](https://www.php-fig.org/psr/psr-12/)" >> "$MD_FILE"
}

# Analizza ogni modulo
for MODULE in $MODULES; do
    MODULE_NAME=$(basename "$MODULE")
    APP_DIR="$MODULE/app"

    # Salta se la directory app non esiste
    if [ ! -d "$APP_DIR" ]; then
        echo -e "${YELLOW}⚠️ Modulo ${MODULE_NAME}: Directory app non trovata. Saltato.${NC}"
        continue
    fi

    echo -e "${BLUE}📂 Analisi del modulo: ${MODULE_NAME}${NC}"

    # Crea la directory per i report PHPStan
    PHPSTAN_DIR="$MODULE/docs/phpstan"
    mkdir -p "$PHPSTAN_DIR"

    if [ ! -d "$PHPSTAN_DIR" ]; then
        echo -e "${RED}❌ Impossibile creare la directory ${PHPSTAN_DIR}. Saltato.${NC}"
        continue
    fi

    # Analizza il modulo per ogni livello numerico
    for LEVEL in $(seq 1 $MAX_LEVEL); do
        echo -e "  ${YELLOW}🔍 Livello ${LEVEL}...${NC}"

        # File di output
        OUTPUT_JSON="$PHPSTAN_DIR/level_${LEVEL}.json"
        OUTPUT_MD="$PHPSTAN_DIR/level_${LEVEL}.md"

        # Esegui PHPStan
        php vendor/bin/phpstan analyse --level="$LEVEL" --error-format=json "$APP_DIR" > "$OUTPUT_JSON" 2>/dev/null

        # Verifica se l'analisi è stata completata
        if [ ! -f "$OUTPUT_JSON" ] || [ ! -s "$OUTPUT_JSON" ]; then
            echo -e "  ${RED}❌ Errore nell'esecuzione di PHPStan al livello ${LEVEL}.${NC}"
            continue
        fi

        # Estrai il numero di errori
        ERROR_COUNT=$(grep -o '"file_errors":[0-9]*' "$OUTPUT_JSON" | cut -d':' -f2)

        if [ -z "$ERROR_COUNT" ]; then
            ERROR_COUNT="0"
        fi

        # Genera il file markdown con suggerimenti
        json_to_markdown "$MODULE_NAME" "$LEVEL" "$OUTPUT_JSON" "$OUTPUT_MD"

        if [ "$ERROR_COUNT" -eq "0" ]; then
            echo -e "  ${GREEN}✅ Livello ${LEVEL}: Nessun errore trovato.${NC}"
        else
            echo -e "  ${RED}⚠️ Livello ${LEVEL}: Trovati ${ERROR_COUNT} errori.${NC}"
        fi
    done

    # Analizza i livelli extra (max)
    for LEVEL in "${EXTRA_LEVELS[@]}"; do
        echo -e "  ${YELLOW}🔍 Livello ${LEVEL}...${NC}"

        # File di output
        OUTPUT_JSON="$PHPSTAN_DIR/level_${LEVEL}.json"
        OUTPUT_MD="$PHPSTAN_DIR/level_${LEVEL}.md"

        # Esegui PHPStan
        php vendor/bin/phpstan analyse --level="$LEVEL" --error-format=json "$APP_DIR" > "$OUTPUT_JSON" 2>/dev/null

        # Verifica se l'analisi è stata completata
        if [ ! -f "$OUTPUT_JSON" ] || [ ! -s "$OUTPUT_JSON" ]; then
            echo -e "  ${RED}❌ Errore nell'esecuzione di PHPStan al livello ${LEVEL}.${NC}"
            continue
        fi

        # Estrai il numero di errori
        ERROR_COUNT=$(grep -o '"file_errors":[0-9]*' "$OUTPUT_JSON" | cut -d':' -f2)

        if [ -z "$ERROR_COUNT" ]; then
            ERROR_COUNT="0"
        fi

        # Genera il file markdown con suggerimenti
        json_to_markdown "$MODULE_NAME" "$LEVEL" "$OUTPUT_JSON" "$OUTPUT_MD"

        if [ "$ERROR_COUNT" -eq "0" ]; then
            echo -e "  ${GREEN}✅ Livello ${LEVEL}: Nessun errore trovato.${NC}"
        else
            echo -e "  ${RED}⚠️ Livello ${LEVEL}: Trovati ${ERROR_COUNT} errori.${NC}"
        fi
    done

    echo -e "${GREEN}✅ Analisi completata per il modulo ${MODULE_NAME}.${NC}"
    echo ""
done

# Risultato finale
echo -e "${GREEN}=================================================${NC}"
echo -e "${GREEN}Analisi completata per tutti i moduli!${NC}"
echo -e "${GREEN}=================================================${NC}"
echo -e "I risultati sono disponibili nelle cartelle docs/phpstan di ogni modulo."
echo -e "Per ogni livello di analisi, è presente sia un file JSON che un file Markdown."
echo -e "\n${YELLOW}Nota${NC}: Usa i file MD per ottenere suggerimenti su come risolvere gli errori."

exit 0
