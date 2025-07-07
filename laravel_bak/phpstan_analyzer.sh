#!/bin/bash

# Script per analizzare tutti i moduli Laravel con PHPStan
# Autore: Cascade AI
# Data: 2025-04-15

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione per stampare messaggi informativi
info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

# Funzione per stampare messaggi di successo
success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

# Funzione per stampare messaggi di avviso
warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Funzione per stampare messaggi di errore
error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Funzione per creare un file markdown con suggerimenti per la correzione
create_markdown_report() {
    local module=$1
    local level=$2
    local json_file=$3
    local md_file="${json_file%.json}.md"
    
    info "Creazione report markdown per $module livello $level"
    
    # Intestazione del report
    cat > "$md_file" << EOL
# PHPStan Livello $level - Report per il modulo $module

Data: $(date '+%Y-%m-%d %H:%M:%S')

EOL
    
    # Verifica se il file JSON esiste e contiene dati validi
    if [ ! -s "$json_file" ] || ! jq -e . "$json_file" > /dev/null 2>&1; then
        # File JSON vuoto o non valido
        cat >> "$md_file" << EOL
## ✅ Nessun errore rilevato

L'analisi PHPStan di livello $level è stata completata con successo senza errori.
EOL
        return
    fi
    
    # Estrai il numero di errori
    local error_count=$(jq -r '.totals.file_errors // 0' "$json_file")
    
    if [ "$error_count" = "0" ] || [ "$error_count" = "null" ]; then
        # Nessun errore trovato
        cat >> "$md_file" << EOL
## ✅ Nessun errore rilevato

L'analisi PHPStan di livello $level è stata completata con successo senza errori.
EOL
        return
    fi
    
    # Ci sono errori, crea la sezione degli errori
    cat >> "$md_file" << EOL
## ❌ Errori rilevati

Sono stati rilevati $error_count errori durante l'analisi PHPStan di livello $level.

| File | Riga | Errore | Suggerimento |
|------|------|--------|-------------|
EOL
    
    # Estrai gli errori e aggiungili alla tabella
    jq -r '
        if .files then
            .files | to_entries[] | 
            .key as $file | 
            .value.messages[] | 
            [$file, .line, .message] | 
            @tsv
        else
            empty
        end
    ' "$json_file" | while IFS=$'\t' read -r file line message; do
        # Genera un suggerimento in base al tipo di errore
        local suggestion=""
        
        if [[ "$message" == *"undefined method"* ]]; then
            suggestion="Verificare che il metodo esista nella classe o che sia accessibile."
        elif [[ "$message" == *"undefined property"* ]]; then
            suggestion="Definire la proprietà mancante nella classe o verificare che sia accessibile."
        elif [[ "$message" == *"Parameter"*"has no type specified"* ]]; then
            suggestion="Aggiungere un tipo esplicito al parametro."
        elif [[ "$message" == *"has no return type specified"* ]]; then
            suggestion="Aggiungere un tipo di ritorno esplicito al metodo."
        elif [[ "$message" == *"has invalid type"* ]]; then
            suggestion="Correggere il tipo specificato."
        elif [[ "$message" == *"does not exist"* ]]; then
            suggestion="Verificare il namespace o importare la classe mancante."
        elif [[ "$message" == *"expects"*"got"* ]]; then
            suggestion="Verificare che il tipo passato corrisponda al tipo atteso."
        elif [[ "$message" == *"should return"*"returns"* ]]; then
            suggestion="Correggere il tipo di ritorno del metodo."
        else
            suggestion="Analizzare l'errore e apportare le correzioni necessarie."
        fi
        
        # Aggiungi la riga alla tabella, con escape per i caratteri speciali in markdown
        echo "| \`${file//|/\\|}\` | ${line//|/\\|} | ${message//|/\\|} | ${suggestion//|/\\|} |" >> "$md_file"
    done
    
    # Aggiungi la sezione dei suggerimenti generali
    cat >> "$md_file" << EOL

## 🔍 Come correggere gli errori

### Suggerimenti generali

1. **Tipizzazione stretta**: Assicurarsi che tutti i parametri e i valori di ritorno abbiano tipi espliciti.
2. **Controllo dei null**: Utilizzare i tipi nullable (es. \`?string\`) quando appropriato.
3. **PHPDoc accurati**: Mantenere i commenti PHPDoc aggiornati e coerenti con la firma dei metodi.
4. **Importare le classi**: Utilizzare le dichiarazioni \`use\` per importare le classi utilizzate.
5. **Verificare i namespace**: Assicurarsi che i namespace siano corretti.

### Passaggi successivi

1. Correggere gli errori partendo dai più semplici.
2. Eseguire nuovamente l'analisi PHPStan dopo ogni serie di correzioni.
3. Una volta risolti tutti gli errori di livello $level, procedere al livello successivo.

Per ulteriori informazioni, consultare la [documentazione ufficiale di PHPStan](https://phpstan.org/user-guide/getting-started).
EOL
}

# Verifica se la directory laravel esiste nel workspace
LARAVEL_DIR="/var/www/html/saluteora/laravel"
if [ ! -d "$LARAVEL_DIR" ]; then
    error "Directory Laravel non trovata in $LARAVEL_DIR"
    exit 1
fi

# Verifica se PHPStan è installato
if [ ! -f "$LARAVEL_DIR/vendor/bin/phpstan" ]; then
    error "PHPStan non trovato in $LARAVEL_DIR/vendor/bin/phpstan"
    exit 1
fi

# Verifica se jq è installato (necessario per elaborare i file JSON)
if ! command -v jq &> /dev/null; then
    warning "Il comando 'jq' non è installato. Verrà installato automaticamente."
    apt-get update && apt-get install -y jq
fi

# Vai alla directory laravel
cd "$LARAVEL_DIR" || { error "Impossibile accedere alla directory $LARAVEL_DIR"; exit 1; }

# Trova tutti i moduli
MODULES_DIR="$LARAVEL_DIR/Modules"
MODULES=$(find "$MODULES_DIR" -maxdepth 1 -type d -not -path "$MODULES_DIR" -exec basename {} \;)

# Livello massimo di PHPStan da analizzare
MAX_LEVEL=9

info "Inizio analisi PHPStan per tutti i moduli..."

# Analizza ogni modulo
for MODULE in $MODULES; do
    MODULE_PATH="$MODULES_DIR/$MODULE"
    APP_DIR="$MODULE_PATH/app"
    
    # Verifica se la directory app esiste
    if [ ! -d "$APP_DIR" ]; then
        warning "Directory app non trovata in $MODULE. Saltando..."
        continue
    fi
    
    info "Analizzando il modulo: $MODULE"
    
    # Crea la directory phpstan se non esiste
    PHPSTAN_DIR="$MODULE_PATH/docs/phpstan"
    mkdir -p "$PHPSTAN_DIR"
    
    # Analizza il modulo per ogni livello
    for LEVEL in $(seq 1 $MAX_LEVEL); do
        JSON_FILE="$PHPSTAN_DIR/level_$LEVEL.json"
        
        info "Eseguendo PHPStan livello $LEVEL per $MODULE..."
        
        # Esegui PHPStan e salva l'output in formato JSON
        php vendor/bin/phpstan analyse --level=$LEVEL --error-format=json "$APP_DIR" > "$JSON_FILE" 2>/dev/null
        PHPSTAN_EXIT_CODE=$?
        
        # Verifica se l'analisi è stata completata con successo
        if [ $PHPSTAN_EXIT_CODE -eq 0 ]; then
            # Se non ci sono errori, crea un file JSON vuoto con la struttura corretta
            echo '{"totals":{"errors":0,"file_errors":0},"files":{}}' > "$JSON_FILE"
            success "Analisi PHPStan livello $LEVEL completata senza errori per $MODULE"
        else
            warning "Analisi PHPStan livello $LEVEL completata con errori per $MODULE"
        fi
        
        # Crea il report markdown
        create_markdown_report "$MODULE" "$LEVEL" "$JSON_FILE"
        
        # Se ci sono errori a questo livello, non procedere ai livelli successivi
        if [ $PHPSTAN_EXIT_CODE -ne 0 ]; then
            warning "Interrompendo l'analisi per $MODULE al livello $LEVEL a causa di errori"
            break
        fi
    done
    
    success "Analisi completata per il modulo $MODULE"
done

success "Analisi PHPStan completata per tutti i moduli"
info "I risultati sono disponibili nelle directory Modules/*/docs/phpstan/"
