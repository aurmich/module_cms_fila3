# REGOLA CRITICA: Naming Convention per File Documentazione

## ⚠️ STANDARD ASSOLUTO PER CARTELLE DOCS ⚠️

### 🎯 Motivazioni Architetturali

#### 1. **Consistenza e Manutenibilità**
- **Naming uniforme** facilita navigazione e ricerca
- **Standard internazionale** per progetti open source
- **Compatibilità cross-platform** (Windows, Linux, macOS)
- **Automazione** di script e tool di documentazione

#### 2. **Longevità del Progetto**
- **Date nei nomi** creano confusione temporale
- **Contenuto semantico** più importante della data di creazione
- **Versionamento Git** già traccia le date
- **Refactoring sicuro** senza perdere riferimenti

#### 3. **Professionalità e Standard**
- **Inglese** è lingua standard per documentazione tecnica
- **Kebab-case** è standard web e URL-friendly
- **Minuscolo** evita problemi case-sensitivity
- **Leggibilità** migliorata per team internazionali

---

## 📋 REGOLE OBBLIGATORIE

### ✅ **SEMPRE FARE**
1. **Lingua**: SEMPRE inglese (mai italiano, tedesco, etc.)
2. **Separatori**: SEMPRE trattini `-` (mai underscore `_`)
3. **Case**: SEMPRE minuscolo (eccetto `README.md`)
4. **Contenuto**: Nome descrittivo del contenuto (mai date)
5. **Estensione**: `.md` per Markdown

### ❌ **MAI FARE**
1. **Date nei nomi**: `file-2025-08-22.md` ❌
2. **Underscore**: `phpstan_analysis.md` ❌
3. **Italiano**: `ottimizzazioni.md` ❌
4. **Maiuscole**: `PHPSTAN-FIXES.md` ❌
5. **Spazi**: `my file.md` ❌

---

## 📝 ESEMPI CORRETTI vs ERRATI

### ✅ **NOMI CORRETTI**
- `optimization-analysis.md`
- `phpstan-fixes.md`
- `security-guidelines.md`
- `performance-best-practices.md`
- `architecture-overview.md`
- `testing-strategy.md`
- `deployment-guide.md`
- `troubleshooting-guide.md`

### ❌ **NOMI ERRATI**
- `optimizations-2025-08-22.md` → `optimization-analysis.md`
- `phpstan_analysis.md` → `phpstan-analysis.md`
- `ottimizzazioni.md` → `optimization-analysis.md`
- `PHPSTAN-FIXES.md` → `phpstan-fixes.md`
- `sicurezza_linee_guida.md` → `security-guidelines.md`

---

## 🔄 PROCESSO DI STANDARDIZZAZIONE

### 1. **Identificazione File Non Conformi**
```bash
# Trova file con date nei nomi
find . -name "*.md" | grep -E "[0-9]{4}-[0-9]{2}-[0-9]{2}"

# Trova file con underscore
find . -name "*.md" | grep "_"

# Trova file con maiuscole (eccetto README.md)
find . -name "*.md" | grep -v "README.md" | grep "[A-Z]"
```

### 2. **Script di Rinominazione**
```bash
#!/bin/bash
# rename-docs.sh

# Rinomina file con date
for file in $(find . -name "*.md" | grep -E "[0-9]{4}-[0-9]{2}-[0-9]{2}"); do
    newname=$(echo $file | sed 's/-[0-9]\{4\}-[0-9]\{2\}-[0-9]\{2\}//g')
    mv "$file" "$newname"
    echo "Renamed: $file → $newname"
done

# Rinomina underscore in trattini
for file in $(find . -name "*.md" | grep "_"); do
    newname=$(echo $file | tr '_' '-')
    mv "$file" "$newname"
    echo "Renamed: $file → $newname"
done
```

### 3. **Aggiornamento Riferimenti**
Dopo ogni rinominazione:
- Aggiornare tutti i link interni nei file `.md`
- Aggiornare riferimenti in codice PHP
- Verificare link bidirezionali
- Testare che non ci siano link rotti

---

## 🎯 BENEFICI DELLO STANDARD

### **Sviluppatori**
- **Navigazione intuitiva** tra file
- **Ricerca facilitata** con pattern uniformi
- **Autocomplete** funzionante negli IDE
- **Meno errori** di digitazione

### **Manutenzione**
- **Refactoring sicuro** senza perdere riferimenti
- **Backup e sync** più affidabili
- **Scripting** automatizzato più semplice
- **CI/CD** pipeline più robuste

### **Collaborazione**
- **Standard internazionale** per team globali
- **Onboarding** più veloce per nuovi sviluppatori
- **Documentation as Code** best practices
- **Open source** compliance

---

## 🔗 INTEGRAZIONE CON TOOLS

### **IDE Support**
- File naming coerente con autocomplete
- Quick navigation con pattern uniformi
- Search and replace più efficace

### **Git Integration**
- History tracking più pulito
- Merge conflicts ridotti
- Branch comparison facilitata

### **Documentation Tools**
- Generazione automatica indici
- Link checking automatico
- Static site generation ottimizzata

---

## 📚 RIFERIMENTI E STANDARD

### **Industry Standards**
- [GitHub Docs Guidelines](https://docs.github.com/en/contributing/style-guide-and-content-model/style-guide)
- [GitLab Documentation Style Guide](https://docs.gitlab.com/ee/development/documentation/styleguide/)
- [Markdown Style Guide](https://www.markdownguide.org/basic-syntax/)

### **Best Practices**
- [Technical Writing Best Practices](https://developers.google.com/tech-writing)
- [Documentation Architecture](https://documentation.divio.com/)
- [Naming Conventions](https://restfulapi.net/resource-naming/)

---

## 🎖️ IMPLEMENTAZIONE IMMEDIATA

Questa regola deve essere applicata **IMMEDIATAMENTE** a:
1. Tutti i file esistenti nelle cartelle docs
2. Tutti i nuovi file creati
3. Tutti i link e riferimenti
4. Tutti gli script di automazione

---

**RICORDA**: La documentazione è il **DNA del progetto**. Standard chiari = Progetto professionale e manutenibile.

*Implementato: Gennaio 2025*  
*Stato: REGOLA ATTIVA E OBBLIGATORIA*

