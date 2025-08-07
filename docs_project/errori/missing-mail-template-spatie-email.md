# Errore "MissingMailTemplate" - SpatieEmail Template Mancante

## Descrizione dell'Errore

**Errore**: `Spatie\\MailTemplates\\Exceptions\\MissingMailTemplate: No mail template exists for mailable 'SpatieEmail'`

**Contesto**: L'errore si verifica durante la registrazione di un paziente quando il sistema tenta di inviare una notifica email utilizzando `RecordNotification` con `SpatieEmail`.

**File coinvolto**: `Modules/SaluteOra/app/Actions/Patient/RegisterAction.php:63`

**Stack trace principale**:
```
Spatie\MailTemplates\Models\MailTemplate::findForMailable()
Spatie\MailTemplates\TemplateMailable::resolveTemplateModel()
```

## Analisi del Problema

### 🔍 **Conflitto Architetturale Template Resolution**

Il problema nasce da un **conflitto di timing** nella risoluzione dei template email:

1. **Spatie MailTemplates** cerca automaticamente un template nel database per il mailable `SpatieEmail`
2. **Ricerca iniziale**: Cerca con `mailable = 'Modules\\Notify\\Emails\\SpatieEmail'` e `slug = ''` (vuoto)
3. **Template non trovato**: Non trova il template perché la logica custom non è ancora stata eseguita
4. **Errore MissingMailTemplate**: Il sistema fallisce prima che il costruttore di `SpatieEmail` possa creare il template

### 📊 **Flusso Problematico Attuale**

```
RegisterAction
    ↓
$mail_slug = Str::slug($data['type'].'-'.$data['state']) // "patient-pending"
    ↓
new RecordNotification($patient, $mail_slug)
    ↓
RecordNotification->toMail() → new SpatieEmail($record, $slug)
    ↓
Spatie MailTemplates cerca template PRIMA del costruttore
    ↓
🚨 MissingMailTemplate Exception (template non esiste)
    ↓
❌ Costruttore SpatieEmail non viene mai eseguito
```

### 🕵️ **Query SQL dall'Errore**

```sql
-- Prima ricerca (fallisce)
SELECT * FROM `mail_templates` 
WHERE (`mailable` = 'Modules\Notify\Emails\SpatieEmail' AND `slug` = '') 
LIMIT 1

-- Tentativi di generazione slug automatici
SELECT EXISTS(SELECT * FROM `mail_templates` WHERE `slug` = '-1')
SELECT EXISTS(SELECT * FROM `mail_templates` WHERE `slug` = '-2') 
SELECT EXISTS(SELECT * FROM `mail_templates` WHERE `slug` = '-3')

-- Inserimento template fallback
INSERT INTO `mail_templates` (...) VALUES (..., 'SpatieEmail', '-3', ...)
```

## Cause Specifiche

### 1. **Logica Template Resolution di Spatie**
- Spatie MailTemplates cerca il template **prima** dell'esecuzione del costruttore
- Usa un processo di auto-discovery che non tiene conto della logica custom

### 2. **Implementazione SpatieEmail Custom**
```php
// Modules/Notify/app/Emails/SpatieEmail.php:30-37
public function __construct(Model $record, string $slug)
{
    $this->slug = Str::slug($slug);
    MailTemplate::firstOrCreate([
        'mailable' => SpatieEmail::class,
        'slug' => $this->slug,  // ✅ Slug corretto: "patient-pending"
    ], [
        'subject' => 'Benvenuto, {{ first_name }}',
        'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p>...',
        'text_template' => 'Gentile {{ first_name }} {{ last_name }}, ...'
    ]);
}
```

### 3. **Timing di Esecuzione**
- **Problema**: Spatie cerca template con `slug = ''` prima che `$this->slug` sia impostato
- **Aspettativa**: Template con `slug = 'patient-pending'` dovrebbe esistere

## Soluzioni Proposte

