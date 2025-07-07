# Proprietà critiche nelle classi base Filament

## Proprietà `$data` in XotBaseWidget

La proprietà `public ?array $data = []` in `XotBaseWidget` è **CRITICA** e NON DEVE MAI essere rimossa perché:

1. È essenziale per il funzionamento di Livewire con i form Filament
2. Tutti i binding `wire:model="data.*"` dipendono da questa proprietà
3. La sua rimozione causa il fallimento completo dei widget con form

### Regola stretta
- ✅ Mantenere SEMPRE questa proprietà in `XotBaseWidget`
- ❌ NON rimuovere o modificare mai questa proprietà
- ❌ NON alterare la firma (visibilità, tipo, valore predefinito)
- ❌ NON ridichiarare questa proprietà nelle classi derivate

### Verifica obbligatoria
Prima di ogni commit che coinvolge `XotBaseWidget`, verificare la presenza di questa proprietà:

```bash
grep -n "public ?array \$data" /path/to/XotBaseWidget.php
```

## Altre proprietà critiche

### `protected static string $view`
Definisce il template Blade da renderizzare per ogni widget.

### `public array $listener = []`
Gestisce gli eventi Livewire necessari per la comunicazione tra componenti.

## Documentazione completa
Per la documentazione completa, consultare:
- `/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/critical-properties/data-property.md`
