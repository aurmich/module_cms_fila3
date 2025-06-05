# Convenzioni di Nomenclatura in <nome progetto>

Questo documento definisce le convenzioni ufficiali di nomenclatura da utilizzare in tutto il progetto <nome progetto>.

## Convenzioni Generali

### Formato Case

- **PascalCase**: Prima lettera maiuscola, senza spazi o separatori (es. `UserProfile`)
  - Usato per: Nomi di classi, interfacce, enumerazioni, nomi dei moduli
  
- **camelCase**: Prima lettera minuscola, senza spazi o separatori (es. `getUserProfile`)
  - Usato per: Metodi, funzioni, proprietà non statiche
  
- **snake_case**: Tutte le lettere minuscole, parole separate da underscore (es. `user_profile`)
  - Usato per: Variabili, costanti di classe (non globali), nomi di file delle viste, tabelle del database, colonne del database
  
- **UPPER_SNAKE_CASE**: Tutte le lettere maiuscole, parole separate da underscore (es. `MAX_LOGIN_ATTEMPTS`)
  - Usato per: Costanti globali, enums

## Moduli

### Nome del Modulo

Il nome del modulo deve essere in formato **PascalCase** con la prima lettera maiuscola.

- ✅ CORRETTO: `Blog`, `UserProfile`, `MobilitaVolontaria`
- ❌ ERRATO: `blog`, `userProfile`, `mobilitavolontaria`, `Mobilita_Volontaria`

### Namespace del Modulo

I namespace dei moduli devono seguire il formato:

```php
namespace Modules\NomeModulo;
```

### Service Provider

Il service provider principale di un modulo deve:

1. Avere il nome che termina con `ServiceProvider` 
2. Estendere `XotBaseServiceProvider`
3. Definire una proprietà `$name` con il nome del modulo in **PascalCase**

```php
class BlogServiceProvider extends XotBaseServiceProvider {
    public string $name = 'Blog';
    // ...
}
```

## Database

### Tabelle

I nomi delle tabelle devono essere in **snake_case** e al plurale:

- ✅ CORRETTO: `users`, `blog_posts`, `user_profiles`
- ❌ ERRATO: `User`, `BlogPost`, `user_profile`

### Colonne

I nomi delle colonne devono essere in **snake_case**:

- ✅ CORRETTO: `first_name`, `created_at`, `user_id`
- ❌ ERRATO: `firstName`, `CreatedAt`, `UserID`

### Chiavi Primarie

Usare `id` come nome della chiave primaria.

### Chiavi Esterne

Usare `table_name_singular_id` come formato per le chiavi esterne:

- ✅ CORRETTO: `user_id`, `blog_post_id`
- ❌ ERRATO: `userID`, `blogPostId`, `user`

## Filament

### Nomi delle Risorse

I nomi delle risorse Filament devono essere in **PascalCase** e terminare con `Resource`:

- ✅ CORRETTO: `UserResource`, `BlogPostResource`
- ❌ ERRATO: `Users`, `blogPost`, `Blog_Post_Resource`

### Metodi per le azioni

I metodi per le azioni delle tabelle devono essere **pubblici**:

```php
// ✅ CORRETTO
public function getTableHeaderActions(): array
{
    // ...
}

// ❌ ERRATO
protected function getTableHeaderActions(): array
{
    // ...
}
```

## Traduzioni

### Chiavi di Traduzione

Le chiavi di traduzione devono essere in **snake_case**:

```php
// File di traduzione
return [
    'user_profile' => [
        'title' => 'Profilo Utente',
        'fields' => [
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
        ],
    ],
];
```

## Repository Git

### Nomi dei Branch

- **feature/nome-feature**: Per nuove funzionalità
- **bugfix/descrizione-bug**: Per correzioni di bug
- **hotfix/descrizione-hotfix**: Per correzioni urgenti
- **release/versione**: Per preparare release

### Commit Message

Formato consigliato:
```
type(scope): descrizione breve

Descrizione dettagliata se necessaria
```

Tipi: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`

## Regole Fondamentali

### 1. Campi Database
- Usare snake_case per i nomi delle colonne
- **Usare sempre `first_name` e `last_name` per i nomi personali, MAI `surname` o `name`** (vedi [documentazione dettagliata](./conventions/personal-name-fields.md))
- Usare `_id` come suffisso per le chiavi esterne
- Usare `_at` come suffisso per i timestamp
- Usare `is_` come prefisso per i booleani

Per dettagli completi sui campi nome/cognome, vedere [Field Naming Conventions](./conventions/field-naming.md)

### 2. Modelli
- Usare PascalCase al singolare (es. `Patient`, `Doctor`)
- Estendere sempre le classi base del modulo Xot
- Definire le relazioni con nomi descrittivi

### 3. Tabelle
- Usare snake_case al plurale (es. `patients`, `medical_records`)
- Usare nomi descrittivi e completi
- Evitare abbreviazioni

### 4. Migrazioni
- Formato: `YYYY_MM_DD_HHMMSS_create_table_name_table.php`
- Usare verbi descrittivi (create, add, remove, update)
- Includere sempre metodi up() e down()

### 5. Controller
- Suffisso `Controller` (es. `PatientController`)
- Raggruppare per modulo/funzionalità
- Estendere controller base appropriato

### 6. Views
- Usare kebab-case
- Raggruppare in cartelle per contesto
- Separare layout da componenti

### 7. Route
- Usare kebab-case per gli URL
- Usare snake_case per i nomi delle route
- Raggruppare per modulo/funzionalità

### 8. File di Configurazione
- Usare snake_case
- Nomi descrittivi e completi
- Raggruppare per contesto

### 9. Eventi
- Suffisso `Event` (es. `PatientCreatedEvent`)
- Usare il passato per azioni completate
- Nomi descrittivi dell'azione

### 10. Jobs
- Suffisso `Job` (es. `ProcessPatientDataJob`)
- Verbi che descrivono l'azione
- Nomi auto-esplicativi

## Esempi

### Database Fields
```php
// CORRETTO
$table->string('first_name');
$table->string('last_name');
$table->foreignId('doctor_id');
$table->timestamp('created_at');
$table->boolean('is_active');

// ERRATO
$table->string('surname');  // Usare last_name
$table->string('name');     // Usare first_name
$table->integer('doctorid');
$table->timestamp('creation_date');
$table->boolean('active');
```

### Models
```php
// CORRETTO
class Patient extends XotBaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];
}

// ERRATO
class Patients extends Model  // Non usare plurale
{
    protected $fillable = [
        'name',      // Usare first_name
        'surname',   // Usare last_name
        'email',
    ];
}
```

## Note Importanti
1. Mantenere la coerenza in tutto il progetto
2. Documentare eccezioni alle convenzioni
3. Seguire gli standard del settore
4. Considerare l'internazionalizzazione
5. Rispettare le convenzioni Laravel quando possibile

## Collegamenti
- [Field Naming Conventions](./conventions/field-naming.md)
- [Database Schema Guidelines](./database/schema.md)
- [Coding Standards](./standards/coding.md)
- [Best Practices](./BEST-PRACTICES.md)

## Collegamenti tra versioni di naming-conventions.md
* [naming-conventions.md](docs/naming-conventions.md)
* [naming-conventions.md](../../../Xot/docs/naming-conventions.md)

