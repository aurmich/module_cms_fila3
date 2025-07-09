# Modulo Lang - Documentazione

## Descrizione
Il modulo Lang gestisce le traduzioni e la localizzazione dell'applicazione SaluteOra, fornendo un sistema centralizzato per la gestione dei file di traduzione.

## Documentazione

### Standard e Best Practices
- [Translation Standards](translation-standards.md) - Standard per le traduzioni nel progetto
- [Translation Files Update 2025](translation_files_update_2025.md) - ⭐ **NUOVO** - Aggiornamento file traduzioni
- [Docs Naming Convention Fix](docs-naming-convention-fix.md) - ⭐ **NUOVO** - Correzione convenzione naming cartelle docs

### Collegamenti Esterni
- [Laravel Translatable (dimsav)](https://github.com/dimsav/laravel-translatable)
- [Laravel Translatable (Astrotomic)](https://github.com/Astrotomic/laravel-translatable)
- [Laravel Translatable (Spatie)](https://github.com/spatie/laravel-translatable)
- [10 Best Laravel Packages for Multi-language Translations](https://blog.quickadminpanel.com/10-best-laravel-packages-for-multi-language-translations/)

## Modifiche Recenti

### Gennaio 2025 - Correzione Convenzione Naming Docs ⭐ **NUOVO**

**Stato**: **COMPLETATO** - Correzione convenzione naming cartelle docs

**Modifiche principali**:
- ✅ Rimozione caratteri maiuscoli da tutti i file (eccetto README.md)
- ✅ Rinominazione sottocartelle con caratteri maiuscoli
- ✅ Standardizzazione convenzione naming in tutti i moduli
- ✅ Verifica completa di tutte le cartelle docs

**Moduli interessati**: Xot, Geo, UI, User, SaluteOra, Notify, Lang

**Impatto**: Consistenza e standardizzazione convenzione naming

Vedi [docs-naming-convention-fix.md](docs-naming-convention-fix.md) per dettagli completi.

### Gennaio 2025 - Aggiornamento File di Traduzione ⭐ **NUOVO**

**Stato**: **COMPLETATO** - Aggiornamento e sistemazione file di traduzione

**File modificati**:
- ✅ `Modules/Notify/lang/it/test_smtp.php` - Sistema test SMTP
- ✅ `Modules/Notify/lang/it/send_email.php` - Invio email
- ✅ `Modules/Lang/lang/it/lang_service.php` - Servizio traduzioni base

**Modifiche principali**:
- ✅ Conversione da `array()` a sintassi `[]` moderna
- ✅ Aggiunta `declare(strict_types=1);` per tipizzazione rigorosa
- ✅ Risoluzione conflitti di merge non risolti
- ✅ Rimozione duplicazioni e campi `helper_text` vuoti
- ✅ Miglioramento struttura e coerenza traduzioni
- ✅ Validazione sintassi PHP con `php -l`

**Impatto**: Miglioramento qualità codice e conformità best practice Laraxot

Vedi [translation_files_update_2025.md](translation_files_update_2025.md) per dettagli completi.

## Collegamenti tra versioni di readme.md
* [readme.md](../../../Gdpr/docs/readme.md)
* [readme.md](../../../UI/docs/readme.md)
* [readme.md](../../../Lang/docs/readme.md)
* [readme.md](../../../Activity/docs/readme.md)
* [readme.md](../../../Cms/docs/readme.md)

## Extra risorse da _docs

(Nessun nuovo link da aggiungere: i link di _docs/readme.txt sono già presenti in questo file)
