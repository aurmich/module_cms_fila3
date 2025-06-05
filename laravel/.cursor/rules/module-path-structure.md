# Struttura Path vs Namespace nei Moduli Laravel

## ⚠️ REGOLA FONDAMENTALE

Nei moduli Laravel (nwidart/laravel-modules), esiste una discrepanza intenzionale tra il percorso fisico dei file e il loro namespace:

## Path vs Namespace

| Percorso Fisico (CORRETTO) | Namespace (CORRETTO) |
|----------------------------|----------------------|
| `Modules/Blog/app/Models/Post.php` | `Modules\Blog\Models\Post` |
| `Modules/User/app/Http/Controllers/UserController.php` | `Modules\User\Http\Controllers\UserController` |

## ❌ ERRORI COMUNI

```php
// ERRORE: riferimento al percorso sbagliato (manca "app/")
$path = "/var/www/html/base_saluteora/laravel/Modules/Notify/Models/MailTemplate.php";

// ERRORE: namespace errato (include "app")
namespace Modules\Notify\app\Models;
```

## ✅ CORREZIONI

```php
// CORRETTO: percorso fisico
$path = "/var/www/html/base_saluteora/laravel/Modules/Notify/app/Models/MailTemplate.php";

// CORRETTO: namespace
namespace Modules\Notify\Models;
```

## 🔍 VERIFICA AUTOMATICA

Prima di ogni commit, verifica:

```bash
# Controlla namespace errati che includono "app"
grep -r "namespace Modules\\\\.*\\\\app\\\\" --include="*.php" /var/www/html/base_saluteora/laravel/Modules

# Controlla riferimenti a percorsi errati
grep -r "Modules/[A-Za-z]*/[A-Za-z]*/[A-Za-z]*" --include="*.php" /var/www/html/base_saluteora/laravel/ | grep -v "Modules/[A-Za-z]*/app/"
```

## 📝 DOCUMENTAZIONE COMPLETA

Per tutti i dettagli, consultare:
`/var/www/html/base_saluteora/laravel/Modules/Xot/docs/modules/structure.md`
