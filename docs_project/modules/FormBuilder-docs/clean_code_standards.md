# Clean Code Standards - Modulo FormBuilder

## Principi Fondamentali

### Commenti - Regole e Anti-pattern

#### ❌ COMMENTI DA EVITARE ASSOLUTAMENTE

```php
// ❌ MAI fare commenti banali e ovvi
$user = User::find($id); // Trova l'utente
$form = new Form(); // Crea un nuovo form
$isActive = true; // Imposta come attivo

// ❌ MAI commentare il codice ovvio
if ($user->isActive()) { // Controlla se l'utente è attivo
    // ...
}

// ❌ MAI commenti che ripetono il nome della variabile
$formName = $form->name; // Nome del form
$formStatus = $form->status; // Stato del form
```

#### ✅ COMMENTI ACCETTABILI

```php
// ✅ Commenti che spiegano il PERCHÉ, non il COSA
$user = User::find($id); // Necessario per validazione multi-tenant

// ✅ Commenti per logica complessa
$form = Form::where('status', 'active')
    ->where('tenant_id', $tenantId)
    ->where('expires_at', '>', now())
    ->first(); // Filtra solo form attivi e non scaduti per il tenant corrente

// ✅ Commenti per workaround temporanei
// TODO: Rimuovere quando il bug di Filament sarà risolto
$form->saveQuietly(); // Evita trigger di eventi non necessari

// ✅ Commenti per business logic complessa
if ($user->hasRole('admin') && $form->isRestricted()) {
    // Gli admin possono sempre accedere ai form restrittivi
    // indipendentemente dalle policy standard
}
```

### Naming Conventions

#### ✅ NOMI DESCRITTIVI E SIGNIFICATIVI

```php
// ✅ Buoni esempi
$activeForms = Form::where('is_active', true)->get();
$userWithPermissions = User::with('permissions')->find($id);
$formSubmissionCount = FormSubmission::count();

// ❌ Nomi generici e non descrittivi
$data = Form::all();
$user = User::find($id);
$count = FormSubmission::count();
```

### Metodi e Funzioni

#### ✅ METODI CON RESPONSABILITÀ SINGOLA

```php
// ✅ Buon esempio
public function createFormFromTemplate(Template $template, array $data): Form
{
    $this->validateTemplate($template);
    $form = $this->buildFormFromTemplate($template);
    $this->applyFormData($form, $data);
    $this->saveForm($form);
    
    return $form;
}

// ❌ Metodo che fa troppe cose
public function processForm($template, $data, $user, $notify = true)
{
    // Troppa logica in un solo metodo
}
```

### Struttura del Codice

#### ✅ ORGANIZZAZIONE LOGICA

```php
class FormBuilderService
{
    // 1. Proprietà pubbliche
    public string $name;
    
    // 2. Proprietà private
    private FormRepository $repository;
    
    // 3. Costruttore
    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }
    
    // 4. Metodi pubblici
    public function createForm(array $data): Form
    {
        // Implementazione
    }
    
    // 5. Metodi privati
    private function validateFormData(array $data): void
    {
        // Implementazione
    }
}
```

## Anti-pattern Comuni

### 1. Commenti Banali
- ❌ Commentare il nome della variabile
- ❌ Commentare operazioni ovvie
- ❌ Commentare il codice invece di renderlo autoesplicativo

### 2. Nomi Non Descrittivi
- ❌ Variabili con nomi generici (`$data`, `$item`, `$result`)
- ❌ Metodi con nomi vaghi (`process()`, `handle()`, `do()`)
- ❌ Abbreviazioni non standard

### 3. Metodi Troppo Lunghi
- ❌ Metodi con più di 20-30 righe
- ❌ Metodi con troppi parametri (>3-4)
- ❌ Metodi che fanno troppe cose

### 4. Duplicazione di Codice
- ❌ Copiare e incollare blocchi di codice
- ❌ Non estrarre logica comune in metodi
- ❌ Non utilizzare trait per funzionalità condivise

## Best Practices

### 1. Codice Autoesplicativo
```php
// ✅ Il codice si spiega da solo
$activeFormsForCurrentTenant = Form::where('tenant_id', $currentTenantId)
    ->where('is_active', true)
    ->get();

// ❌ Necessita commenti per essere compreso
$forms = Form::where('t_id', $tid)->where('active', 1)->get();
```

### 2. Estrazione di Metodi
```php
// ✅ Metodi piccoli e focalizzati
public function validateFormSubmission(FormSubmission $submission): void
{
    $this->validateSubmissionData($submission);
    $this->validateSubmissionPermissions($submission);
    $this->validateSubmissionTiming($submission);
}

// ❌ Metodo troppo lungo e complesso
public function validateSubmission($submission)
{
    // 50+ righe di validazione...
}
```

### 3. Utilizzo di Enum
```php
// ✅ Utilizzo di enum per chiarezza
if ($form->status === FormStatusEnum::ACTIVE) {
    // Logica per form attivo
}

// ❌ Magic numbers/strings
if ($form->status === 'active') {
    // Logica per form attivo
}
```

## Checklist Clean Code

Prima di committare, verificare:

- [ ] Nessun commento banale o ovvio
- [ ] Nomi di variabili e metodi descrittivi
- [ ] Metodi con responsabilità singola
- [ ] Nessuna duplicazione di codice
- [ ] Codice autoesplicativo
- [ ] Utilizzo appropriato di enum e costanti
- [ ] Struttura logica delle classi
- [ ] Gestione appropriata degli errori

## Riferimenti

- [Clean Code - Robert C. Martin](https://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350884)
- [PHP-FIG PSR Standards](https://www.php-fig.org/psr/)
- [Laravel Best Practices](https://laravel.com/docs/best-practices)