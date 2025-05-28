# Modulo Geo

## Descrizione
Il modulo Geo gestisce i dati geografici italiani (regioni, province, città e CAP) utilizzando un file JSON come fonte dati principale attraverso la classe `GeoJsonModel`. Questo approccio offre vantaggi significativi in termini di performance e manutenibilità rispetto all'utilizzo di un database tradizionale, come documentato nell'[analisi comparativa con Laravel Sushi](./geojsonmodel-vs-sushi.md).

## Architettura

### 1. Fonte Dati
- File JSON: `resources/json/comuni.json`
- Struttura gerarchica: Regioni > Province > Città > CAP
- Validazione automatica della struttura e integrità dei dati

### 2. Componenti Principali

#### Servizi
- `GeoDataService`: Gestisce l'accesso ai dati geografici
- `GeoDataValidator`: Valida la struttura e l'integrità dei dati

#### Form e Widget
- `LocationForm`: Form Filament per la selezione della località
- `LocationWidget`: Widget Filament che utilizza il form

### 3. Cache
- Cache a livello di servizio per ottimizzare le performance
- Chiavi di cache separate per regioni, province, città e CAP
- TTL di 24 ore per tutti i dati in cache

## Utilizzo

### 1. Selezione Località
```php
use Modules\Geo\App\Filament\Forms\LocationForm;

class MyForm extends XotBaseForm
{
    public function getSchema(): array
    {
        return [
            ...LocationForm::getSchema(),
            // Altri campi del form
        ];
    }
}
```

### 2. Widget
```php
use Modules\Geo\App\Filament\Widgets\LocationWidget;

class MyPage extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            LocationWidget::class,
        ];
    }
}
```

### 3. Eventi
Il widget emette l'evento `location-selected` quando viene selezionata una località:
```php
$this->dispatch('location-selected', [
    'region' => 'LO',
    'province' => 'MI',
    'city' => 'F205',
    'cap' => '20100'
]);
```

## Best Practices

### 1. Performance
- Utilizzare sempre il servizio `GeoDataService` per accedere ai dati
- Non accedere direttamente al file JSON
- Lasciare che il servizio gestisca la cache

### 2. Validazione
- Utilizzare `GeoDataValidator` per validare i dati
- Verificare l'integrità dei dati prima di utilizzarli
- Gestire gli errori di validazione

### 3. UI/UX
- Utilizzare sempre i componenti Filament forniti
- Non creare form personalizzati per la selezione della località
- Seguire le traduzioni fornite

## Manutenzione

### 1. Aggiornamento Dati
1. Modificare il file JSON
2. Eseguire la validazione
3. Pulire la cache

### 2. Cache
```php
$geoService = app(GeoDataService::class);
$geoService->clearCache();
```

### 3. Traduzioni
- Aggiungere nuove traduzioni in `lang/it/`
- Mantenere la struttura esistente
- Documentare le modifiche

## Collegamenti
- [Documentazione JSON Database](json-database.md)
- [Documentazione Squire](squire-integration.md)
- [Best Practices Filament](../../../docs/filament-best-practices.md)
- [Clean Code](../../../docs/clean-code.md)

# Gestione dati geografici statici in Geo

## Strategie implementative

### 1. GeoJsonModel (readonly da file JSON)
- Modello base che legge tutti i dati da un unico file JSON (`comuni.json`), esponendo metodi statici per regioni, province, città, cap, ecc.
- **Vantaggi:** semplicità, trasparenza, versionamento git, zero dipendenze, performance ottima fino a 10-20k record, auditabilità.
- **Svantaggi:** no join/relazioni, no query avanzate, non adatto a dataset >50k record, solo metodi Collection.
- **Percentuale preferenza:** 55-70% (caso d'uso statico tipico)
- **Approfondisci:** [geo-json-model.md](geo-json-model.md), [comune-unificazione-analisi.md](comune-unificazione-analisi.md)

### 2. Sushi (Eloquent Model virtuale)
- Usa il trait Sushi per caricare i dati da array/config/json/API in una tabella SQLite temporanea in memoria, con API Eloquent completa (join, relazioni, morph, query avanzate).
- **Vantaggi:** API Eloquent completa, compatibilità Filament, query avanzate, relazioni, morph, refactoring facile.
- **Svantaggi:** richiede SQLite attivo, overhead bootstrap, meno trasparente, id instabili se non definiti, non adatto a dataset >50k record, dipendenza esterna.
- **Percentuale preferenza:** 30-45% (se servono query Eloquent avanzate)
- **Approfondisci:** [comune-sushi-analisi.md](comune-sushi-analisi.md), [comune-sushi-implementazione.md](comune-sushi-implementazione.md), [geo-sushi-comparison.md](geo-sushi-comparison.md)

### 3. SushiToJsons (CRUD su file JSON per record)
- Trait che estende Sushi e popola i dati da una serie di file JSON (uno per record), simulando CRUD su file, con supporto multitenant e schema esplicito.
- **Vantaggi:** dati modificabili senza DB, API Eloquent completa, multitenancy, ogni record ispezionabile/versionabile come file.
- **Svantaggi:** più complesso, performance limitata su grandi dataset, fragile (coerenza file), richiede schema esplicito, non adatto a dati solo readonly.
- **Percentuale preferenza:** <5% (solo se serve CRUD su file e multitenancy)
- **Approfondisci:** [comune-sushi-implementazione.md](comune-sushi-implementazione.md) (sezione 8), [Tenant/app/Models/Traits/SushiToJsons.php]

---

## Raccomandazioni sintetiche
- **Per dati statici** (es. comuni italiani): preferire GeoJsonModel o Sushi puro.
- **Per dati modificabili senza DB** e multitenancy: valutare SushiToJsons.
- **Per query Eloquent avanzate** (join, morph, relazioni): valutare Sushi, ma solo se SQLite è garantito.
- **Documentare sempre la scelta e aggiornare i test.**

---

## Collegamenti principali
- [geo-json-model.md](geo-json-model.md)
- [comune-unificazione-analisi.md](comune-unificazione-analisi.md)
- [comune-sushi-analisi.md](comune-sushi-analisi.md)
- [comune-sushi-implementazione.md](comune-sushi-implementazione.md)
- [geo-sushi-comparison.md](geo-sushi-comparison.md)
- [module_geo.md](module_geo.md)
- [Tenant/app/Models/Traits/SushiToJsons.php]

---

**Ultimo aggiornamento:** {{date('Y-m-d')}}
Responsabile: Cascade AI 
