# Modulo Geo

## Descrizione
Il modulo Geo gestisce i dati geografici italiani (regioni, province, città e CAP) utilizzando un file JSON come fonte dati principale. Questo approccio offre vantaggi significativi in termini di performance e manutenibilità rispetto all'utilizzo di un database tradizionale.

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