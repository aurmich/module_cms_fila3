# Missing Mail Template - Errore SpatieEmail nella Registrazione Pazienti

## 🚨 Errore Critico Identificato

**Data**: 26 Giugno 2025  
**Contesto**: Registrazione paziente tramite `RegistrationWidget`  
**File coinvolto**: `Modules\SaluteOra\Actions\Patient\RegisterAction.php`  
**Linea**: 63  
**Tipo errore**: `Spatie\MailTemplates\Exceptions\MissingMailTemplate`  

## Descrizione dell'Errore

```
Spatie\MailTemplates\Exceptions\MissingMailTemplate
No mail template exists for mailable `SpatieEmail`.
```

### Stack Trace Principale

```
Spatie\MailTemplates\Exceptions\MissingMailTemplate :14 forMailable
Spatie\MailTemplates\Models\MailTemplate :25 findForMailable 
Spatie\MailTemplates\TemplateMailable :35 resolveTemplateModel
Spatie\MailTemplates\TemplateMailable :30 getMailTemplate
[...]
Modules\SaluteOra\Actions\Patient\RegisterAction :63
```

### Codice Problematico

```php
// RegisterAction.php - Linea 63
$mail_slug = Str::slug($data['type'].'-'.$data['state']); // es: "patient-pending"

Notification::route('mail', $data['email'])
    ->notify(new RecordNotification($patient, $mail_slug));
```

## Analisi Tecnica del Problema

### 1. **Flusso dell'Errore**

1. `RegisterAction` genera slug dinamico: `"patient-pending"`
2. `RecordNotification` passa slug a `SpatieEmail`
3. `SpatieEmail` constructor usa `firstOrCreate` per creare template
4. **Problema**: Package Spatie cerca template con slug **vuoto** invece del slug generato
5. Query fallisce: `WHERE mailable = 'SpatieEmail' AND slug = ''`

### 2. **Cause Identificate**

#### **Causa Principale: Timing del firstOrCreate**
Il metodo `firstOrCreate` in `SpatieEmail` constructor può fallire in condizioni di concorrenza:

```php
// SpatieEmail.php - Constructor problematico
MailTemplate::firstOrCreate([
    'mailable' => SpatieEmail::class,
    'slug' => $this->slug,  // Può essere vuoto o non settato correttamente
],[
    'subject' => 'Benvenuto, {{ first_name }}',
    // ...
]);
```

#### **Causa Secondaria: Gestione Slug Inconsistente**
- Slug generato dinamicamente: `Str::slug($data['type'].'-'.$data['state'])`
- Non c'è validazione che lo slug sia valido
- Non c'è fallback per slug vuoti o null

#### **Causa Terziaria: Database Connection**
Il modello `MailTemplate` usa `protected $connection = 'notify'` che potrebbe causare problemi di connessione cross-database.

## 📋 Soluzioni Documentate

### **Soluzione 1: Fix Immediato - Pre-creazione Template** ⭐ **RACCOMANDATO**

Creare i template necessari tramite seeder o migration:

```php
// Database/Seeders/MailTemplatesSeeder.php
class MailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            'patient-pending' => [
                'subject' => ['it' => 'Registrazione in attesa di approvazione'],
                'html_template' => ['it' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione è in attesa di approvazione.</p>'],
                'text_template' => ['it' => 'La tua registrazione è in attesa di approvazione.']
            ],
            'patient-active' => [
                'subject' => ['it' => 'Account attivato con successo'],
                'html_template' => ['it' => '<p>Gentile {{ first_name }},</p><p>Il tuo account è stato attivato.</p>'],
                'text_template' => ['it' => 'Il tuo account è stato attivato.']
            ],
            'doctor-pending' => [
                'subject' => ['it' => 'Registrazione dottore in verifica'],
                'html_template' => ['it' => '<p>Gentile Dr. {{ last_name }},</p><p>Stiamo verificando la sua registrazione.</p>'],
                'text_template' => ['it' => 'Stiamo verificando la sua registrazione.']
            ]
        ];

        foreach ($templates as $slug => $content) {
            MailTemplate::updateOrCreate([
                'mailable' => 'Modules\Notify\Emails\SpatieEmail',
                'slug' => $slug,
            ], [
                'subject' => json_encode($content['subject']),
                'html_template' => json_encode($content['html_template']),
                'text_template' => json_encode($content['text_template']),
            ]);
        }
    }
}
```

**Pro**: 
- Soluzione immediata e stabile
- Template predefiniti garantiti
- Nessuna modifica al codice esistente

**Contro**: 
- Richiede manutenzione dei template
- Dati hardcoded nel seeder

### **Soluzione 2: Miglioramento RegisterAction - Validazione Slug**

