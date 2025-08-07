# DayFrequencyEnum

## Descrizione
Enum che rappresenta la frequenza giornaliera di una determinata azione o evento (es. assunzione farmaci, igiene orale, ecc).

## Valori disponibili

| Valore           | Label IT                | Label EN         | Label DE           | Colore    | Icona                      |
|------------------|------------------------|------------------|--------------------|-----------|----------------------------|
| twice_daily      | Due volte al giorno     | Twice daily      | Zweimal täglich    | primary   | heroicon-o-arrow-path      |
| daily           | Ogni giorno             | Every day        | Jeden Tag          | success   | heroicon-o-calendar-days   |
| alternate_days   | A giorni alterni        | Alternate days   | Jeden zweiten Tag  | warning   | heroicon-o-arrow-right-left|
| occasionally     | Saltuariamente          | Occasionally     | Gelegentlich        | gray      | heroicon-o-clock           |

## Struttura file di traduzione

```php
return [
    'twice_daily' => [
        'label' => 'Due volte al giorno',
        'color' => 'primary',
        'icon' => 'heroicon-o-arrow-path',
    ],
    'daily' => [
        'label' => 'Ogni giorno',
        'color' => 'success',
        'icon' => 'heroicon-o-calendar-days',
    ],
    'alternate_days' => [
        'label' => 'A giorni alterni',
        'color' => 'warning',
        'icon' => 'heroicon-o-arrow-right-left',
    ],
    'occasionally' => [
        'label' => 'Saltuariamente',
        'color' => 'gray',
        'icon' => 'heroicon-o-clock',
    ],
];
```

## Best Practice
- Implementare sempre HasLabel, HasColor, HasIcon
- Usare il trait TransTrait per la localizzazione
- Aggiornare sempre le traduzioni in tutte le lingue
- Documentare ogni nuovo valore aggiunto

## Collegamenti
- [enum_best_practices.md](./enum_best_practices.md)
- [occurence_frequency_enum.php](../lang/it/occurence_frequency_enum.php) 