# risoluzione errore "cannot override final method infolist()"

## problema

Quando si tenta di eseguire operazioni che coinvolgono la classe `ViewAppointmentWorkflow`, si ottiene il seguente errore:

```
Cannot override final method Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord::infolist()

  at Modules/SaluteOra/app/Filament/Resources/AppointmentWorkflowResource/Pages/ViewAppointmentWorkflow.php:24
     20▕
     21▕     /**
     22▕      * Configura l'infolist per visualizzare i dettagli del workflow.
     23▕      */
  ➜  24▕     public function infolist(Infolist $infolist): void
     25▕     {
     26▕         $infolist
     27▕             ->schema([
     28▕                 Section::make('Informazioni Workflow')
```

## causa

Il problema è causato da un conflitto tra l'implementazione di metodi nella gerarchia di classi:

1. La classe base `XotBaseViewRecord` (in `Modules/Xot/app/Filament/Resources/Pages/XotBaseViewRecord.php`) dichiara il metodo `infolist()` come `final`:

```php
final public function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema($this->getInfolistSchema());
}

abstract protected function getInfolistSchema(): array;
```

2. La classe `ViewAppointmentWorkflow` tenta di sovrascrivere questo metodo finale:

```php
public function infolist(Infolist $infolist): void
{
    $infolist->schema([...]);
}
```

Secondo le regole di PHP, i metodi dichiarati come `final` non possono essere sovrascritti nelle classi figlie.

## soluzione

Per risolvere il problema, è necessario utilizzare il pattern previsto dalla classe base `XotBaseViewRecord`, implementando il metodo astratto `getInfolistSchema()` invece di sovrascrivere direttamente `infolist()`:

```php
// ERRATO - Non fare questo
public function infolist(Infolist $infolist): void
{
    $infolist->schema([...]);
}

// CORRETTO - Implementare getInfolistSchema() invece
protected function getInfolistSchema(): array
{
    return [
        Section::make('Informazioni Workflow')
            ->schema([
                TextEntry::make('patient.full_name')
                    ->label('Paziente'),
                
                TextEntry::make('status')
                    ->label('Stato')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                        // ...altri stati...
                    }),
                // ...altri campi...
            ]),
    ];
}
```

## implementazione

Ecco come modificare il file `ViewAppointmentWorkflow.php`:

1. Rimuovere il metodo `infolist()`
2. Aggiungere il metodo `getInfolistSchema()` che restituisce lo schema desiderato
3. Assicurarsi che il metodo restituisca un array associativo con chiavi di tipo stringa

## implicazioni per altri moduli

Questo pattern deve essere seguito in tutti i moduli che estendono `XotBaseViewRecord`:

1. Mai tentare di sovrascrivere metodi dichiarati come `final`
2. Implementare i metodi astratti richiesti dalla classe base
3. Seguire le convenzioni di tipo e formato di ritorno specificate nella documentazione della classe base

## link ad altre risorse

- [Documentazione XotBaseResource](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament_resources_implementation.md)
- [Linee guida per l'implementazione di Filament](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/filament-resources.md)
- [Convenzioni di codice Filament](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/filament_best_practices.md)
