# Windsurf Workflows - Laraxot Project

Questa directory contiene tutti i workflow automatizzati per il progetto Laraxot, seguendo la filosofia, religione, politica e zen definiti per il framework.

## 🚀 Quick Start

### Controllo Salute Progetto (Raccomandato per iniziare)
```bash
.windsurf/workflows/project-health-check.md
```

### Setup Nuovo Modulo
```bash
.windsurf/workflows/module-setup.md
```

### Correzioni Immediate
```bash
.windsurf/workflows/provider-validation.md
.windsurf/workflows/code-quality-check.md
```

## 📁 Workflow Disponibili

| Workflow | Scopo | Quando Usare | Durata |
|----------|-------|--------------|---------|
| [🏥 project-health-check.md](project-health-check.md) | Controllo completo salute progetto | Daily, prima release | 5-10 min |
| [🏗️ module-setup.md](module-setup.md) | Creazione nuovo modulo completo | Nuovi moduli | 2-3 min |
| [🔧 provider-validation.md](provider-validation.md) | Validazione provider XotBase | Prima commit, daily | 1-2 min |
| [🔍 code-quality-check.md](code-quality-check.md) | Controlli qualità codice | Prima commit, CI/CD | 3-5 min |
| [📝 naming-convention-audit.md](naming-convention-audit.md) | Audit convenzioni naming | Settimanale | 2-3 min |
| [📚 documentation-sync.md](documentation-sync.md) | Sync documentazione | Dopo modifiche docs | 1-2 min |
| [📋 laraxot.md](laraxot.md) | Overview completo sistema | Reference, onboarding | - |

## 🎯 Filosofia dei Workflow

### Centralizzazione
- Un solo punto di verità per ogni controllo
- Nessuna duplicazione di logica
- Automazione massima, intervento minimo

### Qualità
- Standard elevati non negoziabili
- PHPStan livello 9+ obbligatorio
- PSR-12 compliance sempre

### Serenità
- Deploy senza paura
- Refactoring sicuro
- Onboarding immediato

## 🔄 Routine Raccomandate

### Sviluppatore (Daily)
```bash
# Mattina - controllo generale
.windsurf/workflows/project-health-check.md

# Prima di ogni commit
.windsurf/workflows/provider-validation.md
.windsurf/workflows/code-quality-check.md
```

### Team Lead (Weekly)
```bash
# Lunedì - audit completo
.windsurf/workflows/naming-convention-audit.md
.windsurf/workflows/documentation-sync.md
.windsurf/workflows/project-health-check.md
```

### DevOps (CI/CD)
```bash
# Pipeline automatica
.windsurf/workflows/provider-validation.md
.windsurf/workflows/code-quality-check.md
.windsurf/workflows/naming-convention-audit.md
```

## 📊 Health Score System

I workflow calcolano un **Health Score** da 0 a 100:

- 🏆 **90-100**: ECCELLENTE - Progetto in ottima salute
- ✅ **75-89**: BUONO - Miglioramenti minori
- ⚠️ **60-74**: SUFFICIENTE - Necessita miglioramenti
- ❌ **40-59**: INSUFFICIENTE - Interventi significativi
- 🚨 **0-39**: CRITICO - Refactoring completo

## 🛠️ Setup Automazione

### 1. GitHub Actions
Crea `.github/workflows/laraxot-quality.yml`:
```yaml
name: Laraxot Quality
on: [push, pull_request]
jobs:
  quality:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - run: composer install
      - run: .windsurf/workflows/project-health-check.md
```

### 2. Pre-commit Hook
```bash
# Installa hook
cp .windsurf/workflows/scripts/pre-commit.sh .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
```

### 3. Cron Jobs
```bash
# Daily health check alle 6:00
0 6 * * * cd /path/to/project && .windsurf/workflows/project-health-check.md

# Weekly full audit ogni lunedì alle 6:00
0 6 * * 1 cd /path/to/project && .windsurf/workflows/naming-convention-audit.md
```

## 📈 Metriche di Successo

### Obiettivi Target
- **Health Score**: Mantenere > 85
- **PHPStan**: 0 errori livello 9
- **Provider Compliance**: 100%
- **Naming Violations**: < 5
- **Test Coverage**: > 80%
- **Documentation**: 100% moduli con README

### KPI Monitoraggio
- Tempo medio fix errori critici: < 1 ora
- Tempo setup nuovo modulo: < 5 minuti
- Frequenza deploy: Daily senza blocchi
- Onboarding nuovo dev: < 1 giorno

## 🔧 Troubleshooting

### Errori Comuni

**"Workflow non eseguibile"**
```bash
chmod +x .windsurf/workflows/*.md
```

**"PHPStan non trovato"**
```bash
cd laravel && composer require --dev phpstan/phpstan
```

**"Report non generati"**
```bash
mkdir -p reports
chmod 755 reports
```

### Log e Debug
- Report generati in: `reports/`
- Log workflow in: `reports/*.log`
- Dashboard principale: `reports/project_dashboard.md`

## 🔗 Collegamenti Utili

### Documentazione
- [Laraxot Rules Complete](./../laraxot-rules-complete.mdc)
- [Provider XotBase Philosophy](../rules/provider_xotbase_philosophy.mdc)
- [Naming Conventions](../rules/naming_conventions.mdc)

### Risorse Esterne
- [Laravel Best Practices](https://laravel-best-practices.com/)
- [PHPStan Documentation](https://phpstan.org/user-guide)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)

### Community
- [Laraxot Framework](https://github.com/laraxot)
- [Issues e Support](https://github.com/laraxot/framework/issues)

---

## 💡 Tips e Best Practices

### Performance
- Esegui i workflow in background: `workflow.md > /dev/null 2>&1 &`
- Usa cache per dipendenze: `composer install --prefer-dist --no-dev`
- Parallelizza controlli quando possibile

### Customization
- Modifica i threshold nei workflow per adattarli al progetto
- Aggiungi controlli specifici per il dominio applicativo
- Estendi i report con metriche custom

### Team Adoption
- Inizia con `project-health-check.md` per abituare il team
- Introduci controlli pre-commit gradualmente
- Condividi i risultati in modo trasparente

---

*"L'automazione non sostituisce la competenza, la potenzia."*

**Ultimo aggiornamento**: 2025-01-27  
**Versione**: 1.0  
**Compatibilità**: Windsurf, Laravel 12+, PHP 8.1+