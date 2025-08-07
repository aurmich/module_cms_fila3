# Fix: FileUpload Error - foreach() argument must be of type array|object, string given

## 🚨 Problema Identificato

L'errore si verificava durante la registrazione dei dottori nel form wizard:

```
ErrorException
foreach() argument must be of type array|object, string given
vendor/filament/forms/src/Components/BaseFileUpload.php :740
```

## 🔍 Causa Root

Il componente `FileUpload` di Filament si aspetta che lo stato del campo sia sempre un **array**, ma il campo `certification` nel modello `Doctor` veniva salvato come **stringa** nel database.

### Problema nel Modello

```php
// ❌ PROBLEMATICO: Nel metodo casts() mancava il cast per 'certification'
protected function casts(): array {
    return array_merge(parent::casts(), [
        'certifications' => 'array',  // Solo questo
        // 'certification' => 'array',  // ❌ QUESTO MANCAVA!
    ]);
}
```

### Configurazione Componente

Nel `XotBaseResource.php`, il metodo `getAttachmentsSchema()` crea componenti `FileUpload` per ogni elemento in `$attachments`:

```php
// Da XotBaseResource.php
public static function getAttachmentsSchema(bool $multiple=true): array {
    $attachments = $model::$attachments; // ['certification']
    
    foreach ($attachments as $attachment) {
        $schema[] = Forms\Components\FileUpload::make($attachment)
            ->multiple($multiple)  // false nel nostro caso
            ->afterStateUpdated(function ($state, Forms\Set $set) use ($attachment) {
                $state = Arr::wrap($state);  // Forza sempre array
                $set($attachment, $sessionFiles);  // Salva array
            });
    }
}
```

## ✅ Soluzione Implementata

Aggiunto il cast `'array'` per il campo `certification` nel modello `Doctor`:

```php
// ✅ CORRETTO: Cast aggiunto per certification
protected function casts(): array {
    return array_merge(parent::casts(), [
        'certifications' => 'array',
        'certification' => 'array',  // ✅ FIX AGGIUNTO
    ]);
}
```

## 🎯 Risultato

Ora il campo `certification`:
1. **Viene salvato** come JSON array nel database
2. **Viene caricato** automaticamente come array in PHP
3. **È compatibile** con il componente `FileUpload` di Filament

## 📋 Regola Generale

**Per tutti i campi FileUpload in Laraxot:**

1. Se il campo è nell'array `$attachments` del modello
2. Deve SEMPRE avere il cast `'array'` nel metodo `casts()`
3. Anche se `multiple(false)`, Filament gestisce internamente come array

### Template per Nuovi Modelli

```php
class MyModel extends BaseModel {
    public static array $attachments = [
        'document1',
        'document2',
    ];
    
    protected function casts(): array {
        return array_merge(parent::casts(), [
            'document1' => 'array',  // ✅ SEMPRE necessario
            'document2' => 'array',  // ✅ SEMPRE necessario
        ]);
    }
}
```

## 🔗 Files Modificati

- `laravel/Modules/SaluteOra/app/Models/Doctor.php` - Aggiunto cast array per certification

## 🔗 Collegamenti

- [XotBaseResource.php](../../Xot/app/Filament/Resources/XotBaseResource.php) - Metodo getAttachmentsSchema()
- [Doctor.php](../app/Models/Doctor.php) - Modello modificato
- [Filament FileUpload Documentation](https://filamentphp.com/docs/3.x/forms/fields/file-upload)

---

**Data Fix**: 2025-01-03  
**Autore**: AI Assistant  
**Priorità**: Critica  
**Status**: ✅ Risolto 