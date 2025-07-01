# Studio Filter Widget - Documentazione Tecnica

## Panoramica

Questo documento fornisce una panoramica tecnica del `StudioFilterWidget`, un componente Filament che consente ai medici di visualizzare e cambiare il proprio studio corrente, fungendo da filtro globale nell'applicazione.

## Architettura

Il widget implementa un pattern multi-tenant per i medici che possono lavorare in più studi:

```
Doctor (1) --- (N) DoctorStudio (N) --- (1) Studio
```

### Caratteristiche Chiave

- **Multi-tenant**: Un medico può lavorare in più studi
- **Cross-database**: La relazione attraversa database diversi
- **Event-driven**: Dispatcha eventi per notificare altri componenti
- **Policy-based**: Controlli di accesso rigorosi

### Relazione Cross-Database

La relazione è particolarmente complessa poiché attraversa database differenti:
- `Doctor`: risiede nel database 'user'
- `Studio`: risiede nel database 'salute_ora'
- `DoctorStudio` (pivot): risiede nel database 'saluteora_data'

### Implementazione delle Relazioni

```php
// In Doctor.php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}

// In Studio.php
public function doctors(): BelongsToMany
{
    return $this->belongsToMany(Doctor::class, 'doctor_studio');
}
```

## Modello DoctorStudio

Il modello pivot `DoctorStudio` non è un semplice pivot ma un modello complesso con logica propria:

- Gestione orari di apertura con `getOpeningHours()`
- Generazione slot temporali con `getAvailableTimeSlotsByDate()`
- Verifica disponibilità date con `getEnabledDatesByMonth()`

## Widget Filament

### Policy di Visibilità

```php
public static function canView(): bool
{
    $user = Auth::user();
    
    return $user && 
           $user->type === UserTypeEnum::DOCTOR &&
           $user instanceof Doctor;
}
```

### Sistema di Eventi

Il widget implementa un sistema di eventi per notificare altri componenti del cambio studio:

- **Dispatched**: `studioChanged` con dati dello studio
- **Listener**: `#[On('studio-selected')]` per eventi esterni

### Integrazione Multi-Tenant

Il widget aggiorna anche il tenant di Filament quando si cambia studio:

```php
session(['tenant_id' => $studioId]);
```

## Best Practices

- **Eager Loading**: Utilizzare `with(['addresses'])` per ottimizzare le query
- **Type Safety**: Dichiarazioni di tipo rigorose per tutti i metodi
- **Caching**: Minimizzare le query al database
- **Feedback**: Notifiche immediate sulle azioni dell'utente

## Note Importanti

- Il widget è strettamente integrato con l'architettura multi-tenant dell'applicazione
- Richiede che il modello `Doctor` estenda `User` e abbia il trait `HasParent`
- Utilizza `Modules/Xot/Filament/Widgets/XotBaseWidget` come classe base
- La vista utilizza componenti Blade di Filament per mantenere coerenza UI

## Collegamenti

- [Documentazione Dettagliata](../laravel/Modules/SaluteOra/docs/studio-filter-widget.md)
- [Documentazione Appointment](../laravel/Modules/SaluteOra/docs/appointment-states.md)
- [Modelli e Relazioni](models-and-relationships.md)

---

*Ultimo aggiornamento: 30 Giugno 2025*
