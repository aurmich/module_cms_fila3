# Studio Resource

## Overview

La risorsa Studio gestisce gli studi medici/dentistici all'interno del sistema SaluteOra. Questa risorsa implementa le funzionalità CRUD per il modello `Studio` che rappresenta un centro medico che può ospitare più dottori e gestire appuntamenti con i pazienti.

## Architettura

La risorsa Studio segue l'architettura standard di Filament con l'estensione di `XotBaseResource` anziché le classi Filament native. Questo approccio garantisce coerenza con il resto del sistema e permette l'utilizzo delle funzionalità personalizzate implementate nel modulo Xot.

```
Modules/SaluteOra/app/Filament/
├── Resources/
│   ├── StudioResource.php
│   └── StudioResource/
│       ├── Pages/
│       │   ├── CreateStudio.php
│       │   ├── EditStudio.php
│       │   └── ListStudios.php
│       └── Widgets/
│           └── StudioOverview.php
```

## Implementazione

### StudioResource

La classe principale `StudioResource` estende `XotBaseResource` e implementa i seguenti metodi principali:

- `getFormSchema()`: Schema del form per la creazione e modifica degli studi
- `getListTableColumns()`: Colonne da visualizzare nella lista degli studi
- `getListTableFilters()`: Filtri disponibili per la lista degli studi
- `getListTableActions()`: Azioni disponibili nella lista degli studi

### Pagine

La risorsa Studio implementa le seguenti pagine standard:

- `ListStudios`: Visualizzazione e gestione dell'elenco degli studi
- `CreateStudio`: Creazione di un nuovo studio
- `EditStudio`: Modifica di uno studio esistente

### Traduzioni

Le traduzioni per questa risorsa sono gestite attraverso il file di traduzione:

```
Modules/SaluteOra/lang/it/studio-resource.php
```

Seguendo la convenzione di traduzione del progetto:

```php
return [
    'title' => [
        'singular' => 'Studio Medico',
        'plural' => 'Studi Medici',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome dello studio',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo',
        ],
        // Altri campi...
    ],
    'filters' => [
        'active' => [
            'label' => 'Attivo',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
            ],
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Filtra per città',
        ],
    ],
    'actions' => [
        'activate' => 'Attiva',
        'deactivate' => 'Disattiva',
        'view_doctors' => 'Visualizza Dottori',
        'view_appointments' => 'Visualizza Appuntamenti',
    ],
];
```

## Funzionalità

La risorsa Studio implementa le seguenti funzionalità:

1. **Gestione Anagrafica**: Creazione e modifica delle informazioni di base dello studio
2. **Gestione Servizi**: Aggiunta e rimozione dei servizi offerti dallo studio
3. **Gestione Orari**: Configurazione degli orari di apertura dello studio
4. **Associazione Dottori**: Collegamento con i dottori che operano nello studio
5. **Gestione Appuntamenti**: Visualizzazione e gestione degli appuntamenti presso lo studio

## Relazioni

La risorsa Studio mantiene relazioni con altre entità del sistema:

- **Doctors**: Relazione one-to-many con i dottori che operano nello studio
- **Appointments**: Relazione one-to-many con gli appuntamenti che si svolgono presso lo studio
- **Addresses**: Relazione polimorfica con gli indirizzi associati allo studio

## Best Practices

Nell'implementazione di questa risorsa sono state seguite queste best practices:

1. **Non estendere direttamente classi Filament**: La risorsa estende `XotBaseResource`
2. **No label() diretto**: Le etichette sono gestite tramite file di traduzione
3. **Array associativi**: I metodi `getFormSchema()` e `getListTableColumns()` restituiscono array associativi
4. **Type hints**: Sono utilizzati type hints appropriati per tutti i metodi
5. **Strict types**: Il file utilizza `declare(strict_types=1)`
6. **Namespace corretto**: La risorsa è nel namespace `Modules\SaluteOra\Filament\Resources`

## Gestione closure void e return nelle azioni Filament

### Errore tipico
Se una closure dichiarata come `fn (Studio $record): void => ...` restituisce un valore (anche implicito), PHP genererà l'errore:

> A void function must not return a value

### Causa
- In Filament, le azioni custom spesso usano closure per eseguire operazioni su record.
- Se la closure è tipizzata come `void`, non deve restituire nulla (neanche implicitamente).
- Scrivere `->action(fn (Studio $record): void => $record->activate())` è errato se `activate()` restituisce qualcosa.

### Soluzione
- Usare closure senza dichiarazione `: void` **oppure** assicurarsi che la funzione chiamata non restituisca nulla.
- Esempio corretto:
  ```php
  ->action(fn (Studio $record) => $record->activate())
  ```
- Oppure, se serve la dichiarazione `: void`, assicurarsi che la funzione chiamata sia anch'essa void.

### Filosofia e best practice
- Seguire sempre la coerenza tra dichiarazione e comportamento delle closure.
- Aggiornare la doc ogni volta che si introduce una nuova action custom.
- Vedi anche: [filament-best-practices.mdc](../../filament-best-practices.mdc)

### Collegamenti
- [Filament Best Practices](../../filament-best-practices.md)
- [XotBaseResource Guidelines](../../../Xot/docs/filament/README.md)

## Regola: Firma corretta di getInfolistSchema nelle pagine View

- Tutte le classi che estendono `XotBaseViewRecord` DEVONO implementare il metodo:

```php
protected function getInfolistSchema(): array
```

- **Mai** dichiarare il metodo come `public static`.
- La firma deve essere identica a quella astratta nella classe base.
- La logica può essere centralizzata nella risorsa (es. `StudioResource::getInfolistSchema()`), ma la firma deve essere rispettata.

### Motivazione, filosofia, zen
- Coerenza con la base Xot: tutte le pagine View sono polimorfe e lavorano su istanza, non su classe.
- Evita errori di compatibilità e override accidentali.
- Permette l'override futuro senza breaking change.
- Segue la regola DRY: la logica può essere centralizzata, la firma deve essere coerente.

### Collegamenti
- [README Filament Xot](../../../Xot/docs/filament/README.md)
- [filament-best-practices.mdc](../../filament-best-practices.mdc)

## Checklist finale (aggiornata)
- [ ] Tutte le pagine View implementano `protected function getInfolistSchema(): array`
- [ ] Nessuna pagina View dichiara il metodo come static o public
- [ ] La logica è centralizzata nella risorsa, la firma è sempre coerente

## Gestione indirizzi (addresses)

La gestione degli indirizzi in StudioResource avviene tramite un repeater che riutilizza lo schema del form di AddressResource:

```php
'addresses' => Forms\Components\Repeater::make('addresses')
    ->relationship('addresses')
    ->schema(Modules\Geo\Filament\Resources\AddressResource::getFormSchema())
```

### Motivazione
- DRY: nessuna duplicazione di logica
- Coerenza UI tra tutti i moduli
- Manutenzione centralizzata

## Collegamenti
- [../../Geo/docs/filament.md](../../Geo/docs/filament.md)
- [../../Geo/docs/models/address.md](../../Geo/docs/models/address.md)
- [../../Geo/docs/has-address-trait.md](../../Geo/docs/has-address-trait.md)
