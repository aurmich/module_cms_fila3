# Proprietà critiche nelle classi base Filament

## ⚠️ LIVEWIRE + FILAMENT: PROPRIETÀ CRITICHE

### Proprietà `$data` in XotBaseWidget

La proprietà `public ?array $data = []` in `XotBaseWidget` è **ASSOLUTAMENTE CRITICA** e:

- ✅ DEVE essere mantenuta in `XotBaseWidget`
- ❌ NON DEVE MAI essere rimossa o modificata
- ❌ NON DEVE MAI essere ridichiarata nelle classi derivate

**Motivazione**: Questa proprietà è fondamentale per il funzionamento di Livewire con i form Filament. TUTTI i binding `wire:model="data.*"` dipendono da questa proprietà. La sua rimozione causa il fallimento completo di tutti i widget che utilizzano form.

**Impatto**: Se questa proprietà viene rimossa, si verificano errori del tipo:
```
Livewire: [wire:model="data.first_name"] property does not exist on component
```

### Altre proprietà critiche

- `protected static string $view` - Definisce il template Blade da renderizzare
- `public array $listener = []` - Gestisce gli eventi Livewire

## Procedure di verifica

Prima di ogni modifica a `XotBaseWidget`, eseguire questi controlli:

```bash
# Verifica presenza della proprietà $data
grep -n "public ?array \$data" /var/www/html/base_saluteora/laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php

# Verifica che non ci siano duplicazioni nelle classi derivate
grep -r "public ?array \$data" /var/www/html/base_saluteora/laravel/Modules/*/app/Filament/Widgets/ | grep -v XotBaseWidget
```

## Documentazione di riferimento

- [Proprietà critiche in XotBaseWidget](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/critical-properties/data-property.md)
- [Livewire Data Binding](https://livewire.laravel.com/docs/properties)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