```php
// RegisterAction.php - Versione migliorata
public function execute(UserContract $record, array $data): Patient
{
    return DB::transaction(function () use ($data) {
        // ... codice esistente ...

        // ✅ Generazione slug con validazione
        $mail_slug = $this->generateValidSlug($data);
        
        // ✅ Verifica template prima dell'invio
        $this->ensureTemplateExists($mail_slug);

        Notification::route('mail', $data['email'])
            ->notify(new RecordNotification($patient, $mail_slug));

        return $patient;
    });
}

private function generateValidSlug(array $data): string
{
    $type = $data['type'] ?? 'user';
    $state = $data['state'] ?? 'pending';
    
    $slug = Str::slug($type . '-' . $state);
    
    // ✅ Fallback per slug vuoti
    if (empty($slug)) {
        $slug = 'default-notification';
    }
    
    return $slug;
}

private function ensureTemplateExists(string $slug): void
{
    $exists = MailTemplate::where('mailable', 'Modules\Notify\Emails\SpatieEmail')
        ->where('slug', $slug)
        ->exists();
        
    if (!$exists) {
        // ✅ Crea template di fallback
        MailTemplate::create([
            'mailable' => 'Modules\Notify\Emails\SpatieEmail',
            'slug' => $slug,
            'subject' => json_encode(['it' => 'Notifica da SaluteOra']),
            'html_template' => json_encode(['it' => '<p>Gentile {{ first_name }},</p><p>Grazie per la registrazione.</p>']),
            'text_template' => json_encode(['it' => 'Grazie per la registrazione.'])
        ]);
    }
}
```

### **Soluzione 3: Refactoring SpatieEmail - Gestione Slug Migliorata**

```php
// SpatieEmail.php - Constructor migliorato
public function __construct(Model $record, string $slug)
{
    $this->slug = Str::slug($slug);
    
    // ✅ Validazione slug vuoto
    if (empty($this->slug)) {
        $this->slug = 'default-email';
    }
    
    // ✅ Try-catch per firstOrCreate
    try {
        $template = MailTemplate::firstOrCreate([
            'mailable' => SpatieEmail::class,
            'slug' => $this->slug,
        ], [
            'subject' => json_encode(['it' => 'Notifica da {{ app_name }}']),
            'html_template' => json_encode(['it' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>{{ message }}</p>']),
            'text_template' => json_encode(['it' => 'Gentile {{ first_name }} {{ last_name }}, {{ message }}'])
        ]);
        
        if (!$template) {
            throw new \Exception("Impossibile creare template per slug: {$this->slug}");
        }
        
    } catch (\Exception $e) {
        \Log::error('SpatieEmail template creation failed', [
            'slug' => $this->slug,
            'error' => $e->getMessage(),
            'record_type' => get_class($record),
            'record_id' => $record->id ?? null
        ]);
        
        // ✅ Fallback su template generico
        $this->slug = 'default-email';
        MailTemplate::firstOrCreate([
            'mailable' => SpatieEmail::class,
            'slug' => 'default-email',
        ], [
            'subject' => json_encode(['it' => 'Notifica da SaluteOra']),
            'html_template' => json_encode(['it' => '<p>Notifica dal sistema.</p>']),
            'text_template' => json_encode(['it' => 'Notifica dal sistema.'])
        ]);
    }
    
    $data = $record->toArray();
    $this->data = array_merge($this->data, $data);
    $this->setAdditionalData($this->data);
}
```

## 🔧 Step di Implementazione Raccomandati

### **Fase 1: Fix Immediato (Priorità URGENT)**

1. **Creare MailTemplatesSeeder** con template base
2. **Eseguire seeder**: `php artisan db:seed --class=MailTemplatesSeeder`
3. **Verificare template creati**

### **Fase 2: Miglioramento Robusto (Priorità HIGH)**

1. **Modificare RegisterAction** con validazione slug
2. **Aggiungere logging** per troubleshooting
3. **Implementare test automatizzati**

## 🚨 Impatti e Rischi

### **Impatto Corrente**
- ❌ **Sistema di registrazione pazienti BLOCCATO**
- ❌ **Nessuna email di conferma inviata**
- ❌ **Utenti non ricevono credenziali o link di attivazione**

### **Rischi Operativi**
- **Perdita di fiducia** degli utenti nel sistema
- **Carico di lavoro manuale** per contattare pazienti registrati
- **Problemi di compliance** per gestione dati personali

## 📝 Documentazione Correlata

- [notification_recordnotification_issue.md](./notification_recordnotification_issue.md) - Problema correlato
- [Notify: Email Templates](../../Notify/docs/email_templates.md) - Sistema di template
- [Notify: Spatie Email Usage Guide](../../Notify/docs/spatie_email_usage_guide.md) - Guida utilizzo

---

**Ultimo aggiornamento**: 26 Giugno 2025  
**Status**: URGENT - Sistema registrazione bloccato  
**Priorità**: P0 - Fix immediato richiesto  