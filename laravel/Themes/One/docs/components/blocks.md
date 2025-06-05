# Blocchi del Tema

## Struttura Base dei Blocchi

Ogni blocco deve seguire questa struttura base:

```blade
@props(['data'])

@php
// 1. Estrazione e validazione dei dati
$items = $data['items'] ?? [];
$locale = app()->getLocale();

// 2. Definizione delle classi CSS
$classes = [
    'variant1' => 'classe1',
    'variant2' => 'classe2'
];

// 3. Preparazione delle classi container
$containerClasses = 'base-classes ' . ($classes[$variant] ?? $classes['default']);
@endphp

<div class="{{ $containerClasses }}">
    // Contenuto del blocco
</div>
```

## Best Practices

### 1. Gestione dei Dati

```php
// Corretta gestione dei dati multilingua
$label = is_array($item['label']) ? ($item['label'][$locale] ?? '') : ($item['label'] ?? '');

// Gestione sicura degli array
$items = $data['items'] ?? [];
$hasChildren = isset($item['children']) && is_array($item['children']) && count($item['children']) > 0;

// Validazione dei tipi
$type = is_string($item['type'] ?? '') ? $item['type'] : 'default';
```

### 2. Classi CSS

```php
// Definizione delle varianti
$buttonClasses = [
    'primary' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700',
    'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50',
    'outline' => 'border-primary-600 text-primary-600 bg-transparent hover:bg-primary-50'
];

// Utilizzo di @class per classi condizionali
@class([
    'base-classes',
    'conditional-class' => $condition,
    $dynamicClasses[$variant] ?? $dynamicClasses['default']
])
```

### 3. Componenti Dinamici

```blade
// Gestione sicura delle icone
@if($icon && View::exists($icon))
    <x-dynamic-component :component="$icon" class="w-5 h-5" />
@endif

// Gestione sicura dei componenti
@if(View::exists($blockComponent))
    <x-dynamic-component :component="$blockComponent" :data="$blockData" />
@endif
```

## Tipi di Blocchi

### 1. Navigation Block
- Supporto multilingua per label e URL
- Gestione dropdown e sottomenu
- Stili per link e pulsanti
- Responsive e mobile-friendly

### 2. Actions Block
- Allineamento configurabile
- Spaziatura personalizzabile
- Supporto per icone
- Multiple varianti di stile

## Sicurezza e Validazione

1. **Validazione Input**
```php
// Sempre validare e sanitizzare i dati in ingresso
$value = is_string($input) ? strip_tags($input) : '';
```

2. **Escape Output**
```blade
{{-- Utilizzare sempre la sintassi {{ }} per l'escape automatico --}}
{{ $label }}
```

3. **Controlli di Sicurezza**
```php
// Verificare l'esistenza di componenti prima di renderizzarli
if (View::exists($component)) {
    // Render component
}
```

## Internazionalizzazione

1. **Struttura Traduzioni**
```php
'label' => [
    'it' => 'Etichetta',
    'en' => 'Label'
]
```

2. **Fallback**
```php
$label = $translations[$locale] ?? $translations['en'] ?? '';
```

## Performance

1. **Lazy Loading**
- Utilizzare lazy loading per immagini e componenti pesanti
- Caricare risorse JS/CSS solo quando necessario

2. **Caching**
- Implementare cache per blocchi statici
- Utilizzare cache per query frequenti

## Debug e Manutenzione

1. **Logging**
```php
// Aggiungere log per debugging
Log::debug('Block data:', ['type' => $type, 'data' => $data]);
```

2. **Commenti**
```php
// Documentare comportamenti complessi
// Esempio: questo blocco gestisce layout nested con profondità n
```

## Testing

1. **Unit Test**
- Testare la logica di rendering
- Verificare la gestione dei dati mancanti
- Testare le traduzioni

2. **Integration Test**
- Testare l'interazione tra blocchi
- Verificare il responsive design
- Testare la compatibilità browser 

## Collegamenti tra versioni di blocks.md
* [blocks.md](laravel/Modules/Xot/docs/blocks.md)
* [blocks.md](laravel/Modules/User/resources/views/docs/blocks.md)
* [blocks.md](laravel/Modules/UI/docs/blocks.md)
* [blocks.md](laravel/Modules/Cms/docs/blocks.md)
* [blocks.md](laravel/Themes/One/docs/blocks.md)
* [blocks.md](laravel/Themes/One/docs/components/blocks.md)

