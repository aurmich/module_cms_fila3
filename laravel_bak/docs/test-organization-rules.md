# Regole per Organizzazione Test - ANTI-ERRORE

## 🚨 **Regola Universale**

**Se un test verifica codice di `Modules\{ModuleName}\*`, il test DEVE essere in `Modules/{ModuleName}/tests/`**

**MAI nella cartella root `/tests/`!**

## ❌ **Errori Comuni da NON RIPETERE**

### **Errore 1: Test di Modulo in Cartella Root**

```bash
# ❌ SBAGLIATO - Test di classe Xot in root
tests/Unit/Xot/MetatagDataTest.php

# ✅ CORRETTO - Test nel modulo Xot
Modules/Xot/tests/Unit/MetatagDataTest.php
```

### **Errore 2: Approccio Frammentario**

❌ **SBAGLIATO**: Spostare solo alcuni test evidenti  
✅ **CORRETTO**: Applicare la regola **SISTEMATICAMENTE** a tutti i test

### **Errore 3: Non Verificare Dipendenze**

Prima di creare/mantenere un test in `/tests/`, SEMPRE verificare:

```bash
# Verifica se testa classi di moduli specifici
grep -r "use Modules\\\\" tests/
grep -r "new.*Modules\\\\" tests/
grep -r "Modules\\\\" tests/ --include="*.php"
```

## 📋 **Checklist OBBLIGATORIA**

Prima di ogni commit con test, verificare:

- [ ] Il test usa classi `Modules\{ModuleName}\*`?
  - **SE SÌ** → DEVE essere in `Modules/{ModuleName}/tests/`
- [ ] Il test è nella cartella root `/tests/`?
  - **SE SÌ** → Verificare che NON usi classi di moduli specifici
- [ ] Namespace aggiornato correttamente?
- [ ] Test esegue dalla nuova posizione?

## 🎯 **Mappatura per Modulo**

### **Modulo SaluteOra** (Business Logic Principale)
```bash
# Test che vanno in Modules/SaluteOra/tests/
- Test homepage specifica SaluteOra
- Test business logic salute/medicina  
- Test workflow appuntamenti
- Test dashboard pazienti
```

### **Modulo Cms** (Frontend e Autenticazione)
```bash
# Test che vanno in Modules/Cms/tests/
- Test login/logout/registrazione
- Test verifica email
- Test frontend/navigation
- Test pagine statiche
```

### **Modulo Xot** (Core Framework)
```bash
# Test che vanno in Modules/Xot/tests/
- Test MetatagData (Modules\Xot\Datas\*)
- Test Actions core (Modules\Xot\Actions\*)
- Test trait HasXotTable
- Test qualsiasi classe Modules\Xot\*
```

### **Modulo User** (Gestione Utenti)
```bash
# Test che vanno in Modules/User/tests/
- Test modelli User specifici del modulo
- Test trait HasTeams, HasRoles
- Test policy utenti
```

## 🔍 **Script di Verifica**

### **Controllo Automatico**

```bash
#!/bin/bash
# check-test-placement.sh

echo "🔍 Verifica posizionamento test..."

# Trova test che potrebbero essere mal posizionati
find tests/ -name "*.php" -exec grep -l "use Modules\\\\" {} \; | while read file; do
    echo "⚠️  $file potrebbe dover essere spostato"
    echo "   Usa:"
    grep "use Modules\\\\" "$file" | head -3
    echo ""
done

# Verifica directory moduli
for module in Modules/*/; do
    module_name=$(basename "$module")
    echo "✅ Modulo $module_name:"
    
    if [ -d "$module/tests" ]; then
        test_count=$(find "$module/tests" -name "*Test.php" | wc -l)
        echo "   → $test_count test presenti"
    else
        echo "   → Nessuna directory tests/ (normale se non ha test)"
    fi
done
```

### **Migrazione Automatica**

```bash
#!/bin/bash
# migrate-test.sh [TEST_FILE] [MODULE_NAME]

TEST_FILE=$1
MODULE_NAME=$2

if [ -z "$TEST_FILE" ] || [ -z "$MODULE_NAME" ]; then
    echo "Usage: migrate-test.sh path/to/Test.php ModuleName"
    exit 1
fi

# Crea directory se non esiste
mkdir -p "Modules/$MODULE_NAME/tests/Unit"
mkdir -p "Modules/$MODULE_NAME/tests/Feature"

# Determina tipo test
if [[ $TEST_FILE == *"Feature"* ]]; then
    TARGET_DIR="Modules/$MODULE_NAME/tests/Feature"
else
    TARGET_DIR="Modules/$MODULE_NAME/tests/Unit"
fi

# Sposta file
mv "$TEST_FILE" "$TARGET_DIR/"

# Aggiorna namespace
TEST_NAME=$(basename "$TEST_FILE")
sed -i "s/namespace Tests\\\\/namespace Modules\\\\$MODULE_NAME\\\\Tests\\\\/" "$TARGET_DIR/$TEST_NAME"

echo "✅ Test migrato: $TARGET_DIR/$TEST_NAME"
echo "🔧 Namespace aggiornato a: Modules\\$MODULE_NAME\\Tests"
```

