# Integrazione Bolt Form Builder - Modulo SaluteOra

## Panoramica

Il modulo SaluteOra integra Lara Zeus Bolt come form builder dinamico per gestire form personalizzabili per pazienti, dottori e amministratori.

## Architettura Integrazione

### Principi Fondamentali
- **Modularità**: Bolt opera come plugin indipendente del panel SaluteOra
- **Flessibilità**: Form configurabili attraverso interfaccia admin
- **Sicurezza**: Integrazione con sistema di autenticazione e autorizzazione esistente

### Componenti Principali

#### 1. Plugin Registration
Il plugin Bolt viene registrato nell'`AdminPanelProvider` del modulo:

```php
// Modules/SaluteOra/app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    $boltPlugin = BoltPlugin::make()
        ->hideResources(false)  // Mostra risorse admin per gestione form
        ->enableComponents();   // Abilita componenti Livewire
    
    $plugins = [
        $boltPlugin,
        SpatieLaravelTranslatablePlugin::make()->defaultLocales([config('app.locale')]),
    ];
    
    $panel->plugins($plugins);
    
    return $panel;
}
```

#### 2. Modelli Bolt
I modelli Bolt utilizzati nel sistema:

- **Form**: Definizione del form con metadati
- **Section**: Sezioni all'interno del form
- **Field**: Campi individuali con configurazione
- **Response**: Risposte salvate degli utenti
- **Entry**: Voci di risposta per campo

#### 3. Configurazione Database
Tabelle prefissate con `bolt_`:
- `bolt_forms`
- `bolt_sections` 
- `bolt_fields`
- `bolt_responses`
- `bolt_entries`

## Utilizzo nei Template

### Componente Livewire
Il form viene integrato nei template Blade attraverso il componente Livewire:

```blade
{{-- Themes/One/resources/views/pages/patient/referto.blade.php --}}
<div>
    <h1>Referto</h1>
    <livewire:bolt.fill-form slug="prova-1" inline="true" />
</div>
```

### Parametri Componente
- `slug`: Identificatore univoco del form nel database
- `inline`: Renderizzazione inline (true) vs popup (false)

## Gestione Form

### Creazione Form via Admin
1. Accesso a `/saluteora/admin/bolt/forms`
2. Creazione nuovo form con slug univoco
3. Aggiunta sezioni e campi
4. Configurazione validazione e logica

### Form per Tipologie Utente

#### Form Pazienti
- **Finalità**: Raccolta dati medici, sintomi, anamnesi
- **Caratteristiche**: Interfaccia semplificata, validazione estesa
- **Esempio slug**: `patient-intake`, `symptoms-report`

#### Form Dottori  
- **Finalità**: Diagnosi, prescrizioni, note mediche
- **Caratteristiche**: Campi specialistici, integrazione con sistema medico
- **Esempio slug**: `diagnosis-form`, `prescription-form`

#### Form Amministrativi
- **Finalità**: Configurazioni sistema, reportistica
- **Caratteristiche**: Campi avanzati, logica condizionale
- **Esempio slug**: `clinic-settings`, `staff-evaluation`

## Sicurezza e Autorizzazioni

### Controllo Accessi
Il sistema integra i controlli di accesso esistenti:

```php
// Middleware applicati automaticamente
'middleware' => [
    EnsureUserHasType::class.':patient', // Per form pazienti
    EnsureUserHasType::class.':doctor',  // Per form dottori
    EnsureUserHasType::class.':admin',   // Per form admin
]
```

### Policy Integration
Le policy esistenti del sistema vengono applicate:
- `PatientPolicy`: Controllo accesso form pazienti
- `DoctorPolicy`: Controllo accesso form dottori  
- `AdminPolicy`: Controllo accesso form amministrativi

## Personalizzazioni SaluteOra

### Temi e Styling
I form Bolt utilizzano il tema One esistente:
- CSS custom in `Themes/One/resources/css/`
- Override template in `Themes/One/resources/views/vendor/bolt/`

### Integrazioni Sistema

#### Notificazioni
I form possono inviare notificazioni attraverso il sistema esistente:
```php
// Dopo submit form
$user->notify(new FormSubmittedNotification($response));
```

