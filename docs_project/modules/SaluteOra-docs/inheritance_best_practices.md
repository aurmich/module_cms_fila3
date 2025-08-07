# Best Practices per l'Ereditarietà delle Classi

## Introduzione

Questo documento descrive le best practices per l'implementazione corretta dell'ereditarietà delle classi nel modulo Patient, con particolare attenzione all'evitare la duplicazione di trait nelle classi figlie.

## Catena di Ereditarietà

Nel modulo Patient, la catena di ereditarietà per i modelli utente è la seguente:

```
BaseUser (Modules\User\app\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Doctor (Modules\Patient\Models\Doctor)
         |
         +--> Patient (Modules\Patient\Models\Patient)
```

Questa struttura implementa il pattern Single Table Inheritance (STI), dove tutti i tipi di utente condividono la stessa tabella `users` nel database, con il campo `type` che determina il tipo specifico.

## Trait Ereditati

È fondamentale comprendere che quando una classe estende un'altra classe, eredita automaticamente tutti i trait della classe genitore. Pertanto, è necessario evitare di ridichiarare gli stessi trait nella classe figlia.

### Esempio: BaseUser

La classe `BaseUser` include già diversi trait importanti:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\User\Models\Traits\HasTeams;
use Spatie\Permission\Traits\HasRoles;
use Parental\HasChildren;
```

### Esempio: Doctor

La classe `Doctor` estende `User`, che a sua volta estende `BaseUser`. Pertanto, `Doctor` eredita già tutti i trait di `BaseUser` e `User`.

```php
// ❌ ERRATO - Duplicazione del trait HasFactory
class Doctor extends User
{
    use HasFactory; // Già ereditato da BaseUser
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;
    
    // ...
}

// ✅ CORRETTO - Nessuna duplicazione
class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;
    
    // ...
}
```

## Regole da Seguire

1. **MAI ridichiarare trait già presenti nelle classi genitori**
   - Prima di aggiungere un trait, verificare se è già presente nella catena di ereditarietà

2. **Esaminare il codice delle classi genitori**
   - Comprendere quali trait e metodi sono già disponibili attraverso l'ereditarietà

3. **Documentare la catena di ereditarietà**
   - Includere commenti PHPDoc che descrivono la relazione di ereditarietà

4. **Utilizzare IDE con supporto per la navigazione dell'ereditarietà**
   - Strumenti come PHPStorm mostrano i membri ereditati, facilitando l'identificazione dei trait duplicati

## Vantaggi dell'Approccio Corretto

1. **Codice più pulito e manutenibile**
   - Evita duplicazioni inutili che possono causare confusione

2. **Prestazioni migliori**
   - Evita l'inizializzazione multipla dello stesso trait

3. **Coerenza del comportamento**
   - Garantisce che il comportamento ereditato sia coerente in tutta la gerarchia

4. **Facilità di refactoring**
   - Semplifica le modifiche ai trait nelle classi base, poiché non ci sono duplicazioni da gestire

## Errori Comuni e Come Evitarli

### 1. Duplicazione di Trait

```php
// ❌ ERRATO
class Doctor extends User
{
    use HasFactory; // Già ereditato da BaseUser
    // ...
}
```

### 2. Sovrascrittura Involontaria di Metodi

```php
// ❌ ERRATO
class Doctor extends User
{
    public function getFilamentName()
    {
        // Sovrascrive il metodo ereditato senza chiamare parent::getFilamentName()
        return $this->first_name . ' ' . $this->last_name;
    }
}

// ✅ CORRETTO
class Doctor extends User
{
    public function getFilamentName()
    {
        // Estende il comportamento del metodo genitore
        $name = parent::getFilamentName();
        return $name . ' (Dottore)';
    }
}
```

### 3. Ignorare i Metodi Ereditati

```php
// ❌ ERRATO
class Doctor extends User
{
    // Reimplementa la logica già presente in un metodo ereditato
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

// ✅ CORRETTO
// Non reimplementare metodi già ereditati, a meno che non sia necessario modificarne il comportamento
```

## Conclusione

Seguire queste best practices per l'ereditarietà delle classi garantisce un codice più pulito, manutenibile e privo di duplicazioni. Prima di aggiungere trait o metodi a una classe, verificare sempre se sono già disponibili attraverso l'ereditarietà. Questo approccio migliora la qualità del codice e riduce la possibilità di errori.
