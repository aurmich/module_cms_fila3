# Documentazione Privacy Policy GDPR

## Panoramica
Il sistema di Privacy Policy gestisce la documentazione e il consenso degli utenti alla privacy policy in conformità con il GDPR.

## Configurazione

### 1. Configurazione Base
```php
// config/privacy-policy.php
return [
    'version' => '1.0.0',
    'last_updated' => '2024-01-01',
    'required_consent' => true,
    
    'sections' => [
        'introduction' => [
            'title' => 'Introduzione',
            'required' => true,
        ],
        'data_collection' => [
            'title' => 'Raccolta Dati',
            'required' => true,
        ],
        'data_usage' => [
            'title' => 'Utilizzo Dati',
            'required' => true,
        ],
        'data_protection' => [
            'title' => 'Protezione Dati',
            'required' => true,
        ],
        'user_rights' => [
            'title' => 'Diritti Utente',
            'required' => true,
        ],
    ],
    
    'consent_storage' => [
        'driver' => 'database',
        'table' => 'privacy_policy_consents',
    ],
];
```

### 2. Database
```php
// database/migrations/2024_01_01_create_privacy_policy_consents_table.php
Schema::create('privacy_policy_consents', function (Blueprint $table) {
    $table->id();
    $table->morphs('consentable');
    $table->string('version');
    $table->json('sections_consented');
    $table->timestamp('consented_at');
    $table->timestamps();
    
    $table->index(['consentable_type', 'consentable_id']);
});
```

## Implementazione

### 1. Service
```php
class PrivacyPolicyService
{
    public function getCurrentVersion(): string
    {
        return config('privacy-policy.version');
    }
    
    public function hasConsent($user, string $version = null): bool
    {
        $version = $version ?? $this->getCurrentVersion();
        
        return $this->getConsent($user, $version) !== null;
    }
    
    public function recordConsent($user, array $sections): void
    {
        $consent = new PrivacyPolicyConsent([
            'version' => $this->getCurrentVersion(),
            'sections_consented' => $sections,
            'consented_at' => now(),
        ]);
        
        $user->privacyPolicyConsents()->save($consent);
        
        event(new PrivacyPolicyConsentUpdated($user, $consent));
    }
}
```

### 2. Controller
```php
class PrivacyPolicyController extends Controller
{
    public function show()
    {
        return view('gdpr::privacy-policy.show', [
            'version' => app(PrivacyPolicyService::class)->getCurrentVersion(),
            'sections' => config('privacy-policy.sections'),
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'boolean',
        ]);
        
        app(PrivacyPolicyService::class)->recordConsent(
            $request->user(),
            $validated['sections']
        );
        
        return response()->json(['success' => true]);
    }
}
```

## Interfaccia Utente

### 1. Template
```blade
<!-- resources/views/gdpr/privacy-policy/show.blade.php -->
<div class="privacy-policy">
    <div class="privacy-policy-header">
        <h1>Informativa sulla Privacy</h1>
        <p>Ultimo aggiornamento: {{ $last_updated }}</p>
    </div>
    
    <div class="privacy-policy-content">
        @foreach($sections as $section => $config)
            <div class="privacy-policy-section">
                <h2>{{ $config['title'] }}</h2>
                <div class="section-content">
                    @include("gdpr::privacy-policy.sections.{$section}")
                </div>
                
                @if(!$config['required'])
                    <div class="section-consent">
                        <label>
                            <input type="checkbox" 
                                   name="sections[{{ $section }}]"
                                   {{ $config['required'] ? 'disabled checked' : '' }}>
                            Accetto questa sezione
                        </label>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <div class="privacy-policy-actions">
        <button type="submit" class="accept-all">Accetta Tutto</button>
        <button type="submit" class="save-preferences">Salva Preferenze</button>
    </div>
</div>
```

### 2. JavaScript
```javascript
// resources/js/privacy-policy.js
class PrivacyPolicy {
    constructor() {
        this.form = document.querySelector('.privacy-policy');
        this.initialize();
    }
    
    initialize() {
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
        this.form.querySelector('.accept-all')
            .addEventListener('click', this.acceptAll.bind(this));
    }
    
    async handleSubmit(event) {
        event.preventDefault();
        const formData = new FormData(this.form);
        
        try {
            await fetch('/privacy-policy/consent', {
                method: 'POST',
                body: formData
            });
            
            this.showSuccess();
        } catch (error) {
            this.showError(error);
        }
    }
    
    acceptAll() {
        const checkboxes = this.form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = true);
        this.handleSubmit(new Event('submit'));
    }
}
```

## Sicurezza

### 1. Validazione
```php
class PrivacyPolicyValidator
{
    public function validateConsent(array $sections): bool
    {
        $config = config('privacy-policy.sections');
        
        foreach ($sections as $section => $consented) {
            if (!isset($config[$section])) {
                return false;
            }
            
            if ($config[$section]['required'] && !$consented) {
                return false;
            }
        }
        
        return true;
    }
}
```

### 2. Cifratura
```php
class PrivacyPolicyEncryption
{
    public function encryptConsent(array $sections): string
    {
        return encrypt(json_encode($sections));
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
class PrivacyPolicyAnalytics
{
    public function trackConsent($user, array $sections): void
    {
        $this->logConsent($user, $sections);
        $this->updateStatistics($sections);
    }
    
    protected function logConsent($user, array $sections): void
    {
        activity()
            ->performedOn($user)
            ->withProperties(['sections' => $sections])
            ->log('privacy_policy_consent_updated');
    }
}
```

## Manutenzione

### 1. Versionamento
```php
class PrivacyPolicyVersioning
{
    public function createNewVersion(array $changes): string
    {
        $version = $this->incrementVersion();
        
        $this->createVersionDocument($version, $changes);
        $this->notifyUsers($version);
        
        return $version;
    }
    
    protected function notifyUsers(string $version): void
    {
        User::whereDoesntHave('privacyPolicyConsents', function ($query) use ($version) {
            $query->where('version', $version);
        })->chunk(100, function ($users) use ($version) {
            foreach ($users as $user) {
                $user->notify(new PrivacyPolicyUpdateNotification($version));
            }
        });
    }
}
```

## Best Practices

### 1. Implementazione
- Documentazione chiara e comprensibile
- Sezioni ben strutturate
- Versionamento automatico
- Notifiche agli utenti

### 2. Sicurezza
- Validazione dei dati
- Cifratura delle preferenze
- Protezione CSRF
- Logging delle modifiche

### 3. UX
- Design responsive
- Navigazione intuitiva
- Messaggi chiari
- Facile accesso alla documentazione

## Collegamenti
- [Architettura](../architecture.md)
- [Sviluppo](../development.md) 
