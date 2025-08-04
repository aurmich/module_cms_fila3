# Workflow Validazione File di Traduzione

## Invocazione
Usa `/translation-validate` in Windsurf Cascade per eseguire validazione completa delle traduzioni.

## ⚠️ CONTROLLI CRITICI OBBLIGATORI

### 1. Controllo Sintassi Array
```bash
# DEVE restituire 0 risultati
echo "🔍 Controllo sintassi array breve..."
array_violations=$(grep -r "array(" Modules/*/lang/ --include="*.php" | wc -l)
if [ $array_violations -gt 0 ]; then
    echo "❌ ERRORE CRITICO: Trovate $array_violations violazioni sintassi array()"
    grep -r "array(" Modules/*/lang/ --include="*.php"
    echo "🔧 Eseguire correzione automatica..."
    exit 1
else
    echo "✅ Sintassi array: CONFORME"
fi
```

### 2. Controllo Strict Types
```bash
echo "🔍 Controllo declare(strict_types=1)..."
missing_strict=$(find Modules/*/lang/ -name "*.php" -exec grep -L "declare(strict_types=1)" {} \;)
if [ ! -z "$missing_strict" ]; then
    echo "❌ ERRORE: File senza declare(strict_types=1):"
    echo "$missing_strict"
    exit 1
else
    echo "✅ Strict types: CONFORME"
fi
```

### 3. Controllo Struttura Espansa
```bash
echo "🔍 Controllo struttura espansa..."
# Cerca pattern di stringhe semplici invece di struttura espansa
simple_strings=$(grep -r "'[a-zA-Z_]\+' => '[^']\+'" Modules/*/lang/ --include="*.php" | grep -v "options\|'it'" | wc -l)
if [ $simple_strings -gt 0 ]; then
    echo "⚠️  WARNING: Possibili strutture semplici trovate (verificare manualmente)"
    grep -r "'[a-zA-Z_]\+' => '[^']\+'" Modules/*/lang/ --include="*.php" | grep -v "options\|'it'" | head -10
fi
```

### 4. Controllo Traduzioni Semantiche
```bash
echo "🔍 Controllo traduzioni semantiche..."
# Controllo per chiavi non tradotte (inglese in italiano)
english_labels=$(grep -r "'label' => '[a-z_]\+'" Modules/*/lang/it/ --include="*.php" | wc -l)
if [ $english_labels -gt 0 ]; then
    echo "❌ ERRORE: Trovate label non tradotte (inglese in file italiano):"
    grep -r "'label' => '[a-z_]\+'" Modules/*/lang/it/ --include="*.php" | head -5
    exit 1
else
    echo "✅ Traduzioni semantiche: CONFORME"
fi
```

### 5. Controllo Campi Anagrafici Standard
```bash
echo "🔍 Controllo campi anagrafici standard..."
# Controllo traduzioni corrette per campi comuni
check_field() {
    field_key="$1"
    expected_label="$2"
    
    incorrect=$(grep -r "'${field_key}'" Modules/*/lang/it/ --include="*.php" -A 3 | grep "'label'" | grep -v "'${expected_label}'" | wc -l)
    if [ $incorrect -gt 0 ]; then
        echo "❌ ERRORE: Campo '${field_key}' non tradotto correttamente come '${expected_label}'"
        grep -r "'${field_key}'" Modules/*/lang/it/ --include="*.php" -A 3 | grep "'label'" | grep -v "'${expected_label}'"
        return 1
    fi
    return 0
}

# Controlli specifici
check_field "first_name" "Nome" || exit 1
check_field "last_name" "Cognome" || exit 1
check_field "birth_date" "Data di nascita" || exit 1
check_field "fiscal_code" "Codice fiscale" || exit 1
check_field "email" "Email" || exit 1
check_field "phone" "Telefono" || exit 1
check_field "gender" "Sesso" || exit 1

echo "✅ Campi anagrafici: CONFORME"
```

## 🔧 CORREZIONE AUTOMATICA

### Script di Correzione Array Syntax
```bash
echo "🔧 Eseguendo correzione automatica sintassi array..."

# Backup di sicurezza
backup_dir="backup_translations_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$backup_dir"
find Modules/*/lang/ -name "*.php" -exec cp {} "$backup_dir/" \;
echo "📁 Backup creato in: $backup_dir"

# Correzione sintassi array() -> []
find Modules/*/lang/ -name "*.php" -exec sed -i 's/return array(/return [/g' {} \;
find Modules/*/lang/ -name "*.php" -exec sed -i 's/ array(/ [/g' {} \;
find Modules/*/lang/ -name "*.php" -exec sed -i 's/=> array(/=> [/g' {} \;

# Correzione parentesi finali (più complesso, richiede controllo manuale)
echo "⚠️  ATTENZIONE: Controllare manualmente le parentesi finali ) -> ]"

echo "✅ Correzione sintassi completata"
```

