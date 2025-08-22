# Documentation Naming Standards

## 🎯 Critical Rules for Documentation Files

### 1. **NO Dates in Filenames**
```bash
# ❌ WRONG
phpstan-fixes-2025-01-06.md
optimizations-2025-08-22.md
analysis-2025-08-18.md

# ✅ CORRECT
phpstan-fixes.md
optimizations.md
analysis.md
```

**Motivation**: 
- Git already tracks versions and history
- Date-based files become obsolete and confusing
- Easier to find and maintain generic names
- Prevents accumulation of outdated documentation

### 2. **English Only for Filenames**
```bash
# ❌ WRONG
ottimizzazioni-e-miglioramenti.md
analisi-moduli.md
configurazione-sistema.md

# ✅ CORRECT
optimizations-and-improvements.md
module-analysis.md
system-configuration.md
```

**Motivation**:
- International collaboration compatibility
- Consistency with codebase (all code is in English)
- Universal software development standard
- Better integration with development tools

### 3. **Kebab-case Only (dash-separated)**
```bash
# ❌ WRONG
phpstan_fixes.md
system_configuration.md
module_analysis.md

# ✅ CORRECT
phpstan-fixes.md
system-configuration.md
module-analysis.md
```

**Motivation**:
- URL-friendly format
- Better readability for long names
- Modern documentation standard
- Consistent with web routing conventions

### 4. **Exception: README.md**
The ONLY file that can use uppercase is `README.md` (standard convention).

## 🔧 Implementation Rules

### Automatic Standardization Process
1. **Scan all docs folders** for non-compliant files
2. **Rename files** following the three rules above
3. **Update all internal links** to reflect new names
4. **Preserve file content** during renaming
5. **Update any references** in code or configuration

### File Naming Pattern
```bash
# Pattern: [topic]-[subtopic]-[type].md
phpstan-fixes.md
filament-resources.md
database-migrations.md
testing-guidelines.md
performance-optimization.md
security-best-practices.md
```

### Directory Structure
```bash
docs/
├── README.md                    # ✅ Exception - uppercase allowed
├── architecture/
│   ├── module-dependencies.md   # ✅ Kebab-case
│   └── design-patterns.md       # ✅ Kebab-case
├── development/
│   ├── coding-standards.md      # ✅ Kebab-case
│   └── testing-guidelines.md    # ✅ Kebab-case
└── deployment/
    ├── production-setup.md      # ✅ Kebab-case
    └── environment-config.md    # ✅ Kebab-case
```

## 🚀 Benefits

### Maintainability
- **Timeless documentation**: No date-based obsolescence
- **Easy navigation**: Predictable and consistent naming
- **Reduced confusion**: Clear, descriptive names

### Collaboration
- **International team ready**: English-only documentation
- **Tool compatibility**: Works with all development tools
- **Standard compliance**: Follows universal conventions

### Technical
- **URL-friendly**: Can be served directly as web documentation
- **Search-friendly**: Better indexing and search results
- **Integration-ready**: Compatible with documentation generators

## 📋 Enforcement Checklist

Before committing any documentation:
- [ ] Filename contains no dates
- [ ] Filename is in English
- [ ] Filename uses kebab-case (dashes only)
- [ ] Content is meaningful and up-to-date
- [ ] Internal links are updated if file was renamed

## 🔗 Related Guidelines

- [Documentation Management](./documentation-management.md)
- [Coding Standards](./coding-standards.md)
- [Project Overview](./project-overview.md)

---

**Last Updated**: December 2024  
**Version**: 1.0  
**Status**: ✅ Critical Standard - Always Enforce

