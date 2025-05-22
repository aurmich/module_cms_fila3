# Modulo Patient

## Descrizione
Modulo per la gestione dei pazienti nel sistema sanitario.

## Struttura del Modulo
```
Patient/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Resources/
│   ├── js/
│   └── views/
├── Routes/
└── Services/
```

## Checklist di Riavvio
- [ ] Verificare le dipendenze nel `composer.json`
- [ ] Controllare le migrazioni pendenti
- [ ] Verificare i service provider registrati
- [ ] Controllare le traduzioni
- [ ] Verificare le configurazioni
- [ ] Testare le funzionalità principali

## Best Practices
1. **Naming Conventions**
   - Utilizzare PascalCase per i nomi delle classi
   - Utilizzare camelCase per i metodi e le proprietà
   - Utilizzare snake_case per i nomi dei file di migrazione

2. **Struttura del Codice**
   - Mantenere i controller snelli
   - Utilizzare i service layer per la logica di business
   - Implementare le interfacce per i servizi principali

3. **Gestione dei File**
   - Utilizzare il sistema di storage configurato
   - Implementare la validazione dei file
   - Gestire correttamente i permessi

## Errori Comuni
1. **File Upload**
   - Non utilizzare `prefixIcon()` o `icon()` direttamente su `FileUpload`
   - Utilizzare `Section` per aggiungere icone ai componenti di upload

2. **Migrations**
   - Verificare sempre le dipendenze tra le tabelle
   - Utilizzare i tipi di colonna appropriati
   - Implementare gli indici necessari

## Errore critico: No hint path defined for [patient]

**Problema:**
Se accedi a `/it/auth/patient/register` e ricevi l'errore:

```
InvalidArgumentException
No hint path defined for [patient].
```

**Motivo:**
Nel codice del modulo viene usato il namespace Blade `patient::` (es: `Forms\Components\View::make('patient::privacy-policy')`), ma il modulo si chiama `SaluteOra` e il suo ServiceProvider registra solo il namespace `saluteora`.

**Soluzione:**
1. **Registrare il namespace Blade 'patient' nel ServiceProvider del modulo.**
   - Apri `app/Providers/SaluteOraServiceProvider.php`.
   - All'interno del metodo `boot()`, aggiungi:
     ```php
     use Illuminate\Support\Facades\Blade;
     // ...
     public function boot()
     {
         parent::boot();
         \Illuminate\Support\Facades\View::addNamespace('patient', base_path('laravel/Modules/SaluteOra/resources/views'));
     }
     ```
   - In alternativa, sostituisci tutte le chiamate a `patient::` con `saluteora::` nel codice del modulo.

2. **Svuota la cache delle view:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

3. **Verifica:**
   - Ricarica la pagina `/it/auth/patient/register` e controlla che l'errore sia risolto.

**Nota:**
- È preferibile uniformare i namespace usati nel codice e nella registrazione delle viste per evitare errori simili in futuro.
- Aggiorna anche la documentazione interna e i commenti nei file dove viene usato `patient::`.

## Documentazione
- [Component Icon Support](/docs/filament/component-icon-support.md)
- [File Upload Component](/docs/filament/file-upload-component.md)
- [Database Migrations](/docs/database-migrations.md)

## Testing
- Eseguire i test unitari: `php artisan test --filter=Patient`
- Verificare la copertura del codice
- Testare le funzionalità principali

## Deployment
1. Eseguire le migrazioni
2. Pubblicare gli assets
3. Aggiornare la cache
4. Verificare i permessi

## Manutenzione
- Monitorare i log per errori
- Verificare periodicamente le performance
- Aggiornare le dipendenze
- Mantenere la documentazione aggiornata

## Troubleshooting

### Errore: `No hint path defined for [patient]`

**Descrizione:**
Se accedi alla URL `/it/auth/patient/register` e ricevi un errore `Internal Server Error` con messaggio:

```
InvalidArgumentException
No hint path defined for [patient].
```

significa che Laravel non trova il namespace Blade `patient::` richiesto da alcune view o componenti (es. `<x-patient::patient-registration-wizard />` o `@extends('patient::layouts.app')`).

**Cause comuni:**
- Il namespace Blade `patient` non è stato registrato nei service provider.
- Il componente Blade è presente in `resources/views/components/` ma non è pubblicato/registrato come namespace.
- Il modulo non ha un ServiceProvider che esegue la registrazione dei componenti Blade con `Blade::componentNamespace()` o `Blade::component()`.

**Soluzione:**
1. **Verifica la presenza del ServiceProvider**
   - Controlla che in `Providers/SaluteOraServiceProvider.php` (o simile) sia presente la registrazione del namespace Blade per i componenti patient:
   ```php
   use Illuminate\Support\Facades\Blade;
   // ...
   public function boot()
   {
       Blade::componentNamespace('Modules\\SaluteOra\\View\Components', 'patient');
   }
   ```
   - Se usi componenti class-based, assicurati che la directory e il namespace siano corretti.

2. **Verifica la struttura delle view**
   - I file Blade usati come componenti devono trovarsi in `resources/views/components/` e seguire la naming convention corretta.
   - Se usi `@extends('patient::layouts.app')`, assicurati che esista la view `resources/views/layouts/app.blade.php` e che il namespace sia registrato.

3. **Cache delle view**
   - Dopo aver registrato il namespace, svuota la cache delle view:
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

4. **Ricarica la pagina**
   - Verifica che l'errore sia risolto accedendo nuovamente alla URL.

**Nota:**
Se il modulo viene installato come package, assicurati che il ServiceProvider sia correttamente registrato in `composer.json` e caricato da Laravel.

**Riferimenti:**
- [Documentazione Laravel Blade Components](https://laravel.com/docs/12.x/blade#manually-registering-components)
- [Esempio di registrazione namespace Blade](https://laravel.com/docs/12.x/blade#registering-package-components)
