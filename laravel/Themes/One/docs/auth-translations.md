# Traduzioni di Autenticazione del Tema One

## Panoramica

Questo documento descrive il sistema di traduzioni per l'autenticazione nel tema One, includendo tutte le chiavi di traduzione disponibili, la struttura dei file e le best practices per l'implementazione.

## Struttura dei File di Traduzione Auth

Le traduzioni di autenticazione sono organizzate nei file:
- `/laravel/Themes/One/lang/it/auth.php`
- `/laravel/Themes/One/lang/en/auth.php`

### Struttura Completa delle Traduzioni

#### Login
```php
'login' => [
    'title' => 'Accedi al tuo account',
    'or' => 'oppure',
    'create_account' => 'crea un nuovo account',
    'forgot_password' => 'Hai dimenticato la password?',
    'back_to_login' => 'torna al login',
    'email' => 'Indirizzo email',
    'password' => 'Password',
    'remember_me' => 'Ricordami',
    'login_button' => 'Accedi',
],
```

#### Registrazione
```php
'register' => [
    'title' => 'Crea il tuo account',
    'welcome_message' => 'Benvenuto in <span class="font-bold">SaluteOra</span>',
    'description' => 'Crea il tuo account per accedere a tutti i servizi',
    'already_have_account' => 'Hai già un account?',
    'login_link' => 'accedi qui',
    'register_button' => 'Registrati',
],
```

#### Reset Password
```php
'password' => [
    'reset' => [
        'title' => 'Reimposta password',
        'description' => 'Inserisci il tuo indirizzo email per ricevere il link di reimpostazione password',
        'email_label' => 'Indirizzo email',
        'send_button' => 'Invia link reimpostazione password',
        'back_to_login' => 'torna al login',
        'or' => 'oppure',
        'email_sent' => 'Link di reimpostazione password inviato!',
    ],
    'confirm' => [
        'title' => 'Conferma password',
        'description' => 'Inserisci la tua password per confermare l\'identità',
    ],
    'new' => [
        'title' => 'Nuova password',
        'password_label' => 'Nuova password',
        'confirm_password_label' => 'Conferma nuova password',
        'update_button' => 'Aggiorna password',
    ],
],
```

#### Verifica Email
```php
'verify' => [
    'title' => 'Verifica il tuo account',
    'description' => 'Ti abbiamo inviato un\'email di verifica. Controlla la tua casella di posta.',
    'resend_button' => 'Invia nuovamente',
    'change_email' => 'Cambia indirizzo email',
],
```

#### Logout
```php
'logout' => [
    'title' => 'Disconnessione',
    'message' => 'Sei stato disconnesso con successo',
    'redirect_message' => 'Reindirizzamento in corso...',
],
```

#### Thank You Page
```php
'thank_you' => [
    'title' => 'Grazie per la registrazione',
    'message' => 'Il tuo account è stato creato con successo',
    'continue_button' => 'Continua',
],
```

#### Azioni e Stati
```php
'actions' => [
    'processing' => 'Elaborazione in corso...',
    'sending' => 'Invio in corso...',
    'refresh' => 'Ricarica pagina',
],
```

#### Gestione Errori
```php
'errors' => [
    'loading_failed' => 'Errore di caricamento',
    'please_refresh' => 'Si è verificato un errore. Ricarica la pagina e riprova.',
],
```

## Utilizzo nelle View

### Namespace delle Traduzioni

Il tema One utilizza il namespace `pub_theme::` per le traduzioni:

```php
{{ __('pub_theme::auth.login.title') }}
{{ __('pub_theme::auth.login.or') }}
{{ __('pub_theme::auth.login.create_account') }}
```

### Esempi di Implementazione

#### Login Page
```blade
<!-- resources/views/pages/auth/login.blade.php -->
<h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-[#272C4D]">
    {{ __('pub_theme::auth.login.title') }}
</h2>
<div class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
    <span>{{ __('pub_theme::auth.login.or') }}</span>
    <a href="{{ route('register') }}" class="text-[#FF5F7E] font-medium">
        {{ __('pub_theme::auth.login.create_account') }}
    </a>
</div>
```

#### Register Page
```blade
<!-- resources/views/pages/auth/register.blade.php -->
<h1 class="text-3xl font-light text-blue-900">
    {!! __('pub_theme::auth.register.welcome_message') !!}
</h1>
<p class="text-gray-600 mt-2">
    {{ __('pub_theme::auth.register.description') }}
</p>
```

#### Password Reset Page
```blade
<!-- resources/views/pages/auth/password/reset.blade.php -->
<h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-[#272C4D]">
    {{ __('pub_theme::auth.password.reset.title') }}
</h2>
<div class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
    <span>{{ __('pub_theme::auth.password.reset.or') }}</span>
    <x-ui.text-link href="{{ route('login') }}">
        {{ __('pub_theme::auth.password.reset.back_to_login') }}
    </x-ui.text-link>
</div>
```

## REGOLA CRITICA: Struttura Directory Blade

⚠️ **SEMPRE** seguire la gerarchia Laravel per i file di autenticazione:

### ✅ CORRETTO - Struttura Gerarchica
```
resources/views/pages/auth/
├── password/
│   ├── reset.blade.php        # /password/reset
│   ├── confirm.blade.php      # /password/confirm
│   └── [token].blade.php      # /password/reset/{token}
├── register.blade.php         # /register
├── login.blade.php           # /login
└── verify.blade.php          # /verify
```

