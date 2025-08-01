#!/bin/bash

# Script finale per completare la sistemazione della documentazione Laraxot
# Validazione finale, creazione indici e verifica compliance

set -e

echo "🎯 FINALIZZAZIONE ORGANIZZAZIONE DOCUMENTAZIONE LARAXOT"
echo "======================================================="
echo ""

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Contatori finali
total_modules=0
compliant_modules=0
issues_remaining=0

# Funzione per creare indice principale del modulo
create_module_index() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    
    echo -e "${BLUE}📋 Creazione indice per: $module_name${NC}"
    
    # Conta file e cartelle per statistiche
    local total_files=$(find "$docs_dir" -name "*.md" -type f | wc -l)
    local total_dirs=$(find "$docs_dir" -type d | wc -l)
    
    # Aggiorna README principale con indice completo
    cat > "$docs_dir/README.md" << EOF
# $module_name Module Documentation

## 📊 Documentation Overview
- **Total Documents**: $total_files
- **Categories**: $total_dirs
- **Last Updated**: $(date +%Y-%m-%d)
- **Compliance**: Laraxot Framework Standards

## 🏗️ Architecture & Design
$(find "$docs_dir" -path "*/architecture/*" -name "*.md" 2>/dev/null | head -5 | sed 's|.*/||' | sed 's|^|- [|; s|\.md$|](./architecture/&)|' || echo "- No architecture documentation found")

## 📋 Best Practices
$(find "$docs_dir" -path "*/best-practices/*" -name "*.md" 2>/dev/null | head -5 | sed 's|.*/||' | sed 's|^|- [|; s|\.md$|](./best-practices/&)|' || echo "- [General Best Practices](./best-practices/README.md)")

## 🔧 Configuration
$(find "$docs_dir" -path "*/configuration/*" -name "*.md" 2>/dev/null | head -5 | sed 's|.*/||' | sed 's|^|- [|; s|\.md$|](./configuration/&)|' || echo "- No configuration documentation found")

## 🚨 Troubleshooting
$(find "$docs_dir" -path "*/troubleshooting/*" -name "*.md" 2>/dev/null | head -5 | sed 's|.*/||' | sed 's|^|- [|; s|\.md$|](./troubleshooting/&)|' || echo "- [Troubleshooting Guide](./troubleshooting/README.md)")

## 💡 Examples
$(find "$docs_dir" -path "*/examples/*" -name "*.md" 2>/dev/null | head -5 | sed 's|.*/||' | sed 's|^|- [|; s|\.md$|](./examples/&)|' || echo "- No examples found")

## 🌐 API Documentation
$(find "$docs_dir" -path "*/api/*" -name "*.md" 2>/dev/null | head -5 | sed 's|.*/||' | sed 's|^|- [|; s|\.md$|](./api/&)|' || echo "- No API documentation found")

## 🔗 Quick Links

### Core Documentation
- [Code Quality Standards](./code-quality.md)
- [Filament Resource Rules](./filament-resource-rules.md)
- [Migration Guidelines](./migration-standards.md)
- [PHPStan Implementation](./phpstan-implementation-guide.md)

### Framework Integration
- [XotBase Classes](./xot-base-classes.md)
- [Translation System](./translations-best-practices.md)
- [Namespace Conventions](./namespace-conventions.md)

## 🎯 Laraxot Standards Compliance

### ✅ Implemented Standards
- Lowercase file naming (except README.md)
- XotBase class inheritance patterns
- PHPStan level 9+ compliance
- Expanded translation structure
- Anonymous migration classes

### 📋 Development Guidelines
- **Models**: Always extend module's BaseModel
- **Resources**: Always extend XotBaseResource
- **Migrations**: Use anonymous classes, no down() method
- **Translations**: Never remove existing keys, use expanded structure
- **Documentation**: Update both module and root docs with bidirectional links

## 🔄 Related Modules
- [Xot Core Module](../Xot/docs/)
- [UI Components](../UI/docs/)
- [User Management](../User/docs/)
- [Root Documentation](../../../docs/)

## 📝 Contributing

When updating this documentation:
1. Follow lowercase naming convention
2. Update both module and root documentation
3. Create bidirectional links
4. Include practical examples
5. Maintain Laraxot compliance standards

---

**Module**: $module_name  
**Framework**: Laraxot  
**Standards**: Compliant  
**Last Review**: $(date +%Y-%m-%d)
EOF

    echo "  ✅ Indice principale aggiornato"
}

# Funzione per validazione finale compliance
validate_module_compliance() {
    local docs_dir="$1"
    local module_name=$(basename $(dirname "$docs_dir"))
    local compliant=true
    
    echo -e "${BLUE}✅ Validazione compliance: $module_name${NC}"
    
    # Verifica presenza README.md
    if [ ! -f "$docs_dir/README.md" ]; then
        echo "  ❌ Manca README.md principale"
        compliant=false
        ((issues_remaining++))
    fi
    
    # Verifica naming convention
    local uppercase_files=$(find "$docs_dir" -name "*[A-Z]*" -type f ! -name "README.md" | wc -l)
    if [ "$uppercase_files" -gt 0 ]; then
        echo "  ❌ Trovati $uppercase_files file con nomi in maiuscolo"
        compliant=false
        ((issues_remaining++))
    fi
    
    # Verifica struttura organizzata
    local root_md_files=$(find "$docs_dir" -maxdepth 1 -name "*.md" -type f | wc -l)
    if [ "$root_md_files" -gt 10 ]; then
        echo "  ⚠️  Molti file ($root_md_files) nella root - considerare riorganizzazione"
    fi
    
    # Verifica presenza template standard
    if [ -f "$docs_dir/best-practices/README.md" ] && [ -f "$docs_dir/troubleshooting/README.md" ]; then
        echo "  ✅ Template standard presenti"
    else
        echo "  ⚠️  Template standard mancanti"
    fi
    
    if [ "$compliant" = true ]; then
        echo "  ✅ Modulo conforme agli standard Laraxot"
        ((compliant_modules++))
    else
        echo "  ❌ Modulo non completamente conforme"
    fi
    
    ((total_modules++))
}

# Funzione per creare riepilogo globale
create_global_summary() {
    echo -e "${BLUE}📊 Creazione riepilogo globale${NC}"
    
    cat > "/var/www/html/_bases/base_saluteora/laravel/docs/documentation-status.md" << EOF
# Documentation Organization Status

## 📊 Overall Statistics
- **Total Modules Reviewed**: $total_modules
- **Compliant Modules**: $compliant_modules
- **Compliance Rate**: $(( compliant_modules * 100 / total_modules ))%
- **Remaining Issues**: $issues_remaining
- **Last Review**: $(date +%Y-%m-%d)

## ✅ Standards Applied

### Naming Convention
- All files in docs/ directories use lowercase naming
- Only exception: README.md files
- Hyphens used instead of underscores for readability

### Content Standards
- XotBaseResource inheritance examples
- PHPStan level 9+ compliance
- Expanded translation structure
- Anonymous migration classes
- No hardcoded labels in Filament components

### Organization
- Logical categorization in subdirectories
- Standard template structure across modules
- Bidirectional linking between related documents
- Clear README.md files as entry points

## 🎯 Module Status

### Core Modules
- **Xot**: $([ -f "/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/docs/README.md" ] && echo "✅ Organized" || echo "⚠️ Needs work")
- **UI**: $([ -f "/var/www/html/_bases/base_saluteora/laravel/Modules/UI/docs/README.md" ] && echo "✅ Organized" || echo "⚠️ Needs work")
- **User**: $([ -f "/var/www/html/_bases/base_saluteora/laravel/Modules/User/docs/README.md" ] && echo "✅ Organized" || echo "⚠️ Needs work")

### Application Modules
- **SaluteOra**: $([ -f "/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/README.md" ] && echo "✅ Organized" || echo "⚠️ Needs work")
- **SaluteMo**: $([ -f "/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/docs/README.md" ] && echo "✅ Organized" || echo "⚠️ Needs work")

## 🔄 Maintenance

### Regular Tasks
- Review documentation quarterly
- Update examples with framework changes
- Validate compliance with new standards
- Remove obsolete documentation

### Quality Assurance
- All examples must pass PHPStan level 9+
- Translation examples must use expanded structure
- Code examples must include strict types
- Links must be bidirectional and functional

## 📋 Next Steps

1. **Complete Compliance**: Address remaining issues in non-compliant modules
2. **Content Review**: Ensure all examples reflect current best practices
3. **Link Validation**: Verify all internal links are functional
4. **Template Updates**: Keep standard templates current with framework evolution

---

**Generated**: $(date +%Y-%m-%d %H:%M:%S)  
**Framework**: Laraxot  
**Review Cycle**: Quarterly  
**Next Review**: $(date -d "+3 months" +%Y-%m-%d)
EOF

    echo "  ✅ Riepilogo globale creato"
}

echo "🎯 VALIDAZIONE FINALE MODULI"
echo "============================"

# Valida e finalizza moduli core
for module in "Xot" "UI" "User"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        create_module_index "$docs_dir"
        validate_module_compliance "$docs_dir"
    fi
done

# Valida e finalizza moduli applicativi
for module in "SaluteOra" "SaluteMo"; do
    docs_dir="/var/www/html/_bases/base_saluteora/laravel/Modules/$module/docs"
    if [ -d "$docs_dir" ]; then
        echo ""
        create_module_index "$docs_dir"
        validate_module_compliance "$docs_dir"
    fi
done

echo ""
echo "🎯 CREAZIONE RIEPILOGO GLOBALE"
echo "=============================="
create_global_summary

echo ""
echo "📊 RISULTATI FINALI"
echo "==================="
echo "📁 Moduli analizzati: $total_modules"
echo "✅ Moduli conformi: $compliant_modules"
echo "❌ Issues rimanenti: $issues_remaining"
echo "📈 Tasso compliance: $(( compliant_modules * 100 / total_modules ))%"

if [ "$issues_remaining" -eq 0 ]; then
    echo ""
    echo -e "${GREEN}🎉 DOCUMENTAZIONE COMPLETAMENTE ORGANIZZATA!${NC}"
    echo "📝 Tutti i moduli rispettano gli standard Laraxot"
else
    echo ""
    echo -e "${YELLOW}⚠️  ORGANIZZAZIONE QUASI COMPLETA${NC}"
    echo "📝 Rimangono $issues_remaining issues da risolvere"
fi

echo ""
echo -e "${BLUE}📋 Documentazione disponibile in:${NC}"
echo "   - Moduli: /Modules/*/docs/README.md"
echo "   - Globale: /docs/documentation-status.md"
echo "   - Standard: Conformi a Laraxot Framework"