### 🚀 **Soluzione 1: Pre-popolazione Database Template (RACCOMANDATO)**

**Strategia**: Creare i template necessari durante la migrazione iniziale del database.

#### Implementazione

**1. Migrazione Template Email:**
```php
// database/migrations/YYYY_MM_DD_create_patient_email_templates.php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Notify\Models\MailTemplate;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Template per registrazione paziente pending
        MailTemplate::firstOrCreate([
            'mailable' => 'Modules\\Notify\\Emails\\SpatieEmail',
            'slug' => 'patient-pending',
        ], [
            'subject' => '{"it":"Registrazione in attesa - {{ first_name }}"}',
            'html_template' => '{"it":"<h2>Gentile {{ first_name }} {{ last_name }},</h2><p>La tua registrazione è stata ricevuta e è in attesa di approvazione da parte del nostro staff medico.</p><p>Ti contatteremo presto per confermare l\'attivazione del tuo account.</p><p>Grazie per aver scelto SaluteOra.</p>"}',
            'text_template' => '{"it":"Gentile {{ first_name }} {{ last_name }}, la tua registrazione è stata ricevuta e è in attesa di approvazione. Ti contatteremo presto."}',
            'params' => 'first_name,last_name,email,type,state'
        ]);

        // Template per registrazione paziente approvata
        MailTemplate::firstOrCreate([
            'mailable' => 'Modules\\Notify\\Emails\\SpatieEmail',
            'slug' => 'patient-active',
        ], [
            'subject' => '{"it":"Account attivato - Benvenuto {{ first_name }}"}',
            'html_template' => '{"it":"<h2>Benvenuto su SaluteOra, {{ first_name }}!</h2><p>Il tuo account è stato attivato con successo.</p><p>Ora puoi accedere alla piattaforma e prenotare i tuoi appuntamenti.</p>"}',
            'text_template' => '{"it":"Benvenuto su SaluteOra, {{ first_name }}! Il tuo account è stato attivato con successo."}',
            'params' => 'first_name,last_name,email,type,state'
        ]);

        // Template per registrazione dottore pending
        MailTemplate::firstOrCreate([
            'mailable' => 'Modules\\Notify\\Emails\\SpatieEmail',
            'slug' => 'doctor-pending',
        ], [
            'subject' => '{"it":"Registrazione medico in revisione - Dr. {{ last_name }}"}',
            'html_template' => '{"it":"<h2>Gentile Dr. {{ last_name }},</h2><p>La sua registrazione come medico è stata ricevuta ed è in fase di revisione.</p><p>Il nostro team verificherà le credenziali fornite e la contatterà entro 48 ore.</p>"}',
            'text_template' => '{"it":"Gentile Dr. {{ last_name }}, la sua registrazione è in fase di revisione. La contatteremo entro 48 ore."}',
            'params' => 'first_name,last_name,email,type,state'
        ]);

        echo "Template email SaluteOra creati con successo!\n";
    }
};
```

#### Vantaggi
- ✅ **Risolve completamente** l'errore MissingMailTemplate
- ✅ **Template pre-definiti** per tutti gli stati utente
- ✅ **Contenuto professionale** localizzato in italiano
- ✅ **Parametri documentati** per ogni template
- ✅ **Manutenibile** tramite interfaccia Filament

### 🔧 **Soluzione 2: Refactoring SpatieEmail Template Resolution**

**Strategia**: Modificare la logica di risoluzione template in `SpatieEmail` per gestire meglio il timing.

#### Implementazione