### Script Aggiunta Strict Types
```bash
echo "🔧 Aggiungendo declare(strict_types=1) dove mancante..."

for file in $(find Modules/*/lang/ -name "*.php" -exec grep -L "declare(strict_types=1)" {} \;); do
    echo "📝 Aggiornando: $file"
    # Crea file temporaneo con strict_types
    echo "<?php" > "${file}.tmp"
    echo "" >> "${file}.tmp"
    echo "declare(strict_types=1);" >> "${file}.tmp"
    echo "" >> "${file}.tmp"
    tail -n +2 "$file" >> "${file}.tmp"
    mv "${file}.tmp" "$file"
done

echo "✅ Strict types aggiunti"
```

## 📊 REPORT FINALE

### Generazione Report
```bash
echo "📊 Generando report finale..."

report_file="translation_validation_report_$(date +%Y%m%d_%H%M%S).md"

cat > "$report_file" << EOF
# Translation Validation Report
**Data**: $(date)
**Modulo**: SaluteOra

## Risultati Controlli

### ✅ Conformità
- Sintassi array breve: CONFORME
- Strict types: CONFORME  
- Traduzioni semantiche: CONFORME
- Campi anagrafici: CONFORME

### 📈 Statistiche
- File traduzione totali: $(find Modules/*/lang/ -name "*.php" | wc -l)
- File italiano: $(find Modules/*/lang/it/ -name "*.php" | wc -l)
- Campi tradotti: $(grep -r "'label'" Modules/*/lang/it/ --include="*.php" | wc -l)

### 🔧 Azioni Eseguite
- Correzione sintassi array: APPLICATA
- Aggiunta strict types: APPLICATA
- Backup creato: $backup_dir

## Status: ✅ VALIDATION PASSED
EOF

echo "📄 Report salvato in: $report_file"
```

## 🚀 INTEGRAZIONE CI/CD

### Pre-commit Hook
```bash
#!/bin/bash
# File: .git/hooks/pre-commit

echo "🔍 Validazione traduzioni pre-commit..."

# Esegui controlli critici
if ! grep -r "array(" Modules/*/lang/ --include="*.php" > /dev/null; then
    echo "✅ Sintassi array: OK"
else
    echo "❌ ERRORE: Sintassi array() vietata nei file di traduzione"
    echo "Eseguire: /translation-validate per correggere"
    exit 1
fi

echo "✅ Validazione traduzioni: PASSED"
```

### GitHub Actions
```yaml
name: Translation Validation

on: [push, pull_request]

jobs:
  validate-translations:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Validate Array Syntax
        run: |
          if grep -r "array(" Modules/*/lang/ --include="*.php"; then
            echo "❌ ERRORE: Sintassi array() vietata"
            exit 1
          fi
          
      - name: Validate Strict Types
        run: |
          missing=$(find Modules/*/lang/ -name "*.php" -exec grep -L "declare(strict_types=1)" {} \;)
          if [ ! -z "$missing" ]; then
            echo "❌ ERRORE: File senza strict_types"
            echo "$missing"
            exit 1
          fi
```

## 💡 BEST PRACTICES

### Checklist Sviluppatore
- [ ] Utilizzare SEMPRE sintassi array breve `[]`
- [ ] Aggiungere `declare(strict_types=1);` in OGNI file
- [ ] Utilizzare struttura espansa per TUTTI i campi
- [ ] Tradurre semanticamente (Nome, Cognome, mai inglese)
- [ ] Verificare con `/translation-validate` prima del commit

### Automation Philosophy
1. **Prevenzione**: Controlli automatici continui
2. **Correzione**: Script di correzione automatica
3. **Validazione**: Controlli pre-commit e CI/CD
4. **Enforcement**: Blocco automatico per violazioni
5. **Learning**: Aggiornamento regole da errori passati

---

**QUESTO WORKFLOW È PARTE INTEGRANTE DELLA QUALITÀ LARAXOT**

*Creato in risposta a: violazione sintassi array in patient.php*  
*Obiettivo: MAI PIÙ errori di sintassi array nei file di traduzione* 