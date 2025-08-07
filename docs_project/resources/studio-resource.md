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
- `getTableColumns()`: Colonne da visualizzare nella lista degli studi (ora implementato in `ListStudios` come richiesto da XotBaseListRecords, array associativo con chiavi stringa, colonne ricavate dal modello e dalla migrazione)
- `getListTableFilters()`: Filtri disponibili per la lista degli studi
- `getListTableActions()`: Azioni disponibili nella lista degli studi

### Pagine

La risorsa Studio implementa le seguenti pagine standard:

- `ListStudios`: Visualizzazione e gestione dell'elenco degli studi. Implementa il metodo `getTableColumns()` secondo la policy aggiornata (vedi anche [Xot/docs/filament/listrecords.md](../../../Xot/docs/filament/listrecords.md)).
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

- **Doctors**: Relazione molti-a-molti con i dottori che lavorano nello studio (belongsToManyX)
- **Appointments**: Relazione one-to-many con gli appuntamenti che si svolgono presso lo studio
- **Addresses**: Relazione polimorfica con gli indirizzi associati allo studio

## RelationManager: Associazione Dottori-Studi

Per visualizzare e gestire i dottori che lavorano in uno studio e gli studi in cui lavora un dottore, sono implementati i RelationManager Filament:

- **StudioResource/RelationManagers/DoctorsRelationManager.php**: mostra i dottori associati a uno studio (relazione molti-a-molti tramite belongsToManyX).
- **DoctorResource/RelationManagers/StudiosRelationManager.php**: mostra gli studi associati a un dottore (relazione molti-a-molti tramite belongsToManyX).

### Filosofia, logica e motivazione
- La relazione molti-a-molti riflette la realtà sanitaria: un dottore può lavorare in più studi e uno studio può avere più dottori.
- Si usa belongsToManyX per massima flessibilità, DRY, e per supportare pivot custom e policy multi-tenant.
- La simmetria della relazione permette una gestione coerente, audit trail e policy di sicurezza centralizzate.
- La documentazione e la struttura del codice sono pensate per essere zen, chiare e facilmente estendibili.

### Best Practice
- Seguire la struttura: ogni RelationManager in una sottocartella RelationManagers della rispettiva risorsa.
- Usare sempre XotBaseRelationManager come classe base.
- Le colonne della tabella devono essere coerenti con il modello e la migrazione.
- Nessun uso di ->label(), solo traduzioni da file lang.
- Documentare sempre la relazione e aggiornare la documentazione correlata.
- Vedi anche: [Xot/docs/filament/listrecords.md](../../../Xot/docs/filament/listrecords.md)

### Collegamenti
- [Modello Studio](../../app/Models/Studio.php)
- [Modello Doctor](../../app/Models/Doctor.php)
- [Best Practices Filament](../filament-best-practices.mdc)
- [README SaluteOra](../README.md)
- [README Xot Filament](../../../Xot/docs/filament/README.md)

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
- Usare closure senza dichiarazione `: void`
