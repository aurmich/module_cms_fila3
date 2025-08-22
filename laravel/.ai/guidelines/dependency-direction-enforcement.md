# 🔒 ENFORCEMENT: Direzione Dipendenze Modulari

## REGOLA DI ENFORCEMENT CRITICA

**OGNI violazione della direzione delle dipendenze modulari deve essere corretta IMMEDIATAMENTE.**

## 🚨 VIOLAZIONE ATTIVA IDENTIFICATA

### File Problematico
```
Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php
```

### Problema Specifico
```php
use Modules\SaluteOra\Models\Patient; // ❌ VIOLAZIONE CRITICA
```

### Impatto
- Modulo BASE (User) dipende da modulo SPECIFICO (SaluteOra)
- Rompe la riusabilità del modulo User
- Viola principi architetturali fondamentali
- Crea accoppiamento indesiderato

## 🔧 AZIONE CORRETTIVA OBBLIGATORIA

### Step 1: Spostamento File
```bash
# Sposta il widget nel modulo corretto
mv Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php \
   Modules/SaluteOra/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php
```

### Step 2: Aggiornamento Namespace
```php
// DA:
namespace Modules\User\Filament\Widgets;

// A:
namespace Modules\SaluteOra\Filament\Widgets;
```

### Step 3: Verifica Pulizia
```bash
# Deve restituire NIENTE
grep -r "SaluteOra" Modules/User/ --include="*.php"
```

### Step 4: Test Funzionalità
- Verificare che il widget funzioni nella nuova posizione
- Aggiornare eventuali registrazioni o riferimenti
- Testare che non ci siano regressioni

## 🎯 PREVENZIONE FUTURE VIOLAZIONI

### Script di Controllo Automatico
```bash
#!/bin/bash
# check-dependencies.sh

echo "🔍 Controllo dipendenze modulari..."

# Controlla moduli base per violazioni
violations=0

echo "Controllo modulo User..."
if grep -r "SaluteOra\|Patient\|Studio\|Appointment" Modules/User/ --include="*.php" -q; then
    echo "❌ VIOLAZIONE: Modulo User dipende da moduli specifici"
    grep -r "SaluteOra\|Patient\|Studio\|Appointment" Modules/User/ --include="*.php"
    violations=$((violations + 1))
fi

echo "Controllo modulo Geo..."
if grep -r "SaluteOra\|Studio\|Patient" Modules/Geo/ --include="*.php" -q; then
    echo "❌ VIOLAZIONE: Modulo Geo dipende da moduli specifici"
    grep -r "SaluteOra\|Studio\|Patient" Modules/Geo/ --include="*.php"
    violations=$((violations + 1))
fi

echo "Controllo modulo UI..."
if grep -r "SaluteOra\|Patient\|Studio\|Appointment" Modules/UI/ --include="*.php" -q; then
    echo "❌ VIOLAZIONE: Modulo UI dipende da moduli specifici"
    grep -r "SaluteOra\|Patient\|Studio\|Appointment" Modules/UI/ --include="*.php"
    violations=$((violations + 1))
fi

if [ $violations -eq 0 ]; then
    echo "✅ Nessuna violazione trovata - Architettura pulita!"
    exit 0
else
    echo "❌ Trovate $violations violazioni - CORREGGERE IMMEDIATAMENTE"
    exit 1
fi
```

### Integrazione CI/CD
```yaml
# .github/workflows/architecture-check.yml
name: Architecture Dependency Check

on: [push, pull_request]

jobs:
  dependency-check:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Check Module Dependencies
        run: |
          chmod +x ./scripts/check-dependencies.sh
          ./scripts/check-dependencies.sh
```

## 📋 CHECKLIST DI CORREZIONE

Per ogni violazione identificata:

- [ ] Identificato il file che viola la regola
- [ ] Compreso perché la dipendenza è sbagliata
- [ ] Pianificato lo spostamento nel modulo corretto
- [ ] Aggiornato namespace e import
- [ ] Verificato che non ci siano riferimenti residui
- [ ] Testato il funzionamento nella nuova posizione
- [ ] Aggiornato documentazione se necessario
- [ ] Verificato che l'architettura sia pulita

## 🎯 RESPONSABILITÀ DEL TEAM

### Developer
- Controllare dipendenze prima di ogni commit
- Usare lo script di verifica localmente
- Chiedere review per componenti cross-module

### Reviewer
- Verificare direzione dipendenze in ogni PR
- Bloccare merge se ci sono violazioni
- Educare sui principi architetturali

### Architect
- Monitorare l'architettura generale
- Aggiornare regole quando necessario
- Fornire guidance per casi complessi

## 🚫 ECCEZIONI (NESSUNA)

**Non esistono eccezioni a questa regola.**

Ogni tentativo di giustificare una violazione deve essere respinto e deve essere trovata una soluzione architettualmente corretta.

## 📈 METRICHE DI QUALITÀ

### KPI Architetturali
- **Violazioni dipendenze**: 0 (target assoluto)
- **Moduli base riutilizzabili**: 100%
- **Accoppiamento cross-module**: Minimo
- **Time to fix violations**: < 24h

### Reporting
```bash
# Report settimanale
echo "📊 Report Architetturale $(date)"
echo "Violazioni attive: $(./scripts/check-dependencies.sh | grep -c '❌')"
echo "Moduli base puliti: $(./scripts/check-dependencies.sh | grep -c '✅')"
```

---

**Questa regola di enforcement è NON NEGOZIABILE e deve essere applicata con tolleranza zero.**

*Ultimo aggiornamento: Gennaio 2025*  
*Status: ENFORCEMENT ATTIVO*  
*Tolleranza: ZERO*
