# Footer Section

La sezione **Footer** del tema fornisce navigazione secondaria, informazioni di contatto e blocchi personalizzabili.

## Struttura JSON
```json
{
  "name": {"it": "Footer Principale", "en": "Main Footer"},
  "slug": "footer",
  "blocks": [
    {"type": "info",       "data": { /* dati blocco Info */ }},
    {"type": "links",      "data": { /* dati blocco Links */ }},
    {"type": "newsletter", "data": { /* dati blocco Newsletter */ }},
    {"type": "bottom",     "data": { /* dati blocco Bottom */ }}
  ]
}
```

## Blade Template
```blade
@props([
    'section' => null,
    'blocks'  => [],
    'class'   => '',
])

@php
    $locale = app()->getLocale();
    $componentsBlocks = is_array($blocks) && isset($blocks[$locale]) ? $blocks[$locale] : $blocks;
@endphp

<footer {{ $attributes->merge(['class' => 'bg-gray-900 text-white mt-auto ' . $class]) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        @foreach($componentsBlocks as $block)
            <x-dynamic-component
                :component="'cms::blocks.' . $block['type']"
                :data="$block['data']"
            />
        @endforeach
    </div>
</footer>
```

## Collegamenti
- [Documentazione Sezione Footer (module)](../laravel/Modules/Cms/docs/sections/footer-section.md)
- [Collegamenti Generali](../collegamenti-documentazione.md)

## Collegamenti tra versioni di footer.md
* [footer.md](docs/laravel-app/themes/one/components/footer.md)
* [footer.md](docs/sections/footer.md)
* [footer.md](laravel/Modules/UI/docs/components/footer.md)
* [footer.md](laravel/Modules/Cms/docs/blocks/footer.md)
* [footer.md](laravel/Modules/Cms/docs/themes/one/footer.md)
* [footer.md](laravel/Modules/Cms/docs/components/footer.md)
* [footer.md](laravel/Themes/One/docs/components/layouts/footer.md)
* [footer.md](laravel/Themes/One/docs/sections/footer.md)

