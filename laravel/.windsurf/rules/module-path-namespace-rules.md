# Regole per Path e Namespace nei Moduli

## Regola Fondamentale

In SaluteOra, esiste una distinzione importante tra il path fisico dei file e il namespace PHP:

- Il path fisico include la cartella `app` (minuscolo): `/var/www/html/saluteora/laravel/Modules/NomeModulo/app/...`
- Il namespace PHP **NON** include il segmento `App`: `Modules\NomeModulo\...`

## Path Fisici Corretti

```
/var/www/html/saluteora/laravel/Modules/NomeModulo/app/Actions/...
/var/www/html/saluteora/laravel/Modules/NomeModulo/app/Http/Controllers/...
/var/www/html/saluteora/laravel/Modules/NomeModulo/app/Providers/...
/var/www/html/saluteora/laravel/Modules/NomeModulo/app/Models/...
/var/www/html/saluteora/laravel/Modules/NomeModulo/app/Filament/...
```

## Namespace Corretti

```php
namespace Modules\NomeModulo\Actions\...;
namespace Modules\NomeModulo\Http\Controllers\...;
namespace Modules\NomeModulo\Providers\...;
namespace Modules\NomeModulo\Models\...;
namespace Modules\NomeModulo\Filament\...;
```

## Errori Comuni da Evitare

1. **Path con `App` maiuscolo**: 
   ```
   ❌ /var/www/html/saluteora/laravel/Modules/NomeModulo/App/...
   ```

2. **Namespace con `App`**:
   ```php
   ❌ namespace Modules\NomeModulo\App\...;
   ```

3. **Path senza `app`**:
   ```
   ❌ /var/www/html/saluteora/laravel/Modules/NomeModulo/Actions/...
   ```

## Esempi Concreti

### Esempio 1: Action

**Path fisico corretto:**
```
/var/www/html/saluteora/laravel/Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
/var/www/html/saluteora/laravel/Modules/User/app/Http/Controllers/ProfileController.php
```

**Namespace corretto:**
```php
namespace Modules\User\Http\Controllers;
```

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto SaluteOra.

## Documentazione Correlata

- [Regole Generali per i Namespace](/laravel/Modules/Xot/docs/NAMESPACE-RULES.md)
- [Regole per Path e Namespace in Notify](/laravel/Modules/Notify/docs/PATH_AND_NAMESPACE_RULES.md)

---

*Ultimo aggiornamento: 2025-05-12*
