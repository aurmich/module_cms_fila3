# Rapporto PHPStan Livello 6 per il modulo Chart

Data analisi: 2025-05-05 11:15:00

## Riepilogo

Trovati errori al livello 6 che richiedono attenzione.

## Errori e suggerimenti

### File: `{project_root}/laravel/Modules/Chart/Providers/ChartServiceProvider.php`

#### Linea 11: Class Modules\Chart\Providers\ChartServiceProvider extends unknown class Modules\Chart\app\Providers\ChartServiceProvider.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I namespace siano corretti e coerenti
- Le classi estese esistano nel percorso specificato

### File: `{project_root}/laravel/Modules/Chart/app/Filament/Resources/ChartResource/Pages/ListCharts.php`

#### Linea 30: Method Modules\Chart\Filament\Resources\ChartResource\Pages\ListCharts::getListTableColumns() should return array<string, Filament\Tables\Columns\Column> but returns array<int, Filament\Tables\Columns\TextColumn>.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- I metodi restituiscano i tipi corretti secondo le interfacce implementate
- Gli array associativi utilizzino chiavi di tipo string quando richiesto
- I tipi di ritorno siano dichiarati correttamente

### File: `{project_root}/laravel/Modules/Chart/app/Models/Chart.php`

#### Linea 26: PHPDoc tag @property-read per proprietà contiene riferimenti a classi sconosciute.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi referenziate nei PHPDoc esistano e siano importate
- I namespace siano corretti
- Le dipendenze tra moduli siano gestite correttamente

### File: `{project_root}/laravel/Modules/Chart/app/Actions/JpGraph/V1/LineSubQuestionAction.php`

#### Linea 60-62: Costanti non trovate (MARK_FILLEDCIRCLE, MARK_UTRIANGLE).

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le costanti utilizzate siano definite o importate
- Le librerie esterne siano importate correttamente
- I namespace siano corretti

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 63: Constant MARK_SQUARE not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 64: Constant MARK_DTRIANGLE not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 65: Constant MARK_DIAMOND not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 66: Constant MARK_CIRCLE not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 68: Constant MARK_CROSS not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 69: Constant MARK_STAR not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 70: Constant MARK_X not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 71: Constant MARK_LEFTTRIANGLE not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 72: Constant MARK_RIGHTTRIANGLE not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 73: Constant MARK_FLASH not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

### File: `/var/www/html/saluteora/laravel/Modules/Chart/app/Actions/JpGraph/V1/Pie1Action.php`

#### Linea 86: Constant FF_ARIAL not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 86: Constant FS_BOLD not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 91: Constant FF_ARIAL not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 91: Constant FS_NORMAL not found.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

### File: `/var/www/html/saluteora/laravel/Modules/Chart/app/Filament/Resources/ChartResource/Pages/ListCharts.php`

#### Linea 30: Method Modules\Chart\Filament\Resources\ChartResource\Pages\ListCharts::getListTableColumns() should return array<string, Filament\Tables\Columns\Column> but returns array<int, Filament\Tables\Columns\TextColumn>.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

### File: `/var/www/html/saluteora/laravel/Modules/Chart/app/Models/Chart.php`

#### Linea 26: PHPDoc tag @property-read for property Modules\Chart\Models\Chart::$creator contains unknown class Modules\Blog\Models\Profile.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 26: PHPDoc tag @property-read for property Modules\Chart\Models\Chart::$updater contains unknown class Modules\Blog\Models\Profile.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 63: PHPDoc type array of property Modules\Chart\Models\Chart::$attributes is not covariant with PHPDoc type array<string, mixed> of overridden property Illuminate\Database\Eloquent\Model::$attributes.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

### File: `/var/www/html/saluteora/laravel/Modules/Chart/app/Models/MixedChart.php`

#### Linea 29: PHPDoc tag @property-read for property Modules\Chart\Models\MixedChart::$creator contains unknown class Modules\Blog\Models\Profile.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 29: PHPDoc tag @property-read for property Modules\Chart\Models\MixedChart::$updater contains unknown class Modules\Blog\Models\Profile.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 41: Parameter #1 $map of static method Illuminate\Database\Eloquent\Relations\Relation<Illuminate\Database\Eloquent\Model,Illuminate\Database\Eloquent\Model,mixed>::morphMap() expects array<string, class-string<Illuminate\Database\Eloquent\Model>>

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

### File: `/var/www/html/saluteora/laravel/Modules/Chart/app/Tables/Columns/ChartColumn.php`

#### Linea 46: Property Modules\Chart\Tables\Columns\ChartColumn::$view (view-string) does not accept default value of type string.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

## Risorse utili

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Tipi in PHP](https://www.php.net/manual/en/language.types.declarations.php)
- [PSR-12: Standard di codifica](https://www.php-fig.org/psr/psr-12/)

## Collegamenti tra versioni di level_6.md
* [level_6.md](laravel/Modules/Chart/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Reporting/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Gdpr/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Notify/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Xot/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Dental/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/User/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/UI/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Lang/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Job/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Media/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Tenant/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Activity/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Patient/docs/phpstan/level_6.md)
* [level_6.md](laravel/Modules/Cms/docs/phpstan/level_6.md)

