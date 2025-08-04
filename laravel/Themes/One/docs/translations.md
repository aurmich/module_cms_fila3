# Traduzioni Tema One

## Panoramica
Il tema One supporta traduzioni multilingue complete in italiano (IT), inglese (EN) e tedesco (DE).

## Struttura Directory
```
laravel/Themes/One/lang/
├── it/
│   └── opening_hours.php
├── en/
│   └── opening_hours.php
└── de/
    └── opening_hours.php
```

## File di Traduzione

### Opening Hours
- **File**: `opening_hours.php`
- **Namespace**: `pub_theme::opening_hours`
- **Lingue**: IT, EN, DE
- **Struttura**: Headers per configurazione orari di apertura

#### Chiavi Disponibili
```php
pub_theme::opening_hours.headers.day
pub_theme::opening_hours.headers.morning
pub_theme::opening_hours.headers.afternoon
```

#### Struttura Completa
```php
<?php

declare(strict_types=1);

return [
    'headers' => [
        'day' => [
            'label' => 'Giorno', // IT: Giorno, EN: Day, DE: Tag
            'tooltip' => 'Seleziona il giorno della settimana',
            'helper_text' => 'Giorno della settimana per cui configurare gli orari',
        ],
        'morning' => [
            'label' => 'Mattina', // IT: Mattina, EN: Morning, DE: Vormittag
            'tooltip' => 'Configurazione orari mattutini',
            'helper_text' => 'Orari di apertura per la mattina',
        ],
        'afternoon' => [
            'label' => 'Pomeriggio', // IT: Pomeriggio, EN: Afternoon, DE: Nachmittag
            'tooltip' => 'Configurazione orari pomeridiani',
            'helper_text' => 'Orari di apertura per il pomeriggio',
        ],
    ],
];
```

## Regole Critiche

### Sincronizzazione Lingue
- **TUTTI** i file di traduzione devono avere la stessa struttura
- **SEMPRE** aggiungere nuove voci in tutte e tre le lingue
- **SEMPRE** mantenere la stessa gerarchia di chiavi

### Struttura Traduzioni
- Struttura espansa obbligatoria per tutti i campi
- Sintassi moderna `[]` invece di `array()`
- `declare(strict_types=1);` sempre presente
- `tooltip` e `helper_text` per ogni campo

### Convenzioni Naming
- File di traduzione in minuscolo
- Chiavi in snake_case
- Namespace `pub_theme::` per tutte le traduzioni del tema

## Utilizzo nei Template

### Blade Templates
```blade
{{ __('pub_theme::opening_hours.headers.day.label') }}
{{ __('pub_theme::opening_hours.headers.morning.tooltip') }}
{{ __('pub_theme::opening_hours.headers.afternoon.helper_text') }}
```

### Filament Components
```php
TextInput::make('day')
    ->label(__('pub_theme::opening_hours.headers.day.label'))
    ->helperText(__('pub_theme::opening_hours.headers.day.helper_text'));
```

## Testing

### Verifica Sintassi
```bash
php -l laravel/Themes/One/lang/it/opening_hours.php
php -l laravel/Themes/One/lang/en/opening_hours.php
php -l laravel/Themes/One/lang/de/opening_hours.php
```

### Verifica Struttura
```bash

# Controlla che tutti i file abbiano la stessa struttura
diff <(php -r "print_r(array_keys(include 'laravel/Themes/One/lang/it/opening_hours.php'));") \
     <(php -r "print_r(array_keys(include 'laravel/Themes/One/lang/en/opening_hours.php'));")
```

## Prevenzione Futura

### Script di Controllo
```bash
#!/bin/bash

# Controlla sincronizzazione traduzioni tema
for locale in it en de; do
    echo "Verificando $locale..."
    php -l "laravel/Themes/One/lang/$locale/opening_hours.php"
done
```

### Regole da Seguire
1. **SEMPRE** aggiungere traduzioni in tutte e tre le lingue
2. **SEMPRE** mantenere la stessa struttura gerarchica
3. **SEMPRE** usare sintassi moderna e tipizzazione stretta
4. **SEMPRE** includere tooltip e helper_text per ogni campo
5. **SEMPRE** testare la sintassi PHP dopo modifiche

## Collegamenti

- [Documentazione Root Traduzioni](../../../docs/translation_standards_links.md)
- [Regole Traduzioni Temi](theme_translation_rules.md)
- [Best Practices Filament](filament_best_practices.md)

## Note Importanti

- **REGOLA CRITICA**: Sincronizzazione obbligatoria tra lingue IT/EN/DE
- **REGOLA CRITICA**: Struttura espansa per tutti i campi
- **REGOLA CRITICA**: Sintassi moderna e tipizzazione stretta
- **REGOLA CRITICA**: Namespace `pub_theme::` per tutte le traduzioni

