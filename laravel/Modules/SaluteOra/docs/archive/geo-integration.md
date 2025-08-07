# Integrazione con il modulo Geo

## Contesto
Il modulo SaluteOra utilizza le entità geografiche per:
- Localizzazione dei dentisti
- Ricerca per zona
- Filtri geografici

## Dipendenze
- Modulo Geo
  - Modelli: `Region`, `Province`, `City`, `Cap` (ora readonly, vedi sotto)
  - Dati geografici statici gestiti tramite file JSON (`resources/json/comuni.json`)

---

## Gestione entità geo: GeoJsonModel readonly (ispirato a Squire)

A partire dal 2025-05, tutte le entità geografiche (regioni, province, comuni, cap) sono gestite tramite modelli readonly che leggono direttamente da un file JSON, senza più tabelle/migration dedicate. Questo approccio:
- Riduce la complessità e la duplicazione dei dati
- Facilita la versione e l'aggiornamento dei dati geografici
- Garantisce performance ottimali grazie alla cache Laravel

Per dettagli, best practice ed esempi di utilizzo, vedi:
- [Geo/docs/geo-json-model.md](../../Geo/docs/geo-json-model.md)
- [Xot/docs/module-structure.md](../../Geo/docs/module_geo.md)

---

## Utilizzo
1. Importare i modelli dal modulo Geo:
```php
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;
```

2. Utilizzare i modelli nelle query:
```php
$regions = Region::all();
$provinces = Province::where('region_id', $regionId)->get();
$cities = City::where('province_id', $provinceId)->get();
$caps = Cap::where('city_id', $cityId)->get();
```

## Best Practices
- Non creare entità geografiche nel modulo SaluteOra
- Utilizzare sempre i modelli del modulo Geo
- Mantenere la coerenza dei dati
- Documentare l'utilizzo delle entità geografiche

## Collegamenti
- [README del modulo Geo](../../Geo/docs/README.md)
- [Filosofia del progetto](../../../docs/filosofia.md)
- [Clean Code](../../../docs/clean-code.md) 