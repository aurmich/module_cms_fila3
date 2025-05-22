# Sistema di Email Template

## Introduzione

Il modulo Notify implementa un sistema avanzato di gestione delle email template basato su [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates). Questo sistema permette di gestire e personalizzare facilmente i template delle email direttamente dal database.

## Struttura del Sistema

### Componenti Principali

1. **SpatieEmail** (`app/Emails/SpatieEmail.php`)
   - Classe base per l'invio di email template
   - Gestisce il layout HTML e i dati aggiuntivi
   - Supporta la personalizzazione del layout
   - Supporta l'identificazione dei template tramite slug

2. **MailTemplate** (`app/Models/MailTemplate.php`)
   - Model per la gestione dei template nel database
   - Supporta traduzioni multilingua
   - Gestisce versioni dei template
   - Traccia i log delle email inviate
   - Include identificatore slug per i template

### Database

La tabella `mail_templates` contiene:
- `mailable`: Classe Mailable associata
- `subject`: Oggetto dell'email (traducibile)
- `html_template`: Template HTML (traducibile)
- `text_template`: Template testo (traducibile)
- `version`: Versione corrente del template
- `slug`: Identificatore univoco del template

## Utilizzo Pratico

### 1. Creazione di un Template Email

```php
// Esempio: Template Email di Benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'welcome-email',
    'subject' => [
        'it' => 'Benvenuto, {{ first_name }}!',
        'en' => 'Welcome, {{ first_name }}!'
    ],
    'html_template' => [
        'it' => '
            <h1>Benvenuto!</h1>
            <p>Ciao {{ first_name }},</p>
            <p>Grazie per esserti registrato.</p>
            <p>Puoi accedere al tuo account utilizzando le credenziali che hai fornito.</p>
        ',
        'en' => '
            <h1>Welcome!</h1>
            <p>Hello {{ first_name }},</p>
            <p>Thank you for registering.</p>
            <p>You can access your account using the credentials you provided.</p>
        '
    ]
]);

// Esempio: Template Email per Completamento Registrazione
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'complete-registration',
    'subject' => [
        'it' => 'Completa la tua registrazione',
        'en' => 'Complete your registration'
    ],
    'html_template' => [
        'it' => '
            <h1>Completa la tua registrazione</h1>
            <p>Gentile {{ last_name }},</p>
            <p>Per completare la registrazione del tuo account, clicca sul link sottostante:</p>
            <p><a href="{{ registration_link }}">Completa Registrazione</a></p>
            <p>Il link scadrà tra 24 ore.</p>
        ',
        'en' => '
            <h1>Complete your registration</h1>
            <p>Dear {{ last_name }},</p>
            <p>To complete your account registration, click the link below:</p>
            <p><a href="{{ registration_link }}">Complete Registration</a></p>
            <p>The link will expire in 24 hours.</p>
        '
    ]
]);
```

### 2. Invio di Email

```php
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

// Email di benvenuto usando lo slug
$user = User::find(1);
Mail::to($user->email)->send(new SpatieEmail($user, 'welcome-email'));

// Email per completamento registrazione usando lo slug
$user = User::find(1);
$user->registration_link = route('complete-registration', ['token' => $token]);
Mail::to($user->email)->send(new SpatieEmail($user, 'complete-registration'));
```

### 3. Personalizzazione del Layout

Per personalizzare il layout HTML delle email, modifica il metodo `getHtmlLayout()` in `SpatieEmail`:

```php
public function getHtmlLayout(): string
{
    return view('emails.layouts.main', [
        'siteName' => config('app.name'),
        'year' => date('Y')
    ])->render();
}
```

## Best Practices

1. **Gestione delle Versioni**
   - Utilizzare il sistema di versioning per tracciare le modifiche ai template
   - Documentare le modifiche significative
   - Mantenere lo slug costante tra le versioni

2. **Traduzioni**
   - Mantenere sempre le traduzioni in italiano e inglese
   - Utilizzare chiavi di traduzione coerenti
   - Utilizzare lo slug come chiave di traduzione quando appropriato

3. **Variabili nei Template**
   - Utilizzare nomi descrittivi per le variabili
   - Documentare tutte le variabili disponibili
   - Validare la presenza delle variabili richieste

4. **Testing**
   - Testare i template con dati reali
   - Verificare il rendering in diversi client email
   - Controllare le traduzioni in tutte le lingue supportate

5. **Gestione degli Slug**
   - Utilizzare kebab-case per gli slug
   - Mantenere gli slug brevi e descrittivi
   - Evitare caratteri speciali
   - Verificare l'unicità degli slug

## Esempi di Template Comuni

### 1. Conferma Appuntamento

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'appointment-confirmation',
    'subject' => [
        'it' => 'Conferma Appuntamento: {{ appointment_date }}',
        'en' => 'Appointment Confirmation: {{ appointment_date }}'
    ],
    'html_template' => [
        'it' => '
            <h1>Conferma Appuntamento</h1>
            <p>Gentile {{ first_name }},</p>
            <p>Il tuo appuntamento è stato confermato per il {{ appointment_date }} alle {{ appointment_time }}.</p>
            <p>Dottore: {{ doctor_name }}</p>
            <p>Servizio: {{ service_name }}</p>
            <p>Per modificare o cancellare l\'appuntamento, accedi al tuo account.</p>
        '
    ]
]);
```

### 2. Promemoria Appuntamento

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'appointment-reminder',
    'subject' => [
        'it' => 'Promemoria: Appuntamento domani',
        'en' => 'Reminder: Appointment tomorrow'
    ],
    'html_template' => [
        'it' => '
            <h1>Promemoria Appuntamento</h1>
            <p>Gentile {{ first_name }},</p>
            <p>Ti ricordiamo il tuo appuntamento di domani:</p>
            <p>Data: {{ appointment_date }}</p>
            <p>Ora: {{ appointment_time }}</p>
            <p>Dottore: {{ doctor_name }}</p>
            <p>Servizio: {{ service_name }}</p>
        '
    ]
]);
```

## Troubleshooting

### Problemi Comuni

1. **Template non trovato**
   - Verificare che il template esista nel database
   - Controllare che la classe Mailable sia corretta

2. **Variabili mancanti**
   - Assicurarsi che tutti i dati necessari siano passati al costruttore
   - Verificare i nomi delle variabili nel template

3. **Problemi di traduzione**
   - Controllare che tutte le traduzioni necessarie siano presenti
   - Verificare la configurazione della lingua corrente

## Collegamenti Correlati

- [Documentazione Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Gestione Traduzioni](../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Configurazione Email](../../../docs/email-configuration.md)
- [Documentazione Traduzioni](./translations.md)
- [Proposta Slug Template](./EMAIL_TEMPLATE_SLUG_PROPOSAL.md)
- [Notify Module Index](./INDEX.md)
- [Architecture Overview](./ARCHITECTURE.md)
- [Notification Channels Implementation](./NOTIFICATION_CHANNELS_IMPLEMENTATION.md)
- [SMS Implementation](./SMS_IMPLEMENTATION.md)
- [Troubleshooting](./TROUBLESHOOTING.md)
