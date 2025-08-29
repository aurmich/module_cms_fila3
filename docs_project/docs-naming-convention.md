# Convenzione di Naming per Documentazione - Standard SaluteOra

## 🎯 Obiettivo

Stabilire uno **standard uniforme e professionale** per la naming convention di tutti i file di documentazione nel progetto SaluteOra, seguendo best practice internazionali e principi di manutenibilità.

---

## 📋 REGOLE OBBLIGATORIE

### ✅ **Standard Richiesto**

1. **🌍 Lingua**: SEMPRE inglese
   - Motivazione: Standard internazionale, team globali, open source
   - Esempio: `security-guidelines.md` ✅ (non `sicurezza-linee-guida.md` ❌)

2. **🔗 Separatori**: SEMPRE trattini `-` (kebab-case)
   - Motivazione: URL-friendly, standard web, leggibilità
   - Esempio: `optimization-analysis.md` ✅ (non `optimization_analysis.md` ❌)

3. **📝 Case**: SEMPRE minuscolo (eccetto README.md)
   - Motivazione: Compatibilità cross-platform, standard Unix
   - Esempio: `phpstan-fixes.md` ✅ (non `PHPSTAN-FIXES.md` ❌)

4. **📅 Date**: MAI nei nomi file
   - Motivazione: Git traccia già le date, nomi semantici durano nel tempo
   - Esempio: `optimization-analysis.md` ✅ (non `optimizations-2025-08-22.md` ❌)

5. **📄 Estensione**: `.md` per Markdown
   - Motivazione: Standard documentazione, rendering automatico

---

## 🔄 PROCESSO DI MIGRAZIONE

### Fase 1: Identificazione File Non Conformi

```bash
# Trova file con date
find Modules/*/docs -name "*.md" | grep -E "[0-9]{4}-[0-9]{2}-[0-9]{2}"

# Trova file con underscore  
find Modules/*/docs -name "*.md" | grep "_"

# Trova file con maiuscole (eccetto README.md)
find Modules/*/docs -name "*.md" | grep -v "README.md" | grep "[A-Z]"
```

### Fase 2: Mapping di Rinominazione

| File Attuale | File Target | Motivazione |
|-------------|-------------|-------------|
| `optimizations-2025-08-22.md` | `optimization-analysis.md` | Rimuove data, semantico |
| `phpstan_analysis.md` | `phpstan-analysis.md` | Kebab-case standard |
| `ottimizzazioni.md` | `optimization-analysis.md` | Inglese + semantico |
| `PHPSTAN-FIXES.md` | `phpstan-fixes.md` | Minuscolo standard |

### Fase 3: Aggiornamento Riferimenti

Per ogni file rinominato:
1. **Aggiornare link interni** in altri file `.md`
2. **Aggiornare riferimenti** in codice PHP se esistenti
3. **Verificare backlink** bidirezionali
4. **Testare** che non ci siano link rotti

---

## 📝 TEMPLATE DI NAMING

### **Analisi e Reportistica**
- `{subject}-analysis.md` - Analisi dettagliate
- `{subject}-report.md` - Report specifici
- `{subject}-metrics.md` - Metriche e KPI

### **Linee Guida e Standard**
- `{subject}-guidelines.md` - Linee guida
- `{subject}-standards.md` - Standard tecnici  
- `{subject}-best-practices.md` - Best practice

### **Guide Operative**
- `{subject}-guide.md` - Guide complete
- `{subject}-tutorial.md` - Tutorial step-by-step
- `{subject}-quickstart.md` - Guide rapide

### **Risoluzione Problemi**
- `{subject}-troubleshooting.md` - Risoluzione problemi
- `{subject}-fixes.md` - Correzioni specifiche
- `{subject}-issues.md` - Problemi noti

### **Architettura e Design**
- `{subject}-architecture.md` - Architettura
- `{subject}-design.md` - Design patterns
- `{subject}-overview.md` - Panoramiche

---

## 🎖️ BENEFICI DELLO STANDARD

### **Manutenibilità**
- **Ricerca facilitata** con pattern uniformi
- **Navigazione intuitiva** tra file correlati
- **Refactoring sicuro** senza perdere riferimenti
- **Automazione** script e tool di documentazione

### **Professionalità**
- **Standard internazionale** per progetti enterprise
- **Compatibilità** con tool di documentazione
- **Onboarding** facilitato per nuovi sviluppatori
- **Open source** compliance

### **Performance**
- **Caching** più efficiente con nomi uniformi
- **Indexing** automatico migliorato
- **Search** più veloce e precisa
- **CI/CD** pipeline ottimizzate

---

## 🔗 Collegamenti Correlati

- [AI Guidelines](../.ai/guidelines/docs-naming-convention.md)
- [Cursor Rules](../.cursor/rules/docs-naming-standard.md)
- [Windsurf Rules](../.windsurf/rules/docs-naming-standard.mdc)
- [Laraxot Conventions](./laraxot-conventions.md)

---

**IMPORTANTE**: Questa regola è **FONDAMENTALE** per la qualità e professionalità del progetto SaluteOra.

*Ultimo aggiornamento: Gennaio 2025*

