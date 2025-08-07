# Pattern di Ereditarietà Single Table per Utenti in SaluteOra

## Panoramica

SaluteOra utilizza il pattern **Single Table Inheritance (STI)** per gestire diversi tipi di utenti (dottori, pazienti, amministratori) all'interno di un'unica tabella `users`. Questo approccio semplifica il modello dati e migliora le prestazioni evitando join tra tabelle.

## Implementazione Tecnica

### Package Parental

Il sistema utilizza il package [Parental](https://github.com/calebporzio/parental) che fornisce un'implementazione elegante del pattern STI in Laravel.

```php
use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
    // ...
}
```

### Discriminatore di Tipo

Un campo `type` nella tabella `users` identifica il tipo specifico di utente:

```php
protected $attributes = [
    'type' => 'doctor',  // Valore predefinito per questa classe
];
```

### Modello Base e Modelli Figli

- **User**: Modello base che rappresenta tutti gli utenti
- **Doctor**: Estende User, ha `type` = 'doctor'
- **Patient**: Estende User, ha `type` = 'patient'
- **Admin**: Estende User, ha `type` = 'admin'

## Linee Guida per lo Sviluppo

### Accedere ai Modelli Specifici

```php
// CORRETTO: usando STI
$doctor = Doctor::findOrFail($user_id);

// ERRATO: cercando una relazione che non esiste
$doctor = Doctor::where('user_id', $user_id)->first(); // ❌ NON FARE QUESTO
```

### Conversione tra Tipi

Quando si ha un'istanza di `User` e si vuole ottenere il modello figlio corrispondente:

```php
$user = User::find($id);

// Se il type è 'doctor', restituisce un'istanza di Doctor
$specificUser = $user->resolveChildModel();
```

### Autenticazione in Filament

Nei pannelli Filament, l'utente autenticato è già l'istanza corretta:

```php
// In una pagina Filament per dottori
protected function getCurrentDoctor()
{
    // L'utente autenticato è già un'istanza di Doctor se ha type='doctor'
    return Filament::auth()->user();
}
```

### Query Builder

Quando si creano query con vincoli specifici per un tipo:

```php
// Query solo per dottori
$doctors = User::where('type', 'doctor')->get();

// Equivalente a
$doctors = Doctor::all();
```

## Vantaggi del Pattern STI

1. **Semplicità**: Tutti i dati utente in un'unica tabella
2. **Performance**: Nessun join necessario per recuperare informazioni utente
3. **Polimorfismo**: Possibilità di trattare tutti gli utenti in modo uniforme
4. **Flessibilità**: Facile aggiunta di nuovi tipi di utenti

## Anti-Pattern da Evitare

### ❌ Relazione diretta User-Doctor

```php
// ANTI-PATTERN: Non cercare mai una relazione tra User e Doctor
$doctor = Doctor::where('user_id', $user->id)->first();
```

### ❌ Duplicazione di campi

```php
// ANTI-PATTERN: Non duplicare campi già presenti nel modello parent
protected $fillable = [
    'id',  // Già presente in User
    'email',  // Già presente in User
    // ...
];
```

### ❌ Override di metodi base senza chiamare parent

```php
// ANTI-PATTERN: Non sovrascrivere metodi senza chiamare il parent
protected function casts(): array
{
    return [  // Dovrebbe essere array_merge(parent::casts(), [...])
        'email_verified_at' => 'datetime',
    ];
}
```

## Conclusione

Il pattern Single Table Inheritance è fondamentale nell'architettura di SaluteOra per gestire in modo efficiente diversi tipi di utenti. Comprendere questo pattern è essenziale per sviluppare correttamente funzionalità che coinvolgono utenti, dottori e pazienti.