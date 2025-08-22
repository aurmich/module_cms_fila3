# Documentation File Renaming Plan

## 📋 Overview
This document outlines the systematic renaming of documentation files to comply with naming standards: English language, kebab-case, no dates.

## 🎯 Renaming Strategy

### Phase 1: Remove Dates from Filenames

### Files to Rename (Date Removal)

| Current Path | New Name | Reason |
|-------------|----------|---------|
| `Modules/Geo/docs/phpstan/phpstan-fixes-gennaio-2025.md` | `phpstan-fixes.md` | Remove date and Italian word |
| `Modules/Lang/docs/traduzioni_navigation_2025.md` | `navigation-translations.md` | Remove date, translate to English, fix underscores |
| `Modules/Lang/docs/translation_files_update_2025.md` | `translation-files-update.md` | Remove date, fix underscores |
| `Modules/Lang/docs/riepilogo_correzioni_traduzioni_2025.md` | `translation-corrections-summary.md` | Remove date, translate to English, fix underscores |
| `Modules/Lang/docs/correzioni_errori_sintassi_2025.md` | `syntax-error-corrections.md` | Remove date, translate to English, fix underscores |
| `Modules/Lang/docs/translation-files-update-2025.md` | `translation-files-update.md` | Remove date only |
| `Modules/Lang/docs/translation_audit_completion_2025.md` | `translation-audit-completion.md` | Remove date, fix underscores |
| `Modules/Lang/docs/translation_errors_correction_2025.md` | `translation-error-corrections.md` | Remove date, fix underscores |
| `Modules/SaluteMo/docs/test-fixes-summary-2025.md` | `test-fixes-summary.md` | Remove date only |
| `Modules/SaluteMo/docs/syntax_error_fix_2025.md` | `syntax-error-fixes.md` | Remove date, fix underscores |
| `Modules/SaluteMo/docs/appointment_resource_label_fix_2025.md` | `appointment-resource-label-fixes.md` | Remove date, fix underscores |
| `Modules/Xot/docs/archive/git_conflicts_resolution_2025_01_06.md` | `git-conflicts-resolution.md` | Remove date, fix underscores |
| `Modules/Xot/docs/archive/phpstan-fixes-gennaio-2025.md` | `phpstan-fixes.md` | Remove date and Italian word |
| `Modules/UI/docs/phpstan_fixes_2025.md` | `phpstan-fixes.md` | Remove date, fix underscores |
| `Modules/SaluteOra/docs/test-fixes-summary-2025.md` | `test-fixes-summary.md` | Remove date only |
| `Modules/SaluteOra/docs/translation_refactor_summary_2025.md` | `translation-refactor-summary.md` | Remove date, fix underscores |

### Phase 2: Standardize Optimization Files

Several modules have optimization files with dates that need standardization:

```bash
# Current optimization files with dates
Modules/Tenant/docs/optimizations-2025-08-22.md
Modules/Geo/docs/optimizations-2025-08-22.md  
Modules/Gdpr/docs/optimizations-2025-08-22.md
Modules/Lang/docs/optimizations-2025-08-22.md
Modules/Cms/docs/optimizations-2025-08-22.md

# Should be renamed to:
Modules/Tenant/docs/optimizations.md
Modules/Geo/docs/optimizations.md
Modules/Gdpr/docs/optimizations.md  
Modules/Lang/docs/optimizations.md
Modules/Cms/docs/optimizations.md
```

### Phase 3: Address Other Date Patterns

Additional files with date patterns:

| Current Path | New Name |
|-------------|----------|
| `Modules/Geo/docs/address-translation-fixes-2025-01-27.md` | `address-translation-fixes.md` |
| `Modules/Geo/docs/helper-text-normalization-fix-2025-08-08.md` | `helper-text-normalization-fixes.md` |
| `Modules/Geo/docs/sintassi-array-correzione-2025-01-06.md` | `array-syntax-corrections.md` |
| `Modules/Lang/docs/enum-translation-pattern-implementation-2025-01-27.md` | `enum-translation-pattern-implementation.md` |
| `Modules/Lang/docs/lang-service-translation-updates-2025-01-06.md` | `lang-service-translation-updates.md` |
| `Modules/Lang/docs/translation-refactor-complete-summary-2025-08-08.md` | `translation-refactor-complete-summary.md` |

## 🔄 Renaming Process

### Step 1: Use Git Move
```bash
# For each file, use git mv to preserve history
git mv "old_filename.md" "new_filename.md"
```

### Step 2: Update Internal Links
After renaming, update any internal references in:
- Other documentation files
- README.md files
- Navigation files
- Index files

### Step 3: Verify Changes
```bash
# Check for broken links
grep -r "old_filename" Modules/*/docs/

# Verify no dates remain
find Modules -name "docs" -type d | xargs -I {} find {} -name "*.md" | grep -E "202[0-9]"
```

## 🗂️ Directory Structure Standardization

After renaming, organize files into appropriate directories:

### Recommended Structure
```
docs/
├── architecture/
├── best-practices/
├── configuration/ 
├── development/
├── performance/
├── phpstan/          # PHPStan related docs
├── testing/
├── translations/     # Translation related docs
└── troubleshooting/
```

## 📝 Content Updates

After renaming, ensure content is also standardized:
- Translate Italian content to English
- Update any dated references in content
- Ensure consistent terminology
- Verify all code examples work

## ⚠️ Considerations

1. **Git History**: Always use `git mv` to preserve history
2. **Links**: Update all internal links after renaming
3. **Dependencies**: Check if any code references documentation
4. **Navigation**: Update navigation menus and indexes
5. **Search**: Reindex search if using documentation search

## 📊 Progress Tracking

- [ ] Phase 1: Date removal from core files
- [ ] Phase 2: Optimization files standardization  
- [ ] Phase 3: Additional date pattern files
- [ ] Phase 4: Content translation and updates
- [ ] Phase 5: Link validation and verification

---

**Last Updated**: 2025-08-22  
**Status**: In Progress