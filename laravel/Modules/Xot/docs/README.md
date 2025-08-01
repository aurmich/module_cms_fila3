# Xot Module Documentation

## 📊 Documentation Overview
- **Total Documents**: 502
- **Categories**: 101
- **Last Updated**: 2025-08-01
- **Compliance**: Laraxot Framework Standards

## 🏗️ Architecture & Design
- [method-evolution](./architecture/.md)
- [forbidden-methods](./architecture/.md)
- [patterns](./architecture/.md)
- [architettura-sistema](./architecture/.md)
- [struttura-percorsi](./architecture/.md)

## 📋 Best Practices
- [README](./best-practices/.md)

## 🔧 Configuration


## 🚨 Troubleshooting
- [widget-fileupload-errors](./troubleshooting/.md)
- [README](./troubleshooting/.md)

## 💡 Examples
- [safe-float-cast-usage](./examples/.md)

## 🌐 API Documentation


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

**Module**: Xot  
**Framework**: Laraxot  
**Standards**: Compliant  
**Last Review**: 2025-08-01
