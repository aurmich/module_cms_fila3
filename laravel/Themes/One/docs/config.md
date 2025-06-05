# Configurazione

## Introduzione

Questo documento descrive le opzioni di configurazione disponibili per il tema "One", inclusi i file di configurazione, le variabili d'ambiente e le impostazioni personalizzabili.

## File di Configurazione

### Configurazione Base
```php
// config/theme.php
return [
    'name' => 'One',
    'version' => '1.0.0',
    'author' => 'Your Name',
    'description' => 'Tema frontend moderno',
    
    // Impostazioni di default
    'defaults' => [
        'layout' => 'default',
        'style' => 'light',
        'direction' => 'ltr',
    ],
    
    // Supporto browser
    'browsers' => [
        'chrome' => '>= 60',
        'firefox' => '>= 60',
        'safari' => '>= 12',
        'edge' => '>= 16',
    ],
];
```

### Configurazione Assets
```php
// config/assets.php
return [
    // Percorsi
    'paths' => [
        'css' => 'assets/css',
        'js' => 'assets/js',
        'images' => 'assets/images',
        'fonts' => 'assets/fonts',
    ],
    
    // Build
    'build' => [
        'source' => 'resources',
        'destination' => 'public',
        'manifest' => 'mix-manifest.json',
    ],
    
    // CDN
    'cdn' => [
        'enabled' => false,
        'url' => 'https://cdn.example.com',
    ],
];
```

### Configurazione Componenti
```php
// config/components.php
return [
    // Componenti attivi
    'active' => [
        'button',
        'card',
        'form',
        'modal',
        'navigation',
    ],
    
    // Impostazioni componenti
    'settings' => [
        'button' => [
            'variants' => ['primary', 'secondary', 'outline'],
            'sizes' => ['sm', 'md', 'lg'],
        ],
        'card' => [
            'variants' => ['default', 'elevated', 'outlined'],
        ],
    ],
];
```

## Variabili d'Ambiente

### .env
```env
# Tema
THEME_NAME=One
THEME_VERSION=1.0.0
THEME_ENV=production

# Assets
ASSETS_VERSION=1.0.0
ASSETS_CDN_ENABLED=false
ASSETS_CDN_URL=https://cdn.example.com

# Performance
CACHE_ENABLED=true
CACHE_TTL=3600
MINIFY_ENABLED=true

# Analytics
ANALYTICS_ENABLED=true
ANALYTICS_ID=UA-XXXXXXXXX-X
```

### .env.example
```env
# Tema
THEME_NAME=One
THEME_VERSION=1.0.0
THEME_ENV=development

# Assets
ASSETS_VERSION=1.0.0
ASSETS_CDN_ENABLED=false
ASSETS_CDN_URL=

# Performance
CACHE_ENABLED=false
CACHE_TTL=3600
MINIFY_ENABLED=false

# Analytics
ANALYTICS_ENABLED=false
ANALYTICS_ID=
```

## Personalizzazione

### Tema
```php
// Personalizzazione tema
Theme::config([
    'name' => 'Custom Theme',
    'version' => '1.0.0',
    'defaults' => [
        'layout' => 'custom',
        'style' => 'dark',
    ],
]);
```

### Componenti
```php
// Personalizzazione componenti
Theme::component('button', [
    'variants' => ['primary', 'secondary', 'custom'],
    'sizes' => ['sm', 'md', 'lg', 'xl'],
]);
```

### Assets
```php
// Personalizzazione assets
Theme::asset('css/main.css', [
    'version' => '1.0.0',
    'attributes' => ['media' => 'screen'],
]);
```

## Best Practices

### Configurazione
- Utilizzare valori di default sensati
- Documentare tutte le opzioni
- Fornire esempi di utilizzo
- Gestire ambienti diversi
- Versionare configurazioni

### Sicurezza
- Non esporre dati sensibili
- Validare input
- Sanitizzare output
- Gestire permessi
- Implementare logging

### Performance
- Cache configurazioni
- Minimizzare file
- Ottimizzare caricamento
- Gestire dipendenze
- Monitorare risorse

## Metriche di Successo

### Qualità
- Documentazione completa
- Manutenibilità
- Flessibilità
- Sicurezza
- Performance

### Usabilità
- Facilità configurazione
- Intuitività
- Consistenza
- Scalabilità
- Supporto

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