### ❌ ERRATO - Nomi Piatti con Trattini
```
resources/views/pages/auth/
├── password-reset.blade.php   # ❌ Non segue convenzioni Laravel
├── password-confirm.blade.php # ❌ Non scalabile
└── password-email.blade.php   # ❌ Inconsistente con route
```

### Motivazioni
1. **Coerenza Route**: Laravel usa `/password/reset`, non `/password-reset`
2. **Coerenza Controller**: `Password\ResetController`, non `PasswordResetController`
3. **Organizzazione Logica**: Raggruppa funzionalità correlate (password)
4. **Scalabilità**: Facile aggiungere nuove funzionalità password
5. **Standard Laravel**: Convenzione ufficiale del framework

## Best Practices

### Struttura delle Traduzioni

1. **Gerarchia Chiara**: Organizzare le traduzioni in gruppi logici (login, register, password, etc.)
2. **Coerenza**: Utilizzare la stessa terminologia tra diverse sezioni
3. **Completezza**: Assicurarsi che tutte le stringhe abbiano traduzioni corrispondenti in entrambe le lingue

### Utilizzo HTML nelle Traduzioni

Per le traduzioni che contengono HTML (come `welcome_message`), utilizzare `{!! !!}` invece di `{{ }}`:

```blade
<!-- Corretto per HTML -->
{!! __('pub_theme::auth.register.welcome_message') !!}

<!-- Corretto per testo normale -->
{{ __('pub_theme::auth.login.title') }}
```

### Fallback e Gestione Errori

Il sistema utilizza il fallback automatico dalla lingua italiana all'inglese:

```php
// Se manca in italiano, usa inglese
{{ __('pub_theme::auth.login.title') }}
```

### Personalizzazione per Progetti Specifici

Se si desidera personalizzare le traduzioni per un progetto specifico:

1. **Non modificare** i file del tema direttamente
2. **Estendere** le traduzioni tramite il sistema di override di Laravel
3. **Documentare** tutte le personalizzazioni

## Manutenzione e Aggiornamenti

### Controllo Completezza

Per verificare che tutte le traduzioni siano complete:

```bash
# Confrontare i file di traduzione
diff -u lang/it/auth.php lang/en/auth.php
```

### Aggiunta di Nuove Traduzioni

Quando si aggiungono nuove traduzioni:

1. **Aggiornare entrambi i file** (italiano e inglese)
2. **Mantenere la struttura** coerente
3. **Testare** in entrambe le lingue
4. **Documentare** le modifiche

### Testing

Per testare le traduzioni:

```bash
# Pulire la cache delle traduzioni
php artisan cache:clear

# Testare il cambio di lingua
app()->setLocale('en');
app()->setLocale('it');
```

## Integrazione con il Sistema di Localizzazione

Le traduzioni auth si integrano con il sistema di localizzazione globale:

- **Middleware**: `SetLocale` gestisce la lingua corrente
- **Route**: Le route includono il parametro `{locale}`
- **Fallback**: Sistema automatico di fallback inglese → italiano

## Troubleshooting

### Problemi Comuni

1. **Traduzione non trovata**: Verificare il namespace `pub_theme::`
2. **HTML non renderizzato**: Usare `{!! !!}` invece di `{{ }}`
3. **Cache delle traduzioni**: Pulire la cache con `php artisan cache:clear`

### Debug

Per debuggare le traduzioni:

```php
// Verificare se esiste la traduzione
if (Lang::has('pub_theme::auth.login.title')) {
    echo "Traduzione trovata";
}

// Ottenere il percorso del file di traduzione
echo app('translator')->getLoader()->get(app()->getLocale(), 'auth', 'pub_theme');
```

## Collegamenti e Riferimenti

- [Sistema di Localizzazione](./i18n.md)
- [Configurazione Tema](../config/theme.php)
- [Documentazione Laravel Localization](https://laravel.com/docs/localization)
- [Best Practices Traduzioni](/docs/translation-standards.md)

## Fix Critico: Email Password Reset

### Problema Risolto
- **Errore**: "An email must have a 'To', 'Cc', or 'Bcc' header"
- **Causa**: `SpatieEmail` non aveva destinatario impostato
- **Soluzione**: Cambiato `setRecipient()` → `to()` in `UserServiceProvider`

### Correzione Implementata
```php
// ✅ FIX CRITICO in UserServiceProvider.php
if (method_exists($notifiable, 'getEmailForPasswordReset')) {
    $email->to($notifiable->getEmailForPasswordReset());
} elseif (isset($notifiable->email)) {
    $email->to($notifiable->email);
}
```

### Widget Namespace Corretto
- **Widget Auth**: `pub_theme::filament.widgets.auth.password.reset`
- **Motivazione**: Widget auth fanno parte dell'UX del tema
- **Regola**: Widget AUTH sempre `pub_theme::`, widget funzionali namespace modulo

## Cronologia Aggiornamenti

- **2024-12**: Implementazione iniziale traduzioni auth
- **2024-12**: Aggiunta traduzioni complete per login, register, password reset
- **2024-12**: Integrazione con sistema di localizzazione esistente
- **2024-12**: Correzione struttura directory auth (password-reset.blade.php → password/reset.blade.php)
- **2024-12**: Aggiunta sezioni azioni e gestione errori nelle traduzioni
- **2024-12**: Implementazione regola critica per struttura directory Laravel Auth
- **2024-12**: **FIX CRITICO**: Correzione email password reset - destinatario mancante
- **2024-12**: **CORREZIONE NAMESPACE**: Widget auth usano `pub_theme::` (non `user::`)

---

*Documento aggiornato: Dicembre 2024* 