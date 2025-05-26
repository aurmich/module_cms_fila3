# Integrazione Widget Calendar nei Temi

## Problema Identificato

Il file `laravel/Themes/One/resources/views/components/blocks/calendar.blade.php` contiene un'implementazione completa di FullCalendar da zero, duplicando funzionalità già presenti nei widget Filament del modulo SaluteOra.

### Errori nell'Implementazione Attuale

1. **Duplicazione di Codice**: Il tema ricrea tutto il calendario invece di utilizzare i widget esistenti
2. **Mancanza di Sicurezza**: Non utilizza i controlli di accesso dei widget Filament
3. **Configurazione Duplicata**: Ridefinisce configurazioni già presenti nel trait `HasFullCalendarConfig`
4. **Mancanza di Multi-Tenancy**: Non gestisce correttamente la tenancy di Filament
5. **Violazione DRY**: Duplica logica già implementata nei widget

## Soluzione Corretta

### Principio Fondamentale
I temi devono **richiamare** i widget Filament esistenti, non ricreare la funzionalità.

### Architettura Corretta

```
Theme Component (calendar.blade.php)
    ↓
Richiama Widget Filament
    ↓
Widget con Trait HasFullCalendarConfig
    ↓
Configurazioni e Sicurezza Centralizzate
```

### Implementazione

Il componente tema deve:
1. Determinare il tipo di utente
2. Richiamare il widget appropriato
3. Passare parametri necessari
4. Mantenere styling del tema

## Widget Disponibili

### PatientCalendarWidget
- **Namespace**: `Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget`
- **Accesso**: Solo pazienti autenticati
- **Funzionalità**: Sola lettura
- **Filtro**: Propri appuntamenti

### DoctorCalendarWidget
- **Namespace**: `Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget`
- **Accesso**: Dottori con tenancy
- **Funzionalità**: CRUD completo
- **Filtro**: Appuntamenti dello studio

### AdminCalendarWidget
- **Namespace**: `Modules\SaluteOra\Filament\Widgets\AdminCalendarWidget`
- **Accesso**: Amministratori
- **Funzionalità**: Vista globale
- **Filtro**: Tutti gli appuntamenti

## Implementazione Corretta del Tema

### Struttura del Componente

```php
@props([
    'type' => 'public',
    'height' => '600px',
    'studio-id' => null,
    'patient-id' => null,
])

@php
    // Determina il widget da utilizzare basato su utente e tipo
    $widgetClass = null;
    $canView = false;
    
    if (auth()->check()) {
        $user = auth()->user();
        
        match ($user->type) {
            \Modules\SaluteOra\Enums\UserType::PATIENT => [
                $widgetClass = \Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget::class,
                $canView = true
            ],
            \Modules\SaluteOra\Enums\UserType::DOCTOR => [
                $widgetClass = \Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget::class,
                $canView = \Filament\Facades\Filament::getTenant() !== null
            ],
            \Modules\SaluteOra\Enums\UserType::ADMIN => [
                $widgetClass = \Modules\SaluteOra\Filament\Widgets\AdminCalendarWidget::class,
                $canView = true
            ],
            default => [
                $widgetClass = null,
                $canView = false
            ]
        };
    }
@endphp

@if($canView && $widgetClass)
    <div class="calendar-container theme-one-styling">
        @livewire($widgetClass, ['height' => $height])
    </div>
@else
    <div class="calendar-placeholder">
        <p>Accedi per visualizzare il calendario degli appuntamenti.</p>
    </div>
@endif
```

## Vantaggi della Soluzione

### Sicurezza
- Utilizza controlli di accesso dei widget
- Rispetta tenancy multi-studio
- Filtra automaticamente i dati

### Manutenibilità
- Codice centralizzato nei widget
- Configurazioni nel trait
- Aggiornamenti automatici

### Performance
- Caching implementato nei widget
- Query ottimizzate
- Lazy loading

### Coerenza
- Comportamento uniforme
- Styling consistente
- Traduzioni centralizzate

## File da Aggiornare

1. `laravel/Themes/One/resources/views/components/blocks/calendar.blade.php`
2. Documentazione tema
3. Test di integrazione

## Regole per Temi

### Principi Fondamentali
1. **Non Duplicare**: Mai ricreare funzionalità esistenti
2. **Riutilizzare**: Utilizzare widget e componenti Filament
3. **Estendere**: Solo styling e layout specifici del tema
4. **Sicurezza**: Mantenere controlli di accesso

### Pattern di Integrazione
```php
// ✅ Corretto - Richiama widget esistente
@livewire(\Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget::class)

// ❌ Sbagliato - Ricrea funzionalità
<div id="calendar"></div>
<script>
    // Implementazione FullCalendar da zero
</script>
```

## Collegamenti Documentazione

- [Widget FullCalendar](./fullcalendar_parental_widgets.md)
- [Configurazioni Calendar](./fullcalendar_configuration.md)
- [Best Practices](./fullcalendar-best-practices.md)
- [Multi-Tenant Calendar](./multi-tenant-calendar.md) 