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

## Confronto: GeoJsonModel vs Laravel Sushi

### 1. GeoJsonModel (JSON statico + Collection)
- **Vantaggi**:
  - 100% nessuna dipendenza esterna (solo Laravel base)
  - 100% leggibile/versionabile (il file json è ispezionabile, diffabile, editabile)
  - 95% performance ottima per dataset < 50.000 record (cache Laravel, nessun DB query)
  - 100% compatibile con deploy su qualsiasi ambiente (nessun requisito SQLite)
  - 100% DRY: una sola fonte di verità, nessuna duplicazione
  - 100% KISS: nessuna migrazione, nessun seeder, nessun DB
  - 90% facilità di aggiornamento (basta sostituire il file json)
- **Svantaggi**:
  - 60% non hai Eloquent completo (no relazioni, no query avanzate, no mutator/accessor)
  - 80% non hai route model binding automatico
  - 70% non hai validazione schema automatica (ma puoi aggiungerla)
  - 60% non adatto a dataset > 100.000 record (ram/caching)
  - 0% scrittura: solo readonly

### 2. Laravel Sushi
- **Vantaggi**:
  - 100% Eloquent API: puoi usare relazioni, query builder, accessors, mutators, route model binding
  - 90% performance ottima per dataset < 20.000 record (cache su SQLite in RAM)
  - 100% nessuna migrazione, nessun DB server richiesto (usa SQLite embedded)
  - 100% DRY: puoi caricare dati da array, config, API, CSV, JSON
  - 90% facilità di test (puoi mockare facilmente i dati)
  - 100% compatibile con tutte le feature Eloquent (tranne scrittura)
- **Svantaggi**:
  - 80% dipendenza da package esterno (Sushi)
  - 70% richiede estensione PHP SQLite abilitata (non sempre disponibile su hosting condivisi)
  - 60% gestione cache: se cambi i dati, devi gestire cache busting
  - 60% meno trasparente per chi non conosce Sushi
  - 0% scrittura: solo readonly

### 3. Percentuali di utilizzo e scenari
- **GeoJsonModel**: consigliato per dati geografici statici, reference, lookup, configurazioni, dove serve massima trasparenza e semplicità (80% dei casi in progetti multi-tenant, multi-modulo, open-source)
- **Sushi**: consigliato per dati statici che devono essere "Eloquent-like" (relazioni, query avanzate, route model binding), demo, test, prototipi, o quando vuoi sfruttare l'ecosistema Eloquent senza DB (20% dei casi, soprattutto in progetti Laravel puri, SaaS, package)

### 4. Considerazioni finali
- **GeoJsonModel** è più trasparente, più semplice, più portabile, più adatto a progetti open-source, multi-modulo, e a team che vogliono massima leggibilità e versionamento dei dati.
- **Sushi** è più potente se vuoi la sintassi Eloquent completa, relazioni, e route model binding, ma richiede SQLite e una dipendenza esterna.
- **Entrambi** sono readonly e ideali per dati statici. Se serve scrittura, serve un DB vero.
- **Performance**: per < 10.000 record sono equivalenti; tra 10.000 e 50.000 record GeoJsonModel vince per semplicità, sopra i 50.000 serve valutare DB o slicing.

## Esempio di scelta
- **Progetto multi-modulo, open-source, con dati geografici statici**: **GeoJsonModel** (90% dei casi)
- **Prototipo, SaaS, demo, o vuoi Eloquent completo senza DB**: **Sushi** (10% dei casi)

## Collegamenti
- [Laravel Sushi](https://github.com/calebporzio/sushi)
- [Squire PHP](https://github.com/squirephp/squire)
- [GeoJsonModel: struttura e motivazione](./geo-json-model.md)
- [json-database.md](./json-database.md)
- [squire-integration.md](./squire-integration.md)

## Esempio pratico: modello unico Comune

```php
namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

class Comune extends GeoJsonModel
{
    public static function byRegion(string $regionCode): Collection { /* ... */ }
    public static function byProvince(string $provinceCode): Collection { /* ... */ }
    public static function byCity(string $cityName): Collection { /* ... */ }
    public static function byCap(string $cap): Collection { /* ... */ }
    public static function byIstat(string $istat): Collection { /* ... */ }
    public static function allRegions(): Collection { /* ... */ }
    public static function allProvinces(): Collection { /* ... */ }
    public static function allCities(): Collection { /* ... */ }
    public static function allCaps(): Collection { /* ... */ }
}
```

- Tutti i filtri e le select dinamiche ora usano solo il modello Comune.
- Vedi anche [geo_entities.md](./geo_entities.md) per motivazione e percentuali di adozione.
