# Documentazione Modulo Xot

Il modulo Xot fornisce funzionalità di base per il framework Laraxot, incluse azioni, servizi, e componenti fondamentali.

## Struttura della Documentazione

### Core Features
- [Development Rules](development-rules.md) - Regole di sviluppo per il modulo
- [Code Quality](code_quality.md) - Standard di qualità del codice
- [Best Practices](best-practices.md) - Pratiche consigliate
- [Translation Rules](translation_rules.md) - Regole per file di traduzione
- [Xot Base Translation Update](xot_base_translation_update.md) - ⭐ **NUOVO** - Aggiornamento file traduzioni base

### Testing
- [Testing Guidelines](testing.md) - ⭐ **IMPORTANTE** - Regole per organizzazione test del modulo Xot
- Regola fondamentale: **TUTTI i test che verificano codice `Modules\Xot\*` DEVONO essere in `Modules/Xot/tests/`**

### PHPStan e Qualità del Codice
- [PHPStan Level 10 Guide](phpstan_livello10_linee_guida.md) - Guida completa per PHPStan livello 10
- [PHPStan Level 9 Guide](phpstan-level9-guide.md) - Guida per PHPStan livello 9
- [PHPStan Generic Types](phpstan-generic-types.md) - Gestione tipi generici
- [PHPStan Collection Types](phpstan-collection-types.md) - ⭐ **NUOVO** - Gestione incompatibilità tipi Collection
- [PHPStan Fixes Gennaio 2025](phpstan-fixes-gennaio-2025.md) - ⭐ **COMPLETATO** - Log dettagliato correzioni PHPStan

### Exception Handling
- [Exception Handler Decorator](exceptions/handler-decorator.md) - Pattern decorator per gestione eccezioni
- [Exception Handler Types](exceptions/exception-handler-types.md) - ⭐ **NUOVO** - Tipizzazione corretta ExceptionHandler

### UI Components
- [Filament Integration](filament-integration.md) - Integrazione con Filament
- [Form Components](form-components.md) - Componenti per form
- [Blade Components](blade-components.md) - Componenti Blade personalizzati

### File Management
- [Asset Management](asset-management.md) - Gestione asset e risorse
- [Export System](export-system.md) - Sistema di esportazione dati

### Utilities
- [Helper Functions](helpers.md) - Funzioni di utilità
- [Data Transfer Objects](dtos.md) - Pattern DTO con Spatie Laravel Data
- [Actions](actions.md) - Azioni asincroni con Spatie QueueableAction

## Modifiche Recenti

### Gennaio 2025 - File di Traduzione Base ⭐ **NUOVO**

**Stato**: **COMPLETATO** - Aggiornamento e sistemazione file `xot_base.php`

**Modifiche principali**:
- ✅ Conversione da `array()` a sintassi `[]` moderna
- ✅ Aggiunta `declare(strict_types=1);` per tipizzazione rigorosa
- ✅ Rimozione duplicazioni e campi `helper_text` vuoti
- ✅ Risoluzione conflitti di merge non risolti
- ✅ Miglioramento struttura e coerenza traduzioni
- ✅ Validazione sintassi PHP con `php -l`

**Impatto**: Miglioramento qualità codice e conformità best practice Laraxot

Vedi [xot_base_translation_update.md](xot_base_translation_update.md) per dettagli completi.

### Gennaio 2025 - Testing Organization ⭐ **NUOVO**

**Stato**: **IMPLEMENTATO** - Sistema di organizzazione test modularizzato

**Regola chiave**: 
- ✅ Test del modulo Xot SOLO in `Modules/Xot/tests/`
- ❌ MAI test del modulo Xot in `/tests/` (cartella root)

**Motivazione**: Prevenire sovrascritture durante aggiornamenti Laravel

**Test esistenti nel modulo**:
- ✅ `MetatagDataTest.php` - Test per `Modules\Xot\Datas\MetatagData`
- ✅ `HasXotTableTest.php` - Test per trait `HasXotTable`

### Gennaio 2025 - PHPStan Level 9 Compliance ✅

**Stato**: **COMPLETATO** - Tutti gli errori PHPStan livello 9 del modulo Xot sono stati risolti

**Errori risolti**: 9 errori principali
- ✅ ExceptionHandler::handles() - Missing return type
- ✅ Collection type incompatibility in Export actions
- ✅ PathHelper::getModules() - Array type inference
- ✅ DownloadZipByPathsDiskAction - Missing return type e null handling
- ✅ GetViewByClassAction - view-string type compliance
- ✅ SendMailByRecordAction - Model property/method safety
- ✅ PdfByHtmlAction - Syntax errors e return type
- ✅ MetatagData::getThemeColors() - Array type mismatch

**Files modificati**: 6 files core + documentazione aggiornata
**PHPStan status**: `[OK] No errors` per tutto il modulo Xot

Vedi [phpstan-fixes-gennaio-2025.md](phpstan-fixes-gennaio-2025.md) per dettagli completi.

## Guide di Riferimento

### Sviluppo
- [Coding Standards](coding-standards.md) - Standard di codifica del modulo
- [Testing Guidelines](testing.md) - Linee guida per i test
- [Deployment](deployment.md) - Procedure di deployment

### Troubleshooting
- [Common Issues](troubleshooting.md) - Problemi comuni e soluzioni
- [Debug Guide](debug-guide.md) - Guida al debugging

## Links Utili

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)

*Ultimo aggiornamento: Gennaio 2025* 
