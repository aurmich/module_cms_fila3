# Template Email per Registrazione Medici

## Overview

Il sistema utilizza diversi template email per gestire il flusso di registrazione e moderazione dei medici.

## Template Disponibili

### 1. Approvazione Registrazione
**File**: `doctor-approved.blade.php`

```blade
@component('mail::message')
# Registrazione Approvata

Gentile {{ $doctor->full_name }},

La sua registrazione è stata approvata. Per completare il processo, clicchi sul link seguente:

@component('mail::button', ['url' => $completionUrl])
Completa Registrazione
@endcomponent

Il link scadrà tra 7 giorni.

Cordiali saluti,
{{ config('app.name') }}
@endcomponent
```

### 2. Rifiuto Registrazione
**File**: `doctor-rejected.blade.php`

```blade
@component('mail::message')
# Registrazione Non Approvata

Gentile {{ $doctor->full_name }},

La sua registrazione non può essere approvata per il seguente motivo:

{{ $rejectionReason }}

Per riprovare la registrazione, clicchi qui:

@component('mail::button', ['url' => $retryUrl])
Nuova Registrazione
@endcomponent

Per assistenza, consulti le nostre FAQ o contatti il supporto.

Cordiali saluti,
{{ config('app.name') }}
@endcomponent
```

### 3. Richiesta Modifiche
**File**: `doctor-needs-changes.blade.php`

```blade
@component('mail::message')
# Modifiche Richieste

Gentile {{ $doctor->full_name }},

Per procedere con la sua registrazione, sono necessarie le seguenti modifiche:

@component('mail::panel')
{{ $changesRequired }}
@endcomponent

Per apportare le modifiche, clicchi qui:

@component('mail::button', ['url' => $editUrl])
Modifica Registrazione
@endcomponent

Ha 7 giorni per effettuare le modifiche richieste.

Cordiali saluti,
{{ config('app.name') }}
@endcomponent
```

## Variabili Disponibili

### Comuni a Tutti i Template
- `$doctor->full_name`: Nome completo del medico
- `config('app.name')`: Nome dell'applicazione
- `$supportEmail`: Email del supporto

### Template Specifiche

#### doctor-approved.blade.php
- `$completionUrl`: URL con token per completare registrazione
- `$tokenExpiresAt`: Data scadenza token
- `$nextStepInstructions`: Istruzioni per il prossimo step

#### doctor-rejected.blade.php
- `$rejectionReason`: Motivo del rifiuto
- `$retryUrl`: URL per nuova registrazione
- `$faqUrl`: URL delle FAQ

#### doctor-needs-changes.blade.php
- `$changesRequired`: Lista modifiche richieste
- `$editUrl`: URL per modificare registrazione
- `$deadline`: Deadline per le modifiche

## Stile e Formattazione

### Colori
```css
--primary: #0d6efd;
--success: #198754;
--danger: #dc3545;
--warning: #ffc107;
--info: #0dcaf0;
```

### Tipografia
- Font: `'Nunito', sans-serif`
- Dimensioni:
  - Titolo: 24px
  - Sottotitolo: 18px
  - Testo: 16px
  - Note: 14px

### Componenti
- Bottoni: Stile primario, centrati
- Pannelli: Bordi arrotondati, padding 16px
- Link: Colore primario, sottolineati hover

## Best Practices

1. **Contenuto**
   - Tono professionale ma amichevole
   - Istruzioni chiare e concise
   - Call to action evidenti
   - Informazioni di supporto

2. **Struttura**
   - Gerarchia visiva chiara
   - Spaziatura consistente
   - Sezioni ben definite
   - Responsive design

3. **Accessibilità**
   - Contrasto adeguato
   - Alt text per immagini
   - Link descrittivi
   - HTML semantico

4. **Localizzazione**
   - Testi in file di traduzione
   - Date localizzate
   - Formati numeri/valute
   - Supporto RTL

## Note Implementative

### Invio Email
```php
Mail::send(new DoctorRegistrationMail($doctor, $type));
```

### Markdown Rendering
```php
$markdown = new Markdown(view(), config('mail.markdown'));
return $markdown->render('emails.doctors.approved');
```

### Queue Configuration
```php
class DoctorRegistrationMail implements ShouldQueue
{
    public $tries = 3;
    public $timeout = 30;
}
```

## Collegamenti
- [Registration Workflow](doctor-registration-workflow.md)
- [Registration States](doctor-registration-states.md)
- [Email Configuration](../../Xot/docs/email-configuration.md)

## Vedi Anche
- [Laravel Mail](https://laravel.com/docs/mail)
- [Markdown Mail](https://laravel.com/docs/mail#markdown-mailables)
- [Queue Configuration](https://laravel.com/docs/queues) 