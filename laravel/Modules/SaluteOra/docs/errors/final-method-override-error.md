# Errore: Impossibile sovrascrivere metodi final

## Problema

Quando si estendono classi base da altri moduli, specialmente quelle del modulo Xot, si possono verificare errori come:

```
Cannot override final method Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord::infolist()
```

Questo errore si verifica quando si tenta di sovrascrivere un metodo dichiarato come `final` nella classe genitore. I metodi `final` sono stati progettati esplicitamente per non essere sovrascritti nelle classi derivate.

## Analisi del problema

Nel caso specifico di `XotBaseViewRecord`, il metodo `infolist()` è dichiarato come:

```php
final public function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema($this->getInfolistSchema());
}
```

Invece di permettere la sovrascrittura diretta di questo metodo, la classe base richiede l'implementazione del metodo astratto `getInfolistSchema()`:

```php
abstract protected function getInfolistSchema(): array;
```

Questa architettura segue il **pattern Template Method**, dove la classe base definisce lo "scheletro" di un algoritmo, delegando alcuni passaggi specifici alle sottoclassi.

## Soluzione

Anziché tentare di sovrascrivere il metodo `infolist()`, implementare il metodo `getInfolistSchema()` richiesto:

```php
protected function getInfolistSchema(): array
{
    return [
        // Qui lo schema dell'infolist
        Section::make('Informazioni Workflow')
            ->schema([
                TextEntry::make('patient.full_name')
                    ->label('Paziente'),
                // altri campi...
            ]),
    ];
}
```

## Pattern di progettazione

Questa architettura offre diversi vantaggi:

1. **Coerenza**: Garantisce che tutte le infolist seguano la stessa struttura di base
2. **Estensibilità**: Permette personalizzazioni senza compromettere il funzionamento di base
3. **Protezione**: Impedisce modifiche non intenzionali al flusso principale

## Raccomandazioni generali

Quando si estendono classi base:

1. **Verificare la classe genitore**: Comprendere quali metodi sono finali e quali sono previsti per l'estensione
2. **Cercare metodi astratti**: La presenza di metodi astratti spesso indica i punti di estensione previsti
3. **Rispettare il pattern**: Utilizzare l'architettura prevista dalla classe base anziché tentare di aggirarla

## Collegamenti correlati

- [Documentazione XotBaseViewRecord](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/xotbaseviewrecord.md)
- [Pattern Template Method](https://refactoring.guru/design-patterns/template-method)
- [Best practices per l'estensione delle classi in Filament](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/filament/filament_best_practices.md)
