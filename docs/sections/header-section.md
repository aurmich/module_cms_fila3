# Header Section

## Struttura

### 1. Blade Template
```blade
{{-- Themes/One/resources/views/components/sections/header.blade.php --}}
<header {{ $attributes->merge([
    'class' => ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id'    => ($section['attributes']['id'] ?? ''),
    'style' => 'background-color:'.($section['attributes']['style']['background-color'] ?? '').'; color:'.($section['attributes']['style']['color'] ?? '').';'
]) }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        @foreach($blocks as $block)
            <div class="mx-2">
                <x-dynamic-component
                    :component="'cms::blocks.' . $block['type']"
                    :data="$block['data']"
                />
            </div>
        @endforeach
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen"
         class="md:hidden"
         x-transition:enter="duration-150 ease-out"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="duration-100 ease-in"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            @foreach($blocks as $block)
                <x-dynamic-component :component="'cms::blocks.' . $block['type']" :data="$block['data']" />
            @endforeach
        </div>
    </div>
</header>
```

### 2. JSON Configuration
```json
{
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "slug": "header",
    "blocks": [
        {
            "type": "logo",
            "data": {
                "src": "/images/logo.svg",
                "alt": "Logo",
                "width": 150,
                "height": 32
            }
        },
        {
            "type": "navigation",
            "data": {
                "items": [
                    { "label": { "it": "Home", "en": "Home" }, "url": "/" }
                ]
            }
        },
        {
            "type": "actions",
            "data": {
                "items": [
                    { "label": { "it": "Area Pazienti", "en": "Patient Area" }, "url": "/area-pazienti", "variant": "primary" },
                    { "label": { "it": "Prenota", "en": "Book" }, "url": "/prenota", "variant": "secondary" }
                ]
            }
        }
        // Altri blocchi
    ]
}
```

## Gestione Blocchi
Il header è una sezione **generica** che consente di inserire e ordinare **qualsiasi** blocco disponibile nel sistema tramite `PageContentBuilder`.

Per dettagli su configurazione e template, consulta: [Documentazione Sezione Header](../sections/header-section.md)

## Collegamenti
- [Gestione Blocchi](../blocks/README.md)
- [Componenti UI](../components/README.md)
