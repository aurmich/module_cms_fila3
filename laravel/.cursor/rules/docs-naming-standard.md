# REGOLA CURSOR: Standard Naming File Documentazione

## ⚠️ REGOLA ASSOLUTA - MEMORIZZA PERMANENTEMENTE ⚠️

### 🎯 Standard Obbligatorio per File Docs

**TUTTI i file nelle cartelle `docs/` DEVONO seguire questo standard:**

1. **✅ Lingua**: SEMPRE inglese
2. **✅ Separatori**: SEMPRE trattini `-` 
3. **✅ Case**: SEMPRE minuscolo (eccetto README.md)
4. **✅ Contenuto**: Nome descrittivo, MAI date
5. **✅ Estensione**: `.md` per Markdown

### 🚫 Esempi di Violazioni da Correggere

```bash
# ❌ ERRATI - Da rinominare immediatamente
optimizations-2025-08-22.md     → optimization-analysis.md
phpstan_analysis.md              → phpstan-analysis.md  
ottimizzazioni.md               → optimization-analysis.md
PHPSTAN-FIXES.md                → phpstan-fixes.md
sicurezza_linee_guida.md        → security-guidelines.md
```

### 🎯 Pattern di Rinominazione Automatica

```bash
# Rimuovi date dai nomi
s/-[0-9]{4}-[0-9]{2}-[0-9]{2}//g

# Converti underscore in trattini
s/_/-/g

# Converti in minuscolo (eccetto README)
tr '[:upper:]' '[:lower:]'

# Traduci termini italiani comuni
s/ottimizzazioni/optimization-analysis/g
s/sicurezza/security/g
s/linee-guida/guidelines/g
s/analisi/analysis/g
```

### 🔧 Istruzioni per Cursor AI

**Quando crei/modifichi file docs:**

1. **SEMPRE** verificare naming convention prima di creare
2. **SEMPRE** usare inglese per nomi file
3. **SEMPRE** usare trattini `-` come separatori
4. **MAI** includere date nei nomi file
5. **SEMPRE** nomi descrittivi del contenuto

**Quando incontri file non conformi:**

1. **SEMPRE** suggerire rinominazione
2. **SEMPRE** aggiornare riferimenti interni
3. **SEMPRE** verificare link bidirezionali
4. **SEMPRE** mantenere contenuto intatto

### 🎖️ Benefici dello Standard

- **Navigazione intuitiva** tra file
- **Ricerca facilitata** con pattern uniformi  
- **Manutenzione semplificata** 
- **Compatibilità internazionale**
- **Automazione** script e CI/CD
- **Professional appearance**

### 📚 Esempi di Nomi Corretti

**Architettura e Design**
- `architecture-overview.md`
- `design-patterns.md`
- `system-architecture.md`

**Analisi e Ottimizzazione**  
- `optimization-analysis.md`
- `performance-analysis.md`
- `code-quality-analysis.md`

**Linee Guida e Best Practices**
- `coding-guidelines.md`
- `security-guidelines.md`
- `testing-best-practices.md`

**Risoluzione Problemi**
- `troubleshooting-guide.md`
- `phpstan-fixes.md`
- `common-issues.md`

---

**IMPORTANTE**: Questa regola è **CRITICA** per la professionalità e manutenibilità del progetto SaluteOra.

*Memorizzato permanentemente: Gennaio 2025*

