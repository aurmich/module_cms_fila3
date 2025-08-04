# Regole per i Modelli in Laravel 12

## ⚠️ IMPORTANTE: SINTASSI DEPRECATA

In Laravel 12, la seguente sintassi è considerata **DEPRECATA**:

```php
protected $casts = [...];
protected $fillable = [...];
protected $hidden = [...];
protected $appends = [...];
```

## ✅ SINTASSI CORRETTA

Utilizza sempre metodi protetti con tipizzazione esplicita:

```php
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        // ...
    ];
}

/**
 * Get the fillable attributes.
 *
 * @return array<int, string>
 */
protected function fillable(): array
{
    return [
        'name',
        // ...
    ];
}
```

## MOTIVAZIONI

1. Laravel 12 ha adottato un approccio più fortemente tipizzato
2. La nuova sintassi offre migliore supporto IDE e type safety
3. Rappresenta la direzione futura del framework

## VERIFICA AUTOMATICA

Prima di ogni commit, utilizzare:

```bash

# Cerca proprietà deprecate nei modelli
grep -r "protected \$casts" --include="*.php" /var/www/html/base_saluteora/laravel/Modules
grep -r "protected \$fillable" --include="*.php" /var/www/html/base_saluteora/laravel/Modules
grep -r "protected \$hidden" --include="*.php" /var/www/html/base_saluteora/laravel/Modules
```

## PROCESSO DI MIGRAZIONE

1. Per ogni modello (`class XYZ extends Model`):
   - Cambiare `protected $property` a `public array $property`
   - Mantenere lo stesso contenuto dell'array
   - Verificare che tutti i type-hint siano corretti

2. Assicurarsi che la tipizzazione sia accurata:
   - `array` per la maggior parte delle proprietà
   - `string` per proprietà come `$table`, `$connection`
   - `?string` per proprietà opzionali

## DOCUMENTAZIONE COMPLETA

Per approfondimenti consultare:
`/var/www/html/base_saluteora/laravel/Modules/Xot/docs/laravel12/property-promotion.md`
