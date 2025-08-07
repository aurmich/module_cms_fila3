# Moderazione Utenti - Best Practices

> **Nota:** La moderazione utenti è ora gestita direttamente tramite il modello User. Per la motivazione architetturale e la soluzione attuale vedi [moderation-architettura.md](./moderation-architettura.md)

## Regola Fondamentale
Se una risorsa Filament estende `XotBaseResource`, NON deve mai dichiarare:
- `protected static ?string $navigationGroup`
- `protected static ?string $navigationLabel`
- `public static function table(Table $table): Table`

La configurazione di navigazione e la definizione della tabella sono centralizzate nella classe base o nei provider.

## Esempio CORRETTO
```php
class UserModerationResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    // Solo metodi e proprietà specifiche non già gestite dalla base
}
```

## Checklist Moderazione
- [ ] Tutti i campi di moderazione sono su User
- [ ] Logging e notifiche sono gestiti via trait e observer su User
- [ ] Nessuna duplicazione di logica tra User e UserModeration
- [ ] Documentazione aggiornata e coerente

## Errori Comuni
- Override accidentale di navigationGroup/navigationLabel
- Duplicazione del metodo table() tra risorse
- Incoerenza tra moduli per la navigazione Filament

## Link e Documentazione
- [moderation-architettura.md](./moderation-architettura.md)
- [README User](./Models/User.md)
- [README Patient](./README.md)
- [filament-xotbase-resource-best-practices.mdc](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc) 
