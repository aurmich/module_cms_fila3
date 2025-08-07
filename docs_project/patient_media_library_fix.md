# Patient Media Library Fix - Riferimenti Rapidi

## 🚨 Errore Critico Attivo

**Status**: URGENT - Sistema di registrazione pazienti non funzionale

## Problema Principale

**Array to string conversion** durante registrazione paziente causato da conflitto architetturale:
- ❌ Colonne database per attachments
- ✅ Spatie Media Library per attachments  
- 🚨 RegisterAction passa array a colonne string

## Fix Documentazione Completa

➡️ **Vedi**: [array-to-string-conversion-patient-registration.md](./errori/array-to-string-conversion-patient-registration.md)

## Quick Fix (Soluzione 1)

Modificare `RegisterAction.php` linea 30:

```php
// PRIMA (❌ errore)
$patient = Patient::create($data);

// DOPO (✅ fix)
$attachments = Patient::$attachments;
$modelData = collect($data)->except($attachments)->toArray();
$patient = Patient::create($modelData);
```

## Fix Completo (Soluzione 2)

Rimuovere colonne attachments da migrazione:

```php
// In nuova migrazione
foreach(Patient::$attachments as $attachment) {
    if ($this->hasColumn($attachment)) {
        $table->dropColumn($attachment);
    }
}
```

## Files da Modificare

### Urgente
- `Modules/SaluteOra/app/Actions/Patient/RegisterAction.php`

### Medio Termine  
- `Modules/SaluteOra/database/migrations/2025_04_01_000007_create_users_table.php`
- `Modules/SaluteOra/app/Models/Patient.php` ($fillable)

## Test di Verifica

```bash

# Test registrazione paziente
php artisan test --filter=PatientRegistrationTest

# Test media library
php artisan test --filter=MediaLibraryTest
```

## Collegamenti Correlati

- 📋 [Spatie Media Library Implementation](./spatie_media_library_implementation.md)
- 🚨 [Errore Completo](./errori/array-to-string-conversion-patient-registration.md)  
- 📋 [Regole Cursor](./../.cursor/rules/patient-attachment-handling.mdc)
- 📋 [Regole Windsurf](./../.windsurf/rules/patient-attachment-handling.mdc)

---

**Status**: 🚨 BLOCCA REGISTRAZIONE PAZIENTI  
**Priorità**: MASSIMA  
**Tempo stimato fix**: 2-4 ore  
