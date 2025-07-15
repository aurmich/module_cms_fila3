# Collegamenti agli Standard di Traduzione

## Documentazione Principale
- [Regole Generali Traduzioni](translation_standards.md)
- [Best Practices Filament](filament_translation_best_practices.md)
- [Struttura File Traduzione](translation_file_structure.md)

## Moduli Specifici
- [Modulo User - Traduzioni](laravel/Modules/User/docs/translations.md)
- [Modulo Performance - Traduzioni](laravel/Modules/Performance/docs/translation_guidelines.md)
- [Modulo UI - Componenti](laravel/Modules/UI/docs/components.md)
- [Modulo Xot - Regole Base](laravel/Modules/Xot/docs/translation_rules.md)

## Esempi e Fix
- [Fix Traduzioni Performance](laravel/Modules/Performance/docs/organizzativa-migration-errors.md)
- [Fix Traduzioni Xot Base](laravel/Modules/Xot/docs/xot_base_translation_update.md)
- [Fix Traduzioni UI Opening Hours](laravel/Modules/UI/docs/opening_hours_field_translation_fix.md)
- [Fix Traduzioni SaluteOra Doctor Calendar](laravel/Modules/SaluteOra/docs/doctor_availability_calendar_traduzioni.md)
- [Fix Traduzioni Notify Send Email](laravel/Modules/Notify/docs/send_email_translation_fix.md) - **REGOLA IMPORTANTE**: tooltip e helper_text per ogni campo

## Regole Critiche
- [Helper Text Rules](translation-helper-text-standards.md) - **CRITICO**: helper_text diverso da placeholder
- [Filament Translation Rules](filament_translation_rules.md) - MAI usare ->label()
- [Translation Management](translation_management_rules.md) - Gestione automatica traduzioni

## Struttura e Organizzazione
- [Convenzioni Naming](naming_conventions.md)
- [Struttura Moduli](module_structure.md)
- [Best Practices Laravel](laravel_best_practices.md)

## Testing e Validazione
- [PHPStan Translation Rules](phpstan_translation_rules.md)
- [Translation Testing](translation_testing.md)
- [Quality Assurance](translation_qa.md)

## Aggiornamenti Recenti
- **2025-01-06**: Aggiornamento regole helper_text - tooltip obbligatorio per ogni campo
- **2025-01-06**: Fix completo file send_email.php con tooltip e helper_text
- **2025-01-05**: Aggiornamento convenzioni naming traduzioni
- **2025-01-04**: Fix traduzioni modulo Performance
- **2025-01-03**: Aggiornamento documentazione Xot base

## Note Importanti
- **REGOLA CRITICA**: Ogni campo con label e placeholder DEVE avere tooltip e helper_text
- **REGOLA CRITICA**: helper_text deve essere diverso da placeholder, altrimenti impostare a ''
- **REGOLA CRITICA**: MAI usare ->label() nei componenti Filament
- **REGOLA CRITICA**: Struttura espansa obbligatoria per tutti i campi
