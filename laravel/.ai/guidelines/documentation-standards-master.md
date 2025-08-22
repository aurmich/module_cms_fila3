# Documentation Standards Master Guide

## 📋 Overview
This document defines the comprehensive standards for all documentation within the Laravel application, ensuring consistency, maintainability, and professional quality across all modules.

## 🎯 Core Principles

### 1. Language Consistency
- **English Only**: All documentation must be written in English
- **Clear Terminology**: Use consistent technical terminology across all docs
- **Professional Tone**: Maintain professional, clear, and concise language

### 2. Naming Conventions
- **Kebab-case**: Always use hyphens (`-`) not underscores (`_`)
- **No Dates**: Never include dates in filenames
- **Lowercase**: All filenames must be lowercase except `README.md`
- **Descriptive**: Names should clearly describe content

### 3. File Organization
- **Structured Directories**: Organize docs in logical subdirectories
- **No Root Docs**: Avoid placing documentation files in module root
- **Consistent Structure**: Maintain similar structure across all modules

## 📁 File Naming Standards

### ✅ Correct Examples
```
optimizations.md
phpstan-analysis.md
gdpr-compliance-guide.md
filament-resources.md
testing-strategy.md
```

### ❌ Incorrect Examples
```
optimizations-2025-08-22.md      # Contains date
phpstan_fixes.md                 # Uses underscore
guida-conformita-gdpr.md         # Non-English
TESTING_STRATEGY.md              # Uppercase with underscore
```

## 🗂️ Directory Structure Standards

### Recommended Structure
```
Modules/{ModuleName}/docs/
├── README.md                    # Module overview
├── architecture/                # Architectural decisions
├── best-practices/              # Coding standards
├── configuration/               # Configuration guides
├── deployment/                  # Deployment instructions
├── development/                 # Development guidelines
├── examples/                    # Code examples
├── integration/                 # Integration guides
├── performance/                 # Performance optimization
├── security/                    # Security guidelines
├── testing/                     # Testing strategies
├── troubleshooting/             # Common issues & solutions
└── upgrades/                    # Upgrade instructions
```

## 📝 Content Standards

### 1. Headers and Structure
- Use H1 for main title only
- Use H2 for major sections
- Use H3 for subsections
- Maintain consistent header hierarchy

### 2. Code Blocks
- Always specify language for syntax highlighting
- Use descriptive code block titles
- Keep code examples concise and relevant

### 3. Links and References
- Use relative paths for internal links
- Reference other docs using consistent naming
- Maintain link integrity after renames

## 🔄 Migration Strategy

### Phase 1: Rename Files
1. Remove dates from all filenames
2. Convert underscores to hyphens
3. Translate non-English filenames to English
4. Ensure all lowercase (except README.md)

### Phase 2: Content Standardization
1. Translate content to English where needed
2. Apply consistent formatting
3. Update internal links
4. Verify all code examples work

### Phase 3: Structural Organization
1. Create standardized directory structure
2. Move files to appropriate directories
3. Update navigation and indexes
4. Verify all links work correctly

## 🛠️ Tooling and Automation

### Recommended Tools
- **ripgrep**: For searching and replacing across files
- **fd**: For batch file renaming
- **pandoc**: For format conversion if needed
- **vale**: For linting documentation quality

### Automation Scripts
Create scripts for:
- Bulk file renaming (kebab-case, no dates)
- Link validation and updating
- Consistency checks
- Language validation

## 📊 Quality Checklist

### Before Committing
- [ ] Filename follows kebab-case
- [ ] No dates in filename
- [ ] Content is in English
- [ ] All internal links work
- [ ] Code examples are functional
- [ ] Headers follow proper hierarchy
- [ ] No broken external references

### After Renaming
- [ ] Git history preserved with `git mv`
- [ ] All internal links updated
- [ ] Navigation updated if needed
- [ ] README.md reflects new structure
- [ ] No broken references in code

## 🔗 Related Standards

- [Coding Standards](../coding-standards.md)
- [Filament Documentation Standards](../filament-resource-rules.md)
- [Testing Documentation Standards](../testing-guidelines.md)

## 📈 Monitoring and Maintenance

### Regular Audits
- Quarterly documentation audits
- Link validation checks
- Content freshness reviews
- Consistency verification

### Update Process
1. Create issue for documentation updates
2. Follow naming standards in changes
3. Update related documentation
4. Verify all links post-update
5. Update table of contents if needed

---

**Last Updated**: 2025-08-22  
**Version**: 2.0  
**Status**: Active - Mandatory for all new documentation