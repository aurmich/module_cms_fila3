# Rapporto PHPStan Livello 2 per il modulo Cms

Data analisi: 2025-04-15 22:09:14

## Riepilogo

Trovati 1 errori al livello 2.

## Errori e suggerimenti

### File: `/var/www/html/saluteora/laravel/Modules/Cms/app/Models/Menu.php`

#### Linea 160: PHPDoc tag @var with type class-string<Modules\Xot\Contracts\HasRecursiveRelationshipsContract> is not subtype of native type 'Modules\\Cms\\Models\\Menu'.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

## Risorse utili

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Tipi in PHP](https://www.php.net/manual/en/language.types.declarations.php)
- [PSR-12: Standard di codifica](https://www.php-fig.org/psr/psr-12/)
