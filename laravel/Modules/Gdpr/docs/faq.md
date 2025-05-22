# FAQ Modulo GDPR

## Generale

### Cos'è il modulo GDPR?
Il modulo GDPR fornisce gli strumenti necessari per gestire la conformità al Regolamento Generale sulla Protezione dei Dati dell'UE all'interno dell'applicazione il progetto.

### Quali sono le principali funzionalità?
- Gestione consensi utenti
- Esportazione dati personali
- Registro dei trattamenti
- Valutazioni d'impatto (DPIA)
- Log delle attività
- Dashboard privacy

## Installazione

### Come si installa il modulo?
```bash
composer require modules/gdpr
php artisan module:enable Gdpr
php artisan migrate --path=Modules/Gdpr/Database/Migrations
```

### Quali sono i requisiti minimi?
- PHP >= 8.2
- Laravel >= 10.0
- Modulo Xot installato
- Modulo User installato
- Modulo Activity installato

## Configurazione

### Come configurare i periodi di retention?
Nel file `config/gdpr.php`:
```php
return [
    'retention_period' => env('GDPR_RETENTION_PERIOD', 30),
    'consent_lifetime' => env('GDPR_CONSENT_LIFETIME', 365),
];
```

### Come personalizzare i template email?
1. Pubblicare le views:
```bash
php artisan vendor:publish --tag=gdpr-views
```
2. Modificare i file in `resources/views/vendor/gdpr/emails/`

## Consensi

### Come implementare il form di consenso?
```php
use Modules\Gdpr\Traits\HasGdprConsent;

class User extends XotBaseUser
{
    use HasGdprConsent;
}
```

### Come verificare un consenso?
```php
if ($user->hasValidConsent('marketing')) {
    // Procedi con le operazioni
}
```

## Esportazione Dati

### In quali formati è possibile esportare i dati?
- JSON
- CSV
- PDF
- XML (richiede configurazione aggiuntiva)

### Come gestire grandi quantità di dati?
Utilizzare il job di esportazione:
```php
ProcessDataExport::dispatch($user, 'json');
```

## Sicurezza

### Come sono protetti i dati sensibili?
- Crittografia a riposo
- Crittografia in transito
- Validazione input
- Rate limiting
- Audit logging

### Come gestire le violazioni dei dati?
1. Registrazione automatica nel log
2. Notifica DPO
3. Valutazione impatto
4. Notifica interessati se necessario

## Performance

### Come ottimizzare le query dei consensi?
```php
// ❌ NON FARE QUESTO
$users = User::all();
foreach ($users as $user) {
    $consents = $user->consents;
}

// ✅ FARE QUESTO
$users = User::with('consents')->get();
```

### Come gestire il caching?
```php
$consent = Cache::remember(
    "user.{$user->id}.consent.marketing",
    3600,
    fn() => $user->hasValidConsent('marketing')
);
```

## Testing

### Come testare i consensi?
```php
/** @test */
public function it_can_check_valid_consent(): void
{
    $user = User::factory()->create();
    $consent = Consent::factory()->create([
        'user_id' => $user->id,
        'type' => 'marketing',
        'value' => true,
    ]);

    $this->assertTrue($user->hasValidConsent('marketing'));
}
```

### Come simulare l'esportazione dati nei test?
```php
/** @test */
public function it_can_export_user_data(): void
{
    Storage::fake('local');
    
    $user = User::factory()->create();
    ProcessDataExport::dispatch($user, 'json');
    
    Storage::disk('local')->assertExists("exports/user-{$user->id}.json");
}
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [FAQ User](../User/docs/faq.md)
- [FAQ Activity](../Activity/docs/faq.md)
- [FAQ Xot](../Xot/docs/faq.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Configurazione](./configuration.md)
- [Testing](./testing.md) 