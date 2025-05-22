# Componenti Volt - Best Practices

## Panoramica
Questo documento descrive le best practices per l'implementazione dei componenti Volt nel tema One, con particolare attenzione alla struttura, alle convenzioni e alla prevenzione degli errori comuni.

## Regole Fondamentali

### 1. Struttura dei Componenti Volt

#### Elemento Radice Singolo
**IMPORTANTE**: Ogni componente Volt deve avere un singolo elemento HTML radice.

✅ **CORRETTO**:
```php
@volt('register')
<div>
    <!-- Tutto il contenuto del componente qui -->
    <div class="header">...</div>
    <div class="content">...</div>
    <div class="footer">...</div>
</div>
@endvolt
```

❌ **ERRATO**:
```php
@volt('register')
<!-- Errore: elementi multipli a livello radice -->
<div class="header">...</div>
<div class="content">...</div>
<div class="footer">...</div>
@endvolt
```

### 2. Integrazione con Layouts

#### Posizionamento Corretto
Quando si utilizza un componente Volt all'interno di un layout, assicurarsi che il tag `@volt` sia posizionato all'interno del contenuto del layout, non viceversa.

✅ **CORRETTO**:
```php
<x-layouts.app>
    @volt('register')
    <div>
        <!-- Contenuto del componente -->
    </div>
    @endvolt
</x-layouts.app>
```

❌ **ERRATO**:
```php
@volt('register')
<x-layouts.app>
    <div>
        <!-- Contenuto del componente -->
    </div>
</x-layouts.app>
@endvolt
```

### 3. Gestione degli Stati

#### Dichiarazione degli Stati
Utilizzare la funzione `state()` per dichiarare le proprietà del componente:

```php
<?php
use function Livewire\Volt\{state};

state(['name' => '', 'email' => '']);
?>

<div>
    <input wire:model="name" type="text">
    <input wire:model="email" type="email">
</div>
```

### 4. Quando Usare Volt vs Widget Filament

#### Volt è Ideale Per:
- Componenti UI semplici
- Interazioni utente di base
- Logica specifica della pagina

#### Widget Filament è Preferibile Per:
- Form complessi
- Wizard multi-step
- Validazione avanzata
- Funzionalità riutilizzabili

## Risoluzione Problemi Comuni

### 1. Errore: Multiple Root Elements Detected

**Problema**: 
```
Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException
Livewire only supports one HTML element per component. Multiple root elements detected.
```

**Soluzione**:
Racchiudere tutti gli elementi del componente in un singolo elemento div:

```php
@volt('register')
<div>
    <!-- Tutti gli elementi qui -->
</div>
@endvolt
```

### 2. Errore: Property Not Found

**Problema**:
```
Property [propertyName] not found on component [component-name]
```

**Soluzione**:
Assicurarsi che tutte le proprietà siano dichiarate con `state()` o nella classe del componente:

```php
<?php
use function Livewire\Volt\{state};

state(['propertyName' => 'defaultValue']);
?>
```

## Collegamenti Bidirezionali

- [Livewire Components](./livewire-components.md) - Documentazione sui componenti Livewire
- [Theme Architecture](./THEME.md) - Architettura generale del tema
- [Folio Pages](./folio-pages.md) - Documentazione sulle pagine Folio
- [Architettura Folio + Volt + Filament](../../Modules/Xot/docs/folio_volt_architecture.md) - Documentazione generale sull'architettura frontend
