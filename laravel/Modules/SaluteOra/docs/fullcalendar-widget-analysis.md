# Analisi Widget FullCalendar - SaluteOra

## Stato Attuale

### Widget Implementati
- **DoctorCalendarWidget**: Widget per dottori con CRUD completo
- **PatientCalendarWidget**: Widget per pazienti (sola lettura)
- **AdminCalendarWidget**: Widget per amministratori (vista globale)

### Estensioni Corrette
Tutti i widget estendono correttamente `FullCalendarWidget` direttamente:
```php
class DoctorCalendarWidget extends FullCalendarWidget
```

## Problemi Identificati

### 1. **DoctorCalendarWidget - Configurazione Hardcoded**
```php
// ❌ PROBLEMA: Configurazione hardcoded nel metodo config()
public function config(): array
{
    $lang=app()->getLocale();
    
    return [
        'firstDay' => 1,
        'headerToolbar' => [
            'left' => 'prev',
            'center' => 'title',
            'right' => 'next',
        ],
        'titleFormat' => [
            'year' => 'numeric',
            'month' => 'long'
        ],
        'locale' =>  $lang,
        'modal_title' => 'Zibibbo', // ❌ Hardcoded
    ];
}
```

**Soluzione**: Utilizzare il trait `HasFullCalendarConfig` per configurazione centralizzata.

### 2. **Mancanza di Controlli di Accesso**
```php
// ❌ PROBLEMA: Nessun controllo di accesso implementato
class DoctorCalendarWidget extends FullCalendarWidget
{
    // Manca metodo canView() per controllare accesso
}
```

**Soluzione**: Implementare `canView()` per verificare tipo utente e tenancy.

### 3. **Filtri Hardcoded**
```php
// ❌ PROBLEMA: Filtro hardcoded per dottore
->where('doctor_id',auth()->id())
```

**Soluzione**: Utilizzare filtri dinamici basati su tenancy e permessi.

### 4. **Mancanza di Tipizzazione**
```php
// ❌ PROBLEMA: Manca declare(strict_types=1)
<?php
namespace Modules\SaluteOra\Filament\Widgets;
```

**Soluzione**: Aggiungere `declare(strict_types=1);` all'inizio di ogni file.

## Best Practices da Implementare

### 1. **Utilizzo del Trait HasFullCalendarConfig**
```php
use Modules\SaluteOra\Traits\HasFullCalendarConfig;

class DoctorCalendarWidget extends FullCalendarWidget
{
    use HasFullCalendarConfig;
    
    // Configurazione centralizzata tramite trait
}
```

### 2. **Controlli di Accesso**
```php
public static function canView(): bool
{
    return Auth::check() && Auth::user()?->type === UserTypeEnum::DOCTOR;
}
```

### 3. **Filtri Dinamici**
```php
public function fetchEvents(array $fetchInfo): array
{
    $query = Appointment::query()
        ->where('starts_at', '>=', $fetchInfo['start'])
        ->where('ends_at', '<=', $fetchInfo['end']);
    
    // Filtro basato su tenancy per dottori
    if (Filament::getTenant()) {
        $query->where('studio_id', Filament::getTenant()->id);
    }
    
    return $query->get()->map(/* ... */)->toArray();
}
```

### 4. **Tipizzazione Completa**
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Filament\Facades\Filament;
```

## Priorità di Correzione

### **Alta Priorità**
1. **Aggiungere controlli di accesso** (`canView()`)
2. **Implementare filtri tenancy** per isolamento dati
3. **Aggiungere tipizzazione** (`declare(strict_types=1)`)

### **Media Priorità**
4. **Utilizzare trait HasFullCalendarConfig** per configurazione
5. **Rimuovere configurazioni hardcoded**
6. **Migliorare gestione errori**

### **Bassa Priorità**
7. **Ottimizzare performance** con caching
8. **Aggiungere test unitari**
9. **Migliorare UX** con loading states

## Note Importanti

### **Regola Critica**
- **MAI** estendere `XotBaseFullCalendarWidget` (non esiste)
- **SEMPRE** estendere `FullCalendarWidget` direttamente
- **SEMPRE** utilizzare il trait `HasFullCalendarConfig` quando disponibile

### **Compatibilità**
- Tutti i widget funzionano correttamente
- I problemi identificati sono miglioramenti, non bug critici
- Le correzioni possono essere implementate gradualmente

## Collegamenti

- [README SaluteOra](README.md) - Documentazione principale del modulo
- [Appointment States](appointment-states.md) - Stati degli appuntamenti
- [Correzione Icona Arrow Path](correzione-icona-arrow-path-2025-01-06.md) - Correzioni precedenti

---

**Ultimo aggiornamento**: 27 Gennaio 2025
**Stato**: Analisi completata, correzioni pianificate 