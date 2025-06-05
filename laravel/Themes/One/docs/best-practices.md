# Best Practices per lo Sviluppo del Tema

## 1. Gestione dei Dati

### Validazione Input
```php
// Validare sempre i tipi di dati
$value = is_string($input) ? $input : '';
$items = is_array($data) ? $data : [];

// Utilizzare operatore null coalescing con valori predefiniti
$type = $item['type'] ?? 'default';
$style = $item['style'] ?? 'primary';
```

### Gestione Array
```php
// Controllo sicuro per array nidificati
$hasChildren = isset($item['children']) && 
              is_array($item['children']) && 
              count($item['children']) > 0;

// Accesso sicuro a proprietà nidificate
$nestedValue = $data['parent']['child']['value'] ?? 
               $data['parent']['child'] ?? 
               $data['parent'] ?? 
               null;
```

## 2. Componenti Blade

### Struttura Component
```blade
@props(['data'])

@php
    // 1. Validazione input
    $items = $data['items'] ?? [];
    
    // 2. Preparazione dati
    $processedItems = collect($items)->map(...);
    
    // 3. Definizione classi
    $classes = [
        'base' => 'sempre-presente',
        'conditional' => $condition ? 'attiva' : ''
    ];
@endphp

<div class="{{ $classes['base'] }}">
    {{-- Contenuto --}}
</div>
```

### Gestione Traduzioni
```php
// Supporto multilingua per stringhe
$label = is_array($item['label']) 
    ? ($item['label'][$locale] ?? '') 
    : ($item['label'] ?? '');

// Supporto multilingua per URL
$url = is_array($item['url'])
    ? ($item['url'][$locale] ?? '#')
    : ($item['url'] ?? '#');
```

## 3. CSS e Stili

### Organizzazione Classi
```php
// Definire array di classi per varianti
$buttonClasses = [
    'primary' => 'bg-primary-600 text-white',
    'secondary' => 'bg-gray-200 text-gray-800'
];

// Utilizzare @class per classi condizionali
@class([
    'base-class',
    'conditional' => $condition,
    $variantClasses[$style] ?? $variantClasses['default']
])
```

### Responsive Design
```blade
<div class="
    base-mobile-first
    sm:tablet-style
    md:desktop-style
    lg:large-screen
    xl:extra-large
">
```

## 4. Sicurezza

### XSS Prevention
```blade
{{-- Sempre usare {{ }} per escape automatico --}}
{{ $userInput }}

{{-- Mai usare {!! !!} senza sanitizzazione --}}
{!! clean($htmlContent) !!}
```

### Validazione Componenti
```php
// Verificare esistenza componenti
if (View::exists($component)) {
    // Render safe
}

// Verificare permessi
if (auth()->user()->can('view', $component)) {
    // Render authorized
}
```

## 5. Performance

### Lazy Loading
```blade
{{-- Immagini --}}
<img loading="lazy" src="{{ $src }}" alt="{{ $alt }}">

{{-- Componenti --}}
@if($shouldLoad)
    <x-heavy-component />
@endif
```

### Caching
```php
// Cache per dati frequenti
$data = Cache::remember('key', $ttl, function () {
    return expensive_operation();
});

// Cache per view
@cache(['key' => $cacheKey])
    {{-- Contenuto cacheable --}}
@endcache
```

## 6. Manutenibilità

### Documentazione
```php
/**
 * @param array $data I dati del blocco
 * @param string $locale La lingua corrente
 * @return array Dati processati
 */
function processBlockData(array $data, string $locale): array
```

### Logging
```php
// Log per debugging
Log::debug('Processing block:', ['type' => $type, 'data' => $data]);

// Log per errori
Log::error('Block error:', ['error' => $e->getMessage()]);
```

## 7. Testing

### Unit Testing
```php
// Test componenti
public function test_block_renders_correctly()
{
    $data = ['type' => 'button', 'label' => 'Test'];
    $view = $this->blade('<x-block :data="$data"/>');
    $view->assertSee('Test');
}
```

### Integration Testing
```php
// Test interazioni
public function test_navigation_dropdown_works()
{
    $this->browse(function ($browser) {
        $browser->visit('/')
                ->click('@dropdown-trigger')
                ->assertVisible('@dropdown-content');
    });
}
``` 

## Collegamenti tra versioni di best-practices.md
* [best-practices.md](docs/tecnico/filament/best-practices.md)
* [best-practices.md](laravel/Modules/Xot/docs/laraxot/best-practices.md)
* [best-practices.md](laravel/Modules/UI/docs/best-practices.md)
* [best-practices.md](laravel/Themes/One/docs/best-practices.md)

