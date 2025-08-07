# Documentazione Cookie Consent GDPR

## Panoramica
Il sistema di Cookie Consent utilizza `spatie/laravel-cookie-consent` per gestire il consenso degli utenti ai cookie in conformità con il GDPR.

## Configurazione

### 1. Configurazione Base
```php
// config/cookie-consent.php
return [
    'cookie_name' => 'gdpr_cookie_consent',
    'cookie_lifetime' => 60 * 24 * 365, // 1 anno in minuti
    
    'cookie_categories' => [
        'necessary' => [
            'required' => true,
            'enabled' => true,
            'description' => 'Cookie necessari per il funzionamento del sito',
        ],
        'analytics' => [
            'required' => false,
            'enabled' => false,
            'description' => 'Cookie per analisi statistiche',
        ],
        'marketing' => [
            'required' => false,
            'enabled' => false,
            'description' => 'Cookie per marketing e pubblicità',
        ],
    ],
    
    'cookie_policy_url' => '/cookie-policy',
    'privacy_policy_url' => '/privacy-policy',
];
```

### 2. Middleware
```php
// app/Http/Middleware/CookieConsent.php
class CookieConsent
{
    public function handle($request, Closure $next)
    {
        if (!$this->hasConsent($request)) {
            return $this->showConsentBanner($request);
        }
        
        return $next($request);
    }
}
```

## Implementazione

### 1. Service
```php
class CookieConsentService
{
    public function getConsentStatus(string $category): bool
    {
        return $this->getConsentData()[$category] ?? false;
    }
    
    public function setConsent(array $categories): void
    {
        $this->saveConsentData($categories);
        $this->applyConsent($categories);
    }
    
    protected function applyConsent(array $categories): void
    {
        foreach ($categories as $category => $enabled) {
            if ($enabled) {
                $this->enableCategory($category);
            } else {
                $this->disableCategory($category);
            }
        }
    }
}
```

### 2. Controller
```php
class CookieConsentController extends Controller
{
    public function show()
    {
        return view('gdpr::cookie-consent.banner', [
            'categories' => config('cookie-consent.cookie_categories'),
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'boolean',
        ]);
        
        app(CookieConsentService::class)->setConsent($validated['categories']);
        
        return response()->json(['success' => true]);
    }
}
```

## Interfaccia Utente

### 1. Banner
```blade
<!-- resources/views/gdpr/cookie-consent/banner.blade.php -->
<div class="cookie-consent-banner">
    <div class="cookie-consent-content">
        <h3>Gestione Cookie</h3>
        <p>Utilizziamo i cookie per migliorare la tua esperienza.</p>
        
        @foreach($categories as $category => $config)
            <div class="cookie-category">
                <label>
                    <input type="checkbox" 
                           name="categories[{{ $category }}]" 
                           {{ $config['required'] ? 'disabled checked' : '' }}
                           {{ $config['enabled'] ? 'checked' : '' }}>
                    {{ $config['description'] }}
                </label>
            </div>
        @endforeach
        
        <div class="cookie-consent-actions">
            <button class="accept-all">Accetta Tutto</button>
            <button class="save-preferences">Salva Preferenze</button>
        </div>
    </div>
</div>
```

### 2. JavaScript
```javascript
// resources/js/cookie-consent.js
class CookieConsent {
    constructor() {
        this.banner = document.querySelector('.cookie-consent-banner');
        this.form = this.banner.querySelector('form');
        this.initialize();
    }
    
    initialize() {
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
        this.banner.querySelector('.accept-all')
            .addEventListener('click', this.acceptAll.bind(this));
    }
    
    async handleSubmit(event) {
        event.preventDefault();
        const formData = new FormData(this.form);
        
        try {
            await fetch('/cookie-consent', {
                method: 'POST',
                body: formData
            });
            
            this.hideBanner();
        } catch (error) {
            console.error('Errore nel salvataggio delle preferenze:', error);
        }
    }
    
    acceptAll() {
        const checkboxes = this.form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = true);
        this.handleSubmit(new Event('submit'));
    }
    
    hideBanner() {
        this.banner.style.display = 'none';
    }
}
```

## Sicurezza

### 1. Validazione
```php
class CookieConsentValidator
{
    public function validateConsent(array $categories): bool
    {
        $config = config('cookie-consent.cookie_categories');
        
        foreach ($categories as $category => $enabled) {
            if (!isset($config[$category])) {
                return false;
            }
            
            if ($config[$category]['required'] && !$enabled) {
                return false;
            }
        }
        
        return true;
    }
}
```

### 2. Cifratura
```php
class CookieConsentEncryption
{
    public function encryptConsent(array $categories): string
    {
        return encrypt(json_encode($categories));
    }
    
    public function decryptConsent(string $encrypted): array
    {
        return json_decode(decrypt($encrypted), true);
    }
}
```

## Monitoraggio

### 1. Analytics
```php
class CookieConsentAnalytics
{
    public function trackConsent(array $categories): void
    {
        $this->logConsent($categories);
        $this->updateStatistics($categories);
    }
    
    protected function logConsent(array $categories): void
    {
        activity()
            ->withProperties(['categories' => $categories])
            ->log('cookie_consent_updated');
    }
}
```

## Manutenzione

### 1. Pulizia
```php
class CookieConsentCleanup
{
    public function cleanupExpiredConsents(): void
    {
        $expired = $this->getExpiredConsents();
        
        foreach ($expired as $consent) {
            $this->deleteConsent($consent);
        }
    }
}
```

## Best Practices

### 1. Implementazione
- Banner chiaro e comprensibile
- Categorie ben definite
- Opzioni di scelta chiare
- Salvataggio sicuro delle preferenze

### 2. Sicurezza
- Validazione dei dati
- Cifratura delle preferenze
- Protezione CSRF
- Logging delle modifiche

### 3. UX
- Design responsive
- Animazioni fluide
- Messaggi chiari
- Facile accesso alle impostazioni

## Collegamenti
- [Documentazione ufficiale](https://spatie.be/docs/laravel-cookie-consent)
- [Architettura](../architecture.md)
- [Sviluppo](../development.md) 

## Collegamenti tra versioni di cookie-consent.md
* [cookie-consent.md](laravel/Modules/Gdpr/docs/packages/cookie-consent.md)
* [cookie-consent.md](laravel/Modules/Gdpr/docs/roadmap/cookie-consent.md)