**1. Override del metodo `getMailTemplate()`:**
```php
// Modules/Notify/app/Emails/SpatieEmail.php
public function getMailTemplate()
{
    // Prima prova a cercare il template con il slug corretto
    $template = MailTemplate::where([
        'mailable' => static::class,
        'slug' => $this->slug,
    ])->first();

    if (!$template) {
        // Se non esiste, crealo con firstOrCreate
        $template = MailTemplate::firstOrCreate([
            'mailable' => static::class,
            'slug' => $this->slug,
        ], [
            'subject' => '{"it":"Notifica - {{ first_name }}"}',
            'html_template' => '{"it":"<p>Gentile {{ first_name }} {{ last_name }},</p><p>Questo è un messaggio automatico del sistema SaluteOra.</p>"}',
            'text_template' => '{"it":"Gentile {{ first_name }} {{ last_name }}, questo è un messaggio automatico del sistema SaluteOra."}',
        ]);
    }

    return $template;
}
```

**2. Rimozione logica dal costruttore:**
```php
public function __construct(Model $record, string $slug)
{
    $this->slug = Str::slug($slug);
    
    // Rimuovere firstOrCreate dal costruttore
    // La creazione del template è ora gestita in getMailTemplate()
    
    $data = $record->toArray();
    $this->data = array_merge($this->data, $data);
    $this->setAdditionalData($this->data);
}
```

#### Vantaggi
- ✅ **Risolve** l'errore di timing
- ✅ **Mantiene** la logica di auto-creazione template
- ⚠️ **Richiede testing** per verificare compatibilità con Spatie

### 🛠️ **Soluzione 3: Mailable Specifici per Contesto**

**Strategia**: Creare Mailable specifici per ogni tipo di notifica.

#### Implementazione

**1. PatientRegistrationMail:**
```php
// Modules/SaluteOra/app/Mail/PatientRegistrationMail.php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Mail;

use Spatie\MailTemplates\TemplateMailable;
use Modules\SaluteOra\Models\Patient;

class PatientRegistrationMail extends TemplateMailable
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $state
    ) {}

    public function getHtmlLayout(): string
    {
        $xot = \\Modules\\Xot\\Datas\\XotData::make();
        $pubThemePath = base_path('Themes/' . $xot->pub_theme);
        $pathToLayout = $pubThemePath . '/resources/mail-layouts/base.html';
        
        return file_get_contents($pathToLayout);
    }
}
```

**2. Template specifico:**
```php
// Migrazione per PatientRegistrationMail
MailTemplate::firstOrCreate([
    'mailable' => 'Modules\\SaluteOra\\Mail\\PatientRegistrationMail',
    'slug' => '', // Slug vuoto per mailable specifico
], [
    'subject' => '{"it":"Registrazione ricevuta - {{ first_name }}"}',
    'html_template' => '{"it":"<h2>Gentile {{ first_name }} {{ last_name }},</h2><p>La tua registrazione è stata ricevuta e sarà processata al più presto.</p>"}',
    'text_template' => '{"it":"Gentile {{ first_name }} {{ last_name }}, la tua registrazione è stata ricevuta."}',
]);
```

**3. Utilizzo in RegisterAction:**
```php
// Modules/SaluteOra/app/Actions/Patient/RegisterAction.php
use Modules\SaluteOra\Mail\PatientRegistrationMail;

// Sostituire:
// Notification::route('mail', $data['email'])
//     ->notify(new RecordNotification($patient, $mail_slug));

// Con:
Mail::to($data['email'])
    ->send(new PatientRegistrationMail(
        $patient->first_name,
        $patient->last_name,
        $patient->email,
        $patient->state->value
    ));
```

#### Vantaggi
- ✅ **Eliminazione completa** del conflitto template resolution
- ✅ **Type safety** migliorato
- ✅ **Separation of concerns** per ogni tipo di email
- ✅ **Testing semplificato**

### 🆘 **Soluzione 4: Workaround Immediato (TEMPORANEO)**

**Strategia**: Fix rapido per mettere in produzione subito.

#### Implementazione

**1. Creazione manuale template di fallback:**
```php
// Nel RegisterAction, prima della notifica:
\Modules\Notify\Models\MailTemplate::firstOrCreate([
    'mailable' => 'Modules\\Notify\\Emails\\SpatieEmail',
    'slug' => $mail_slug,
], [
    'subject' => '{"it":"Registrazione SaluteOra - {{ first_name }}"}',
    'html_template' => '{"it":"<p>Gentile {{ first_name }} {{ last_name }},</p><p>La sua registrazione è stata ricevuta.</p>"}',
    'text_template' => '{"it":"Gentile {{ first_name }} {{ last_name }}, la sua registrazione è stata ricevuta."}',
]);

Notification::route('mail', $data['email'])
    ->notify(new RecordNotification($patient, $mail_slug));
```

#### Vantaggi
- ✅ **Fix immediato** senza modifiche architetturali
- ⚠️ **Soluzione temporanea** - da sostituire con Soluzione 1

## Raccomandazioni Implementative

### 🎯 **Strategia Consigliata: Soluzione 1 + Soluzione 3**

1. **Fase 1**: Implementare **Soluzione 1** per fix immediato
2. **Fase 2**: Migrazione graduale a **Soluzione 3** per architettura migliore

### 📋 **Checklist Implementazione**

- [ ] Creare migrazione template email predefiniti
- [ ] Testare invio email per tutti gli stati utente (pending, active, rejected)
- [ ] Verificare traduzione italiana corretta
- [ ] Documentare parametri disponibili per ogni template
- [ ] Configurare template tramite interfaccia Filament MailTemplateResource
- [ ] Test regressione completo workflow registrazione
- [ ] Aggiornare documentazione modulo SaluteOra

### 🧪 **Test da Implementare**

```php
// Tests/Feature/EmailTemplateTest.php
public function test_patient_registration_email_template_exists()
{
    $template = MailTemplate::where([
        'mailable' => 'Modules\\Notify\\Emails\\SpatieEmail',
        'slug' => 'patient-pending',
    ])->first();

    $this->assertNotNull($template);
    $this->assertStringContains('{{ first_name }}', $template->html_template['it']);
}

public function test_patient_registration_sends_email_successfully()
{
    Mail::fake();

    // Simulare registrazione paziente
    $data = [
        'type' => 'patient',
        'state' => 'pending',
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@test.com',
        // ... altri campi
    ];

    $registerAction = new RegisterAction();
    $patient = $registerAction->execute(new User(), $data);

    Mail::assertSent(/* Verifica tipo email inviata */);
}
```

## Errori Correlati e Prevenzione

### 🔗 **Pattern Simili nel Codebase**

Controllare questi file per errori simili:
- `Modules/SaluteOra/app/Actions/Doctor/RegisterAction.php`
- Altri utilizzi di `RecordNotification` con `SpatieEmail`
- Template email dinamici nel modulo Notify

### 📚 **Best Practices per Template Email**

1. **Pre-popolazione database**: Sempre creare template necessari nelle migrazioni
2. **Naming convention**: Usare pattern `{type}-{state}` per slug template
3. **Localizzazione**: JSON structure per supporto multi-lingua
4. **Parametri documenti**: Sempre specificare parametri disponibili
5. **Testing completo**: Test automatizzati per ogni template

## Collegamenti

- [📧 Spatie Database Mail Templates](../../../Modules/Notify/docs/mail-templates/spatie-database-mail-templates.md)
- [🔔 RecordNotification Issue](notification_recordnotification_issue.md)
- [📝 Mail Template Implementation Guide](../../../Modules/Notify/docs/mail-templates/implementation_notes.md)
- [🎨 Email Templates Best Practices](../../../Modules/Notify/docs/mail-templates/email_templates_best_practices.md)

---

**Documentato**: 2025-06-26  
**Stato**: 🚨 **CRITICO** - Blocca workflow registrazione utente  
**Priorità**: **P0** - Fix immediato richiesto  
**Soluzione Raccomandata**: **Soluzione 1** (Pre-popolazione Database Template) 