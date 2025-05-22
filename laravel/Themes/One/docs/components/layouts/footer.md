# Footer Component

## Overview

Il componente Footer fa parte del tema One ed è posizionato in `/Themes/One/resources/views/components/layouts/footer.blade.php`.

## Struttura

```php
<footer {{ $attributes->class(['bg-white border-t border-gray-200']) }}>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between space-y-4 sm:flex-row sm:space-y-0">
            <div class="text-sm text-gray-500">
                © {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.
            </div>

            <nav class="flex space-x-4">
                <x-one::link href="{{ route('privacy') }}">
                    Privacy Policy
                </x-one::link>
                
                <x-one::link href="{{ route('terms') }}">
                    Termini e Condizioni
                </x-one::link>
                
                <x-one::link href="{{ route('cookies') }}">
                    Cookie Policy
                </x-one::link>
            </nav>
        </div>
    </div>
</footer>
```

## Utilizzo

```php
<x-one::layouts.footer />
```

Con classi personalizzate:
```php
<x-one::layouts.footer class="bg-gray-100" />
```

## Caratteristiche

- Responsive design con layout flessibile
- Supporto per personalizzazione tramite attributi
- Integrazione con il sistema di routing
- Utilizzo dei componenti base del tema One

## Personalizzazione

### Links
I link nel footer possono essere personalizzati modificando il componente o passando un array di links:

```php
@props([
    'links' => [
        ['title' => 'Privacy Policy', 'url' => route('privacy')],
        ['title' => 'Termini', 'url' => route('terms')],
        ['title' => 'Cookies', 'url' => route('cookies')],
    ]
])
```

### Stili
Il componente utilizza Tailwind CSS e può essere personalizzato tramite:
- Classi aggiuntive tramite l'attributo `class`
- Sovrascrittura delle classi predefinite
- Variabili CSS personalizzate

## Best Practices

1. **Mantenere la Coerenza**
   - Utilizzare i componenti base del tema One (`x-one::link`)
   - Seguire le convenzioni di naming del tema
   - Mantenere la struttura responsive

2. **Performance**
   - Minimizzare il numero di link
   - Utilizzare lazy loading per eventuali immagini
   - Ottimizzare le classi Tailwind

3. **Accessibilità**
   - Mantenere un contrasto adeguato
   - Utilizzare markup semantico
   - Fornire aria-labels dove necessario

## Testing

```php
it('renders footer component', function () {
    $this->blade('<x-one::layouts.footer />')
        ->assertSee(date('Y'))
        ->assertSee(config('app.name'));
});

it('accepts custom classes', function () {
    $this->blade('<x-one::layouts.footer class="custom-class" />')
        ->assertSee('custom-class');
});
```

## Collegamenti

- [Documentazione Tema One](../README.md)
- [Componenti Layout](./index.md)
- [Design System](../design_system.md)
- [Best Practices](../best_practices.md)

## Collegamenti tra versioni di footer.md
* [footer.md](docs/laravel-app/themes/one/components/footer.md)
* [footer.md](docs/sections/footer.md)
* [footer.md](laravel/Modules/UI/docs/components/footer.md)
* [footer.md](laravel/Modules/Cms/docs/blocks/footer.md)
* [footer.md](laravel/Modules/Cms/docs/themes/one/footer.md)
* [footer.md](laravel/Modules/Cms/docs/components/footer.md)
* [footer.md](laravel/Themes/One/docs/components/layouts/footer.md)
* [footer.md](laravel/Themes/One/docs/sections/footer.md)

