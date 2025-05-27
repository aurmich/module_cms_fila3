# Modello GeoJsonModel (ispirato a Squire) per Laravel

## Filosofia e motivazione

- **KISS**: Nessuna necessità di creare tabelle/migration per dati statici e condivisi come regioni, province, comuni, CAP. Il dato rimane "immutabile" e facilmente versionabile.
- **DRY**: Una sola fonte di verità (il file JSON, es: `comuni.json`), facilmente aggiornabile e condivisa da tutto il sistema.
- **Performance**: Per dataset di dimensioni ridotte/medie, la lettura da file + cache è più che sufficiente e non grava sul database.
- **Zen**: Il dato "vive" fuori dal DB, è sempre coerente, trasparente e ispezionabile.
- **Politica**: Separazione netta tra dominio applicativo e dati statici; niente coupling forzato con il DB.

## Struttura proposta

### 1. File dati

- Tutti i dati geografici sono contenuti in `/Modules/Geo/resources/json/comuni.json`.
- Il file contiene array di oggetti con chiavi come: `region`, `province`, `city`, `cap`, `istat`, ecc.
- Esempio struttura:

```json
[
  {
    "region": "Lombardia",
    "province": "Milano",
    "city": "Milano",
    "cap": "20100",
    "istat": "015146"
  },
  ...
]
```

### 2. GeoJsonModel base (readonly)

- Una classe base `GeoJsonModel` che legge e cache-izza il contenuto del JSON.
- Espone metodi simili a Eloquent/Collection: `all()`, `where()`, `find($id)`.
- Le classi specifiche (Region, Province, City, Cap) estendono questa base e forniscono filtri/estrazioni dedicate.

#### Esempio base:

```php
namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

abstract class GeoJsonModel
{
    protected static string $jsonFile = '';

    protected static function loadData(): Collection
    {
        $path = module_path('Geo', 'Resources/json/comuni.json');
        $data = cache()->rememberForever('geo_comuni_json', fn() => json_decode(file_get_contents($path), true));
        return collect($data);
    }

    public static function all(): Collection
    {
        return static::loadData();
    }

    public static function where($key, $value): Collection
    {
        return static::all()->where($key, $value);
    }
}
```

#### Esempi di estensione:

```php
class Region extends GeoJsonModel
{
    public static function all(): Collection
    {
        return static::loadData()->pluck('region')->unique()->values();
    }
}

class Province extends GeoJsonModel
{
    public static function byRegion($region): Collection
    {
        return static::loadData()->where('region', $region)->pluck('province')->unique()->values();
    }
}

class City extends GeoJsonModel
{
    public static function byProvince($province): Collection
    {
        return static::loadData()->where('province', $province)->pluck('city')->unique()->values();
    }
}

class Cap extends GeoJsonModel
{
    public static function byCity($city): Collection
    {
        return static::loadData()->where('city', $city)->pluck('cap')->unique()->values();
    }
}
```

### 3. Utilizzo in Filament (Select dinamici)

Esempio di implementazione di select dinamiche per regioni, province, città e cap:

```php
Select::make('region')
    ->options(fn () => \Modules\Geo\Models\Region::all()->mapWithKeys(fn($item) => [$item => $item]))
    ->live()
    ->afterStateUpdated(fn ($set) => $set('province', null));

Select::make('province')
    ->options(fn ($get) => \Modules\Geo\Models\Province::byRegion($get('region'))->mapWithKeys(fn($item) => [$item => $item]))
    ->live()
    ->afterStateUpdated(fn ($set) => $set('city', null))
    ->visible(fn ($get) => filled($get('region')));

Select::make('city')
    ->options(fn ($get) => \Modules\Geo\Models\City::byProvince($get('province'))->mapWithKeys(fn($item) => [$item => $item]))
    ->live()
    ->afterStateUpdated(fn ($set) => $set('cap', null))
    ->visible(fn ($get) => filled($get('province')));

Select::make('cap')
    ->options(fn ($get) => \Modules\Geo\Models\Cap::byCity($get('city'))->mapWithKeys(fn($item) => [$item => $item]))
    ->visible(fn ($get) => filled($get('city')));
```

### 4. Best practice e note operative

- Versionare sempre il file json.
- Documentare la struttura del json e mantenerla coerente.
- Se il json cresce molto, valutare slicing o indicizzazione.
- Per performance, sfruttare cache Laravel.
- Se serve compatibilità Eloquent, usare macro/traits per Collection.
- Collegare questa documentazione a Xot/docs/module-structure.md e a SaluteOra/docs/geo-integration.md.

### 5. Collegamenti utili

- [Squire PHP](https://github.com/squirephp/squire)
- Geo/module_geo.md
- Xot/module-structure.md
- SaluteOra/docs/geo-integration.md
