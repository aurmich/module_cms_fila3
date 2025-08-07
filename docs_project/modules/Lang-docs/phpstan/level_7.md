


# Rapporto PHPStan Livello 7 per il modulo Lang

Data analisi: 2025-04-15 22:02:20

## Riepilogo

Trovati 2 errori al livello 7.

## Errori e suggerimenti

### File: `/var/www/html/saluteora/laravel/Modules/Lang/app/Models/Post.php`

#### Linea 101: Class Modules\Lang\Models\Post uses unknown trait GeneaLabs\LaravelModelCaching\Traits\Cachable.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 160: PHPDoc type array<int, string> of property Modules\Lang\Models\Post::$appends is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$appends.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

## Risorse utili

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Tipi in PHP](https://www.php.net/manual/en/language.types.declarations.php)
- [PSR-12: Standard di codifica](https://www.php-fig.org/psr/psr-12/)
aurmich/dev
aurmich/dev
aurmich/dev

## Collegamenti tra versioni di level_7.md
* [level_7.md](laravel/Modules/Chart/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Reporting/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Gdpr/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Notify/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Xot/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Dental/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/User/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/UI/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Lang/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Job/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Media/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Tenant/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Activity/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Patient/docs/phpstan/level_7.md)
* [level_7.md](laravel/Modules/Cms/docs/phpstan/level_7.md)

