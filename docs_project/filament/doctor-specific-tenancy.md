# Doctor-Specific Tenancy in SaluteOra

## Panoramica

Questa documentazione descrive l'implementazione della multi-tenancy specifica per utenti di tipo Doctor in SaluteOra. A differenza dell'approccio standard, questa implementazione applica la tenancy **solo** agli utenti con ruolo Doctor, mentre per Admin e Patient il sistema funziona senza requisiti di tenant.

## Componenti Chiave

### 1. Middleware Dedicato

Il middleware `DoctorTenancyMiddleware` è responsabile di verificare il tipo di utente e disabilitare la tenancy per non-doctor:

```php
// Modules/SaluteOra/app/Http/Middleware/DoctorTenancyMiddleware.php
public function handle(Request $request, Closure $next): Response
{
    $user = Auth::user();
    
    // Se non è un doctor, disabilitiamo i requisiti di tenancy
    if ($user && $user->type !== UserTypeEnum::DOCTOR) {
        session(['filament.tenant.bypass' => true]);
    }
    
    return $next($request);
}
```

### 2. Action Specializzata

L'action `ApplyDoctorTenancyToPanelAction` configura il panel Filament per applicare la tenancy in modo condizionale:

```php
// Modules/SaluteOra/app/Actions/Panel/ApplyDoctorTenancyToPanelAction.php
public function execute(Panel $panel): Panel
{
    $tenantClass = XotData::make()->getTenantClass();
    
    // Registra il middleware che verifica il tipo utente
    $panel->middleware([
        DoctorTenancyMiddleware::class,
    ]);
    
    // Configura tenancy (attiva solo per doctor)
    $panel->tenant($tenantClass, 'slug', 'tenants')
          ->tenantRegistration(RegisterTenant::class)
          ->tenantProfile(EditTenantProfile::class);
    
    return $panel;
}
```

### 3. Provider del Panel

Nel provider del panel, utilizziamo l'action specializzata:

```php
// Modules/SaluteOra/app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    // Applica tenancy specifica per doctor
    $panel = app(ApplyDoctorTenancyToPanelAction::class)->execute($panel);
    
    $this->configurePanel($panel);

    return $panel;
}
```

## Flusso di Esecuzione

1. L'utente si autentica nel sistema
2. Il middleware `DoctorTenancyMiddleware` verifica il tipo di utente:
   - Se è Doctor: la tenancy viene applicata normalmente
   - Se è Admin/Patient: la tenancy viene bypassata tramite flag di sessione
3. L'utente accede alle risorse appropriate per il suo ruolo, con o senza contesto tenant

## Vantaggi dell'Implementazione

1. **Separazione delle responsabilità**: Ogni componente ha un ruolo chiaro
2. **Manutenibilità**: Facile estendere o modificare il comportamento
3. **Performance**: Evita middleware ridondanti per utenti non-doctor
4. **Leggibilità**: Codice ben organizzato e documentato
5. **Debuggability**: Evita l'uso di closure, che causano problemi con Laravel Debugbar

## Collegamenti

- [Multi-Tenancy in Filament](./filament_multitenancy_setup.md)
- [Single Table Inheritance](../standards/single-table-inheritance.md)
- [Filament Admin Service Provider](./filament-admin-service-provider-multi-tenancy.md)
