# Single Table Inheritance con Parental

## Panoramica

Single Table Inheritance (STI) è un pattern che permette di estendere modelli mantenendo una singola tabella nel database. Nel contesto di SaluteOra, questo pattern è utilizzato per gestire diversi tipi di utenti (ad esempio: Doctor, Patient, Staff) che condividono la stessa tabella `users`.

## Implementazione con Parental

[Parental](https://github.com/tighten/parental) è un pacchetto che facilita l'implementazione di STI in Laravel.

### Configurazione di base

1. Nel modello principale (parent):
```php
namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

class User extends Model
{
    use HasChildren;

    // Il campo 'type' identifica il tipo di utente
    protected $fillable = ['type'];
    
    // Opzionale: definire il campo type
    // protected $childTypeField = 'type';
}
```

2. Nei modelli figli (children):
```php
namespace Modules\SaluteOra\Models;

use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
    
    // Comportamenti specifici del Doctor
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
```

### Struttura del database

Una tabella `users` con un campo `type` che identifica il tipo di utente:

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('type')->nullable(); // Memorizza il tipo di utente
    // Altri campi comuni a tutti gli utenti
    $table->timestamps();
});
```

### Ottenere il modello figlio corretto

Quando recuperi un modello User, Parental restituirà automaticamente l'istanza del tipo corretto:

```php
// Restituisce un'istanza di Doctor se l'utente è un medico
$user = User::find(1);

// Verifica il tipo di utente
if ($user instanceof Doctor) {
    // Comportamento specifico per i medici
}
```

### Definire comportamenti specifici

Ogni modello figlio può avere metodi e relazioni specifici:

```php
class Doctor extends User
{
    use HasParent;
    
    // Metodi specifici per Doctor
    public function getAvailabilities()
    {
        // Logica per recuperare le disponibilità
    }
    
    // Relazioni specifiche per Doctor
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class);
    }
}
```

## Uso in SaluteOra

### Nel calendario delle disponibilità del medico

```php
protected function getCurrentDoctor(): User
{
    $user = Filament::auth()->user();
    if (!$user || $user->type->value !== 'doctor') {
        throw new \Exception('L\'utente corrente non è un dottore è un ['.$user->type->value.']');
    }
    return $user;
}
```

### Vantaggi dell'approccio STI

1. **Un solo punto di verità**: tutti i dati utente in un'unica tabella
2. **Evita duplicazione**: nessuna ripetizione di dati tra tabelle correlate
3. **Semplifica le query**: non richiede join complessi per dati di base
4. **Mantiene il polimorfismo**: ogni tipo di utente può avere comportamenti specifici

## Best Practices

1. **Utilizzare Enum per il tipo**: 
```php
use Modules\SaluteOra\Enums\UserTypeEnum;

// Verifica con enum
if ($user->type !== UserTypeEnum::DOCTOR) {
    // ...
}
```

2. **Verificare sempre il tipo prima di utilizzare comportamenti specifici**:
```php
if ($user instanceof Doctor) {
    $availabilities = $user->getAvailabilities();
}
```

3. **Definire chiaramente i comportamenti specifici per ogni tipo di utente**:
Ogni classe figlio dovrebbe avere metodi e relazioni ben definiti e documentati.

## Risorse

- [Documentazione Parental](https://github.com/tighten/parental)
- [Single Table Inheritance Pattern](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)
