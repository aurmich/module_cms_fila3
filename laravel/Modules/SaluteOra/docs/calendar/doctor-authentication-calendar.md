# Autenticazione e Gestione Dottori nei Calendari

## Principi Fondamentali

Nel sistema SaluteOra, l'accesso al calendario delle disponibilità dei dottori si basa sul pattern **Single Table Inheritance (STI)** implementato tramite il package Parental. È fondamentale comprendere questa architettura per evitare errori comuni nella gestione dell'autenticazione e dell'accesso ai dati.

## Recupero dell'Utente Dottore

### Approccio Corretto

```php
/**
 * Ottenere il dottore corrente.
 *
 * @return \Modules\SaluteOra\Models\User
 */
protected function getCurrentDoctor()
{
    // L'utente corrente è già un dottore con type='doctor' nella tabella users
    // SaluteOra utilizza Single Table Inheritance pattern
    return Filament::auth()->user();
}
```

### Anti-Pattern da Evitare

```php
// ERRATO: Non esiste una colonna 'user_id' nella tabella doctors
protected function getCurrentDoctor(): Doctor
{
    $user = Filament::auth()->user();
    return Doctor::where('user_id', $user->id)->firstOrFail(); // ❌ Errore!
}

// ERRATO: Non serve una conversione esplicita se l'utente è già un dottore
protected function getCurrentDoctor(): Doctor
{
    $user = Filament::auth()->user();
    return Doctor::findOrFail($user->id); // ❌ Ridondante!
}
```

## Filtraggio Appuntamenti per Dottore

### Approccio Corretto

```php
// Filtrare appuntamenti per il dottore corrente
Appointment::query()
    ->where('doctor_id', Filament::auth()->user()->id)
    ->where('studio_id', $studio->id)
    ->get();
```

### Anti-Pattern da Evitare

```php
// ERRATO: Non recuperare prima il dottore quando l'utente è già un dottore
$doctor = Doctor::where('user_id', Filament::auth()->user()->id)->first();
Appointment::query()
    ->where('doctor_id', $doctor->id) // ❌ Query aggiuntiva non necessaria
    ->where('studio_id', $studio->id)
    ->get();
```

## Autorizzazioni nei Calendari

### Approccio Corretto

```php
// Verificare se l'utente è un dottore
if (Filament::auth()->user()->type === 'doctor') {
    // Logica specifica per dottori
}

// Alternativa usando i ruoli
if (Filament::auth()->user()->hasRole('doctor')) {
    // Logica specifica per dottori
}
```

### Anti-Pattern da Evitare

```php
// ERRATO: Non cercare un dottore separato quando l'utente è già un dottore
$doctor = Doctor::where('user_id', Filament::auth()->user()->id)->first();
if ($doctor) { // ❌ Query non necessaria
    // Logica specifica per dottori
}
```

## Integrazione con Filament e FullCalendar

Quando si implementano widget e pagine FullCalendar per dottori, seguire queste linee guida:

1. **Usare l'utente autenticato direttamente** quando si tratta del dottore corrente
2. **Verificare i permessi** prima di mostrare o modificare dati sensibili
3. **Filtrare gli appuntamenti** usando l'ID dell'utente corrente, non cercando relazioni inesistenti

```php
// Esempio di implementazione corretta in una pagina Filament
public function doctorCalendarWidget(): FullCalendarWidget
{
    $doctor = Filament::auth()->user(); // Il dottore è l'utente autenticato
    $studio = Filament::getTenant();

    return FullCalendarWidget::make()
        ->config([
            // Configurazioni del calendario
        ])
        ->events(function (array $fetchInfo) use ($doctor, $studio) {
            return Appointment::query()
                ->where('doctor_id', $doctor->id)
                ->where('studio_id', $studio->id)
                ->whereBetween('start_time', [
                    Carbon::parse($fetchInfo['start']),
                    Carbon::parse($fetchInfo['end']),
                ])
                ->get()
                ->map(function (Appointment $appointment) {
                    // Trasformazione in eventi del calendario
                });
        });
}
```

## Conclusione

La corretta comprensione del pattern Single Table Inheritance per gli utenti è fondamentale per implementare efficacemente le funzionalità di calendario in SaluteOra. Evitando gli anti-pattern documentati, si ottiene un codice più efficiente, manutenibile e privo di errori.