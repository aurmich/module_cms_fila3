# Volt + Folio: Rendere Disponibile la Variabile `$slug`

## Problema
In `Themes/One/resources/views/pages/pages/[slug].blade.php` Volt non inietta il parametro `slug`.

## Soluzione
Basta aggiungere al componente Volt anonimo:

```php
new class extends \Livewire\Volt\Component {
    public string $slug;
};
```

Ora in Blade si può usare direttamente:

```blade
<h1>Pagina: {{ $slug }}</h1>
```

Verifica che la route Folio sia definita come `/pages/{slug}` con `name('pages.slug')`.

*Documentato: 2025-06-06*
