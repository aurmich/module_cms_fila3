# Collegamenti Documentazione SaluteOra

## Overview
Questo documento serve come indice centrale per tutti i file di documentazione nel progetto SaluteOra, fornendo collegamenti bidirezionali tra i vari moduli e la documentazione principale. L'obiettivo è garantire che tutte le informazioni siano facilmente accessibili e interconnesse.

## Documentazione Principale
- **Root Documentation**: `/var/www/html/saluteora/docs/`
  - [Collegamenti Documentazione](./collegamenti-documentazione.md) (Questo documento)

## Moduli e Documentazione Specifica

### Modulo Patient
- **Path**: `/var/www/html/saluteora/laravel/Modules/Patient/docs/`
- **Documenti**:
  - [Model Inheritance](../Modules/Patient/docs/MODEL_INHERITANCE.md)
  - [Validation Errors](../Modules/Patient/docs/VALIDATION_ERRORS.md)
  - [Namespace Conventions](../Modules/Patient/docs/NAMESPACE_CONVENTIONS.md)
  - [Filament Customization](../Modules/Patient/docs/FILAMENT_CUSTOMIZATION.md)
  - [Translations](../Modules/Patient/docs/TRANSLATIONS.md)
  - [URL Localization](../Modules/Patient/docs/URL_LOCALIZATION.md)

### Modulo Xot
- **Path**: `/var/www/html/saluteora/laravel/Modules/Xot/docs/`
- **Documenti**:
  - [Xot Base Classes](../Modules/Xot/docs/XOT_BASE_CLASSES.md)
  - [Code Quality](../Modules/Xot/docs/CODE_QUALITY.md)

### Altri Moduli
- **User Module**: `/var/www/html/saluteora/laravel/Modules/User/docs/`
  - [Auth Pages Implementation](../Modules/User/docs/AUTH_PAGES_IMPLEMENTATION.md)
  - [Logout Blade Implementation](../Modules/User/docs/LOGOUT_BLADE_IMPLEMENTATION.md)
  - [Database Issues in User Module](../Modules/User/docs/DATABASE_ISSUES.md)
- **Notify Module**: `/var/www/html/saluteora/laravel/Modules/Notify/docs/`
  - [Filament Extension Pattern](../Modules/Notify/docs/FILAMENT_EXTENSION_PATTERN.md)
  - [Filament Extension Pattern Analysis](../Modules/Notify/docs/FILAMENT_EXTENSION_PATTERN_ANALYSIS.md)
  - [SMS Config Structure](../Modules/Notify/docs/SMS_CONFIG_STRUCTURE.md)
  - [Notifications](../Modules/Notify/docs/notifications/)

## Regole e Linee Guida
- **Regole di Progetto**: `/var/www/html/saluteora/laravel/.cursor/rules/` e `/var/www/html/saluteora/laravel/.windsurf/rules/`
  - [Filament Extension Pattern](../.cursor/rules/filament-extension-pattern.md)
  - [Filament Extension Best Practices](../.cursor/rules/filament-extension-best-practices.md)
  - [Notification Channels](../docs/rules/notification-channels.md)
  - [Notifications Implementation](../.windsurf/rules/notifications-implementation.md)
  - [Migration Base Class Rule](../../.windsurf/rules/migration-base-class.mdc) - Rules for migration file creation and updates.

## Note
- Ogni documento di documentazione deve avere almeno 5 collegamenti bidirezionali ad altri file di documentazione per garantire una rete di informazioni interconnessa.
- Assicurarsi che i nuovi file di documentazione siano aggiunti a questo indice per mantenere la coerenza.

Questo documento sarà aggiornato man mano che nuovi moduli e file di documentazione vengono aggiunti al progetto SaluteOra.

---

Ultimo aggiornamento: `<!-- DATA AUTO-AGGIORNATA -->`
