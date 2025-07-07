# Proprietà $data in XotBaseWidget: FONDAMENTALE PER LIVEWIRE

## Architettura critica

La proprietà `public ?array $data = []` in `XotBaseWidget` è una componente FONDAMENTALE dell'architettura Filament+Livewire di questo progetto.

## Motivi per cui è critica

1. **Binding dei dati**: Tutti i form Filament nei widget utilizzano `wire:model="data.*"` per collegare i campi di input
2. **Requisito Livewire**: Livewire richiede che OGNI proprietà usata con `wire:model` sia dichiarata nella classe
3. **Accesso ai dati**: I metodi nei widget accedono ai valori del form tramite `$this->data['campo']`
4. **Inizializzazione**: I metodi form->fill() utilizzano questa proprietà per inizializzare i campi

## Errori causati dalla rimozione

Se questa proprietà viene rimossa da `XotBaseWidget`, si verificano:

- Errori `Livewire: [wire:model="data.field"] property does not exist on component`
- Fallimento completo di tutti i widget che utilizzano form
- Malfunzionamento dell'interfaccia utente del backoffice
- Impossibilità di inviare dati tramite i form

## Regole ASSOLUTE

1. **MAI rimuovere la proprietà `$data` da `XotBaseWidget`**
2. **MAI ridichiarare questa proprietà nelle classi derivate**
3. **MAI modificare tipo, visibilità o valore predefinito**

## Procedura di verifica obbligatoria

```bash
grep -n "public ?array \$data" /var/www/html/base_saluteora/laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php
```

Se il comando non restituisce risultati, **RIPRISTINARE IMMEDIATAMENTE** la proprietà.

## Contesto tecnico

Il pattern di utilizzo di un array `$data` per i dati dei form è parte fondamentale dell'architettura Livewire+Filament e non può essere modificato senza riprogettare completamente l'intero sistema di form.

## Documentazione di riferimento

- `/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/critical-properties/data-property.md`
- `/var/www/html/base_saluteora/laravel/.windsurf/rules/critical-filament-properties.md`
- `/var/www/html/base_saluteora/laravel/.cursor/rules/filament-critical-properties.md`