#### Audit Trail
Tutte le submission sono tracciate nel sistema di audit:
```php
// Log automatico delle risposte
activity('form_submitted')
    ->performedOn($response)
    ->withProperties(['form_slug' => $form->slug])
    ->log('Form submitted by user');
```

## Configurazione Avanzata

### Environment Variables
```env
# Configurazioni Bolt specifiche
BOLT_CACHE_FORMS=true
BOLT_ENABLE_API=false  
BOLT_ADMIN_ACCESS=restricted
```

### Cache Strategy
- Form definitions cached per 60 minuti
- Responses non cached per privacy
- Cache invalidation automatica su modifiche admin

## Testing e Validazione

### Test Form Integration
```php
<?php

namespace Modules\SaluteOra\Tests\Feature;

class BoltIntegrationTest extends TestCase
{
    /** @test */
    public function it_loads_bolt_form_on_patient_page(): void
    {
        $user = User::factory()->create(['type' => UserTypeEnum::PATIENT]);
        
        $response = $this->actingAs($user)
            ->get('/it/patient/referto');
            
        $response->assertOk()
            ->assertSeeLivewire('bolt.fill-form');
    }
    
    /** @test */
    public function it_registers_bolt_plugin_correctly(): void
    {
        $panel = Filament::getPanel('saluteora::admin');
        
        $this->assertTrue($panel->hasPlugin('zeus-bolt'));
    }
}
```

### Form Validation Testing
```php
/** @test */
public function it_validates_patient_form_submission(): void
{
    $form = BoltForm::factory()->create(['slug' => 'test-form']);
    
    Livewire::test('bolt.fill-form', ['slug' => 'test-form'])
        ->set('data.nome', '')
        ->call('submit')
        ->assertHasErrors(['data.nome']);
}
```

## Troubleshooting

### Errori Comuni

#### Plugin Not Registered
**Errore**: `Plugin [zeus-bolt] is not registered for panel [saluteora::admin]`
**Soluzione**: Verificare registrazione in AdminPanelProvider e timing boot

#### Form Not Found
**Errore**: `Form with slug 'xxx' not found`
**Soluzione**: Verificare esistenza form in database e status attivo

#### Permission Denied
**Errore**: Accesso negato al form
**Soluzione**: Verificare tipo utente e middleware applicati

### Debug Commands
```bash
# Verifica plugin registrati
php artisan filament:list-panels

# Cache form clear
php artisan cache:forget bolt_forms_*

# Database status
php artisan migrate:status --path=vendor/lara-zeus/bolt/database/migrations
```

## Performance Optimizations

### Query Optimization
- Eager loading relazioni form → sections → fields
- Index su slug e status per query veloci
- Caching risposte frequenti

### Memory Management
- Lazy loading per form grandi
- Pagination automatica per listing risposte
- Cleanup periodico risposte obsolete

## Roadmap e Evoluzione

### Funzionalità Future
- [ ] Workflow approval per form critici
- [ ] Integrazione firma digitale
- [ ] Export PDF automatico risposte
- [ ] Dashboard analytics form completion
- [ ] Multi-step wizard per form complessi

### Migrazioni Pianificate
- Migrazione da form statici esistenti
- Integrazione con sistemi esterni (HL7, FHIR)
- API per app mobile

## Bibliografia e Riferimenti

### Documentazione Esterna
- [Lara Zeus Bolt Documentation](https://bolt.larazeus.com/)
- [Filament Plugin Development](https://filamentphp.com/docs/plugins)

### Documentazione Interna
- [Bolt Plugin Registration Issue](../../docs/bolt_plugin_registration_issue.md)
- [SaluteOra AdminPanelProvider](../app/Providers/Filament/AdminPanelProvider.php)
- [User Type Middleware](../Http/Middleware/EnsureUserHasType.php)

### Conventions
- [Laraxot Conventions](../../docs/laraxot_conventions.md)
- [Filament Best Practices](../../docs/filament-best-practices.md)

*Ultimo aggiornamento: Gennaio 2025*
*Maintainer: Sviluppatori SaluteOra* 