# Convenzioni per le Viste in SaluteMo

## Struttura delle Directory

### Posizione Corretta
Le viste del modulo SaluteMo devono essere organizzate nella seguente struttura:
```
Modules/SaluteMo/
  resources/
    views/
      components/       # Componenti Blade riutilizzabili
      layouts/          # Layout base
      pages/            # Pagine specifiche
      partials/         # Parti riutilizzabili
      filament/         # Viste Filament
        widgets/        # Viste per widget Filament
        resources/      # Viste per risorse Filament
```

## Convenzioni per i Widget Filament

### Pattern del Path
Tutte le viste dei widget Filament devono seguire questo pattern:
```php
protected static string $view = 'salutemo::filament.widgets.nome-vista';
```

### Punti Chiave
1. Includere sempre `filament` nel percorso della vista
2. Le viste dei widget devono essere in `resources/views/filament/widgets/`
3. Usare kebab-case per i nomi dei file delle viste
4. Mai usare `widgets` senza il prefisso `filament`

### Esempio Corretto
```php
// Corretto
protected static string $view = 'salutemo::filament.widgets.mobile-activity';

// Errato
protected static string $view = 'salutemo::widgets.mobile-activity';
```

### Convenzione di Denominazione
- Convertire il nome della classe in kebab-case
- Rimuovere il suffisso 'Widget' se presente
- Esempio: `MobileActivityWidget` → `mobile-activity`

## Localizzazione degli URL

### Regola Fondamentale
Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso:

```
/{locale}/{sezione}/{risorsa}
```

### Implementazione

#### 1. Recuperare la Locale Corrente
Usare sempre la funzione `app()->getLocale()` per ottenere la lingua corrente:

```php
$locale = app()->getLocale();
```

Non utilizzare mai valori hardcoded come 'it' o 'en'.

#### 2. Generare Link Localizzati
Quando si generano link, includere sempre la locale:

```php
// CORRETTO
<a href="{{ url('/' . app()->getLocale() . '/mobile/appointments') }}">{{ $appointment->title }}</a>

// ERRATO
<a href="{{ url('/mobile/appointments') }}">{{ $appointment->title }}</a>
```

#### 3. Nelle Pagine
Nelle pagine, recuperare e passare sempre la locale alla vista:

```php
render(function (View $view) {
    $locale = app()->getLocale();
    // altre operazioni...
    return $view->with([
        'data' => $data,
        'locale' => $locale,
    ]);
});
```

### Errori Comuni da Evitare
1. **URL senza prefisso lingua**: `/mobile/appointments` invece di `/it/mobile/appointments`
2. **URL mal formati**: `it/mobile/appointments` (manca lo slash iniziale)
3. **Link generati senza locale**: `url('/mobile/appointments')` invece di `url('/' . $locale . '/mobile/appointments')`

### Esempi Corretti
- `/it/mobile/appointments`
- `/en/mobile/doctors`
- `/it/mobile/profile`

## Componenti Blade

### Convenzione di Denominazione
- Usare kebab-case per i nomi dei file
- Nome descrittivo della funzionalità
- Suffisso `.blade.php` obbligatorio

```
mobile-appointment-card.blade.php
mobile-doctor-selector.blade.php
```

### Struttura Componenti
Utilizzare la sintassi dei componenti con tag:

```blade
<x-salutemo::mobile-appointment-card 
    :appointment="$appointment"
    :showActions="true" 
/>
```

### Attributi e Props
- Utilizzare camelCase per le props nel componente
- Utilizzare kebab-case quando si passa l'attributo nel tag

```php
// Definizione
@props(['appointmentData', 'showActions' => false])

// Utilizzo
<x-salutemo::mobile-appointment-card 
    :appointment-data="$appointment"
    :show-actions="true" 
/>
```

## Modelli di Layout

### Layout Base
Creare un layout base per le viste mobile:

```blade
{{-- resources/views/layouts/mobile.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SaluteMo' }}</title>
    @stack('styles')
</head>
<body class="mobile-layout">
    <div class="mobile-container">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
```

### Estensione del Layout
```blade
{{-- Una vista che utilizza il layout --}}
@extends('salutemo::layouts.mobile')

@section('content')
    <div class="mobile-appointment-list">
        {{-- Contenuto specifico --}}
    </div>
@endsection
```

## Collegamenti Correlati
- [Struttura del Modulo](../structure/namespace-conventions.md)
- [Convenzioni di Traduzione](../translations/conventions.md)
- [Widget Filament](../filament/widgets.md)
