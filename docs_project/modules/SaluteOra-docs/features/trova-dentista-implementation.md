# Implementazione Dettagliata - Trova Dentista

## 1. Architettura Generale

### 1.1 Componenti Principali

```
app/
├── Filament/
│   └── Resources/
│       └── DoctorResource.php
│       └── AppointmentResource.php
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── DentistSearchController.php
│   │       ├── AvailabilityController.php
│   │       └── BookingController.php
│   └── Requests/
│       ├── SearchDentistRequest.php
│       └── BookAppointmentRequest.php
├── Models/
│   ├── Dentist.php
│   ├── DentistAvailability.php
│   └── Appointment.php
└── Services/
    ├── DentistSearchService.php
    └── BookingService.php
```

### 1.2 Flusso Dati

1. L'utente inserisce i criteri di ricerca
2. Il frontend invia una richiesta all'API di ricerca
3. Il backend filtra i dentisti in base ai criteri
4. Vengono restituiti i risultati con disponibilità
5. L'utente seleziona un appuntamento
6. Viene creata la prenotazione
7. Vengono inviate le notifiche

## 2. Dettagli Implementativi

### 2.1 Modello Dati

```php
// Dentist.php
class Dentist extends User
{
    // ...
    
    public function availabilities()
    {
        return $this->hasMany(DentistAvailability::class);
    }
    
    public function scopeSearch($query, array $filters)
    {
        return $query->when($filters['city'] ?? null, function ($q, $city) {
            $q->where('city', 'like', "%{$city}%");
        });
    }
}
```

### 2.2 Controller API

```php
// DentistSearchController.php
public function search(SearchDentistRequest $request, DentistSearchService $service)
{
    $dentists = $service->search($request->validated());
    return DentistResource::collection($dentists);
}
```

### 2.3 Servizio di Ricerca

```php
// DentistSearchService.php
public function search(array $criteria)
{
    $query = Dentist::with(['availabilities', 'specializations'])
        ->where('is_active', true);

    // Applica filtri
    foreach ($criteria as $field => $value) {
        if (method_exists($this, $method = 'filterBy' . Str::studly($field))) {
            $query = $this->{$method}($query, $value);
        }
    }

    return $query->paginate(10);
}
```

## 3. Frontend

### 3.1 Componenti Vue

- `DentistSearch.vue`: Form di ricerca
- `DentistList.vue`: Lista risultati
- `DentistMap.vue`: Mappa interattiva
- `AppointmentWizard.vue`: Wizard prenotazione

### 3.2 Stato dell'Applicazione

```javascript
// store/dentist.js
export const state = () => ({
  searchParams: {
    location: '',
    specialization: null,
    date: null,
  },
  results: [],
  selectedDentist: null,
  loading: false,
  error: null
});
```

## 4. Sicurezza

- Validazione input lato server
- Rate limiting per le API
- Sanitizzazione output
- Protezione CSRF
- Controlli di autorizzazione

## 5. Performance

- Caching delle ricerche
- Lazy loading delle immagini
- Ottimizzazione query con eager loading
- Compressione risorse
- CDN per asset statici
