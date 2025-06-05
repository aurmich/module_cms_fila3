# Linee Guida per l'Utilizzo di XotBaseResource

## Regole Fondamentali

Quando una classe estende `XotBaseResource`, **NON** devono essere ridefinite le seguenti proprietà e metodi, poiché sono già gestiti dalla classe base:

1. **Proprietà da non ridefinire** (a meno che non sia necessario per traduzioni personalizzate):
   - `protected static ?string $navigationIcon`
   - `protected static ?string $navigationGroup`
   - `protected static ?string $translationPrefix` (ridefinire solo se necessario per traduzioni specifiche)

2. **Metodi da non ridefinire** (a meno che non sia strettamente necessario):
   - `public static function table(Table $table): Table`
   - `public static function getListTableColumns(): array`

## Motivazione

- **Centralizzazione**: `XotBaseResource` fornisce configurazioni predefinite per queste proprietà e metodi, garantendo coerenza in tutto il progetto.
- **Manutenzione**: Evitare duplicazioni riduce la complessità e facilita gli aggiornamenti.
- **Best Practices**: Seguire le convenzioni del progetto assicura uniformità e riduce il rischio di errori.

## Esempio di Implementazione Corretta

```php
class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;

    public static function getFormSchema(): array
    {
        return static::getFormSchemaWidget();
    }
    // Altri metodi personalizzati necessari
}
```

**Nota**: Se una personalizzazione è assolutamente necessaria, deve essere documentata dettagliatamente con una giustificazione valida.

**Collegamenti correlati**:
- [Documentazione principale](../../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione DoctorResource](./doctor-resource-update.md)
- [Documentazione Doctor Model](./doctor-model-update.md)
- [Documentazione Filament Extension Pattern](../Modules/Notify/docs/FILAMENT_EXTENSION_PATTERN.md)