## 🚫 **Cosa NON Fare**

### **❌ Non fare spostamenti parziali**

```bash
# SBAGLIATO: Spostare solo test evidenti
mv tests/Feature/HomepageTest.php Modules/SaluteOra/tests/Feature/
# ...e dimenticare altri test del modulo SaluteOra

# CORRETTO: Verificare TUTTI i test sistematicamente
grep -r "SaluteOra\|salute\|appointment" tests/
# Poi spostare TUTTO ciò che appartiene al modulo
```

### **❌ Non dimenticare aggiornamenti namespace**

```php
// SBAGLIATO: Spostare file senza aggiornare namespace
mv tests/Unit/SomeTest.php Modules/MyModule/tests/Unit/
// File ha ancora: namespace Tests\Unit;

// CORRETTO: Aggiornare namespace dopo spostamento
// File deve avere: namespace Modules\MyModule\Tests\Unit;
```

### **❌ Non ignorare la cartella tests/ vuota**

```bash
# Dopo aver spostato tutti i test appropriati nei moduli,
# la cartella /tests/ dovrebbe contenere SOLO:
tests/
├── Feature/
│   ├── ExampleTest.php           # ✅ Template Laravel
│   ├── DashboardTest.php         # ✅ Test sistema generale  
│   └── ModuleStatusTest.php      # ✅ Test configurazione globale
└── Unit/
    └── ExampleTest.php           # ✅ Template Laravel

# NON dovrebbe contenere:
# ❌ tests/Unit/Xot/
# ❌ tests/Feature/Xot/
# ❌ tests/Browser/SpecificModuleTest.php
```

## 📚 **Documentazione da Aggiornare**

Quando si sposta un test, aggiornare:

1. **Documentazione del modulo target**:
   ```
   Modules/{ModuleName}/docs/testing.md
   ```

2. **Documentazione globale**:
   ```
   docs/testing-organization.md
   ```

3. **README del modulo**:
   ```
   Modules/{ModuleName}/docs/README.md
   ```

## 💡 **Prevenzione Futuri Errori**

### **1. Pre-commit Hook**

```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Verifico posizionamento test..."

# Cerca test mal posizionati
misplaced=$(find tests/ -name "*.php" -exec grep -l "use Modules\\\\" {} \;)

if [ ! -z "$misplaced" ]; then
    echo "❌ Test mal posizionati trovati:"
    echo "$misplaced"
    echo ""
    echo "💡 Sposta questi test nei moduli appropriati!"
    exit 1
fi

echo "✅ Posizionamento test corretto"
```

### **2. CI/CD Check**

```yaml
# .github/workflows/test-organization.yml
name: Test Organization Check

on: [push, pull_request]

jobs:
  check-test-placement:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Check for misplaced tests
        run: |
          misplaced=$(find tests/ -name "*.php" -exec grep -l "use Modules\\\\" {} \; || true)
          if [ ! -z "$misplaced" ]; then
            echo "❌ Test mal posizionati:"
            echo "$misplaced"
            exit 1
          fi
          echo "✅ Tutti i test sono posizionati correttamente"
```

### **3. IDE Configuration**

```json
// .vscode/settings.json
{
    "files.watcherExclude": {
        "**/tests/Unit/Modules/**": true,
        "**/tests/Feature/Modules/**": true
    },
    "search.exclude": {
        "**/tests/**/Modules/**": true
    }
}
```

## 🎯 **Mantra per Sviluppatori**

> **"Se il test verifica codice di un modulo, il test vive in quel modulo"**

### **Domande da Farsi SEMPRE**

1. **Quale classe sto testando?**
   - `Modules\SaluteOra\*` → Test in `Modules/SaluteOra/tests/`
   - `Modules\Xot\*` → Test in `Modules/Xot/tests/`
   - `App\*` → Test in `/tests/` (OK)

2. **Il test usa modelli/servizi specifici di un modulo?**
   - **SÌ** → Test nel modulo corrispondente
   - **NO** → Test nella root (se generico)

3. **Il test verifica business logic specifica?**
   - **SÌ** → Test nel modulo business
   - **NO** → Test generico (root)

---

## 📞 **Emergency Checklist**

Se trovi test mal posizionati:

1. **STOP** - Non committare
2. **IDENTIFICA** - Quale modulo possiede il codice testato?
3. **SPOSTA** - File nel modulo appropriato
4. **AGGIORNA** - Namespace del test
5. **TESTA** - Esecuzione dalla nuova posizione
6. **DOCUMENTA** - Aggiorna documentazione se necessario
7. **COMMIT** - Solo dopo verifica completa

---

**🚨 RICORDA: La cartella `/tests/` viene SOVRASCRITTA negli aggiornamenti Laravel!**

*Ultimo aggiornamento: Gennaio 2025*
*Motivazione: Prevenire perdita test durante aggiornamenti Laravel* 