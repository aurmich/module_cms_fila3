# Struttura Directory e Namespace

## Struttura Directory Corretta
```
laravel/Modules/SaluteOra/
├── app/                    # Directory principale per il codice dell'applicazione
│   ├── Filament/          # Risorse e componenti Filament
│   │   ├── Resources/     # Resource Filament
│   │   │   └── AppointmentWorkflowResource/
│   │   │       └── Pages/ # Pagine delle risorse
│   │   ├── Models/            # Modelli Eloquent
│   │   ├── Providers/         # Service Provider
│   │   └── Services/          # Servizi dell'applicazione
│   ├── config/                # File di configurazione
│   ├── database/              # Migrations e seeders
│   ├── docs/                  # Documentazione
│   ├── resources/             # Assets e views
│   └── routes/                # Definizioni delle route
```

## Namespace Corretti
- **Filament Resources**: `Modules\SaluteOra\App\Filament\Resources`
- **Models**: `Modules\SaluteOra\App\Models`
- **Providers**: `Modules\SaluteOra\App\Providers`
- **Services**: `Modules\SaluteOra\App\Services`

## Regole Importanti
1. Tutte le classi Filament devono essere nella directory `app/Filament`
2. I namespace devono riflettere la struttura delle directory
3. Non utilizzare mai la directory `Filament` alla radice del modulo
4. Mantenere la coerenza tra struttura directory e namespace

## Best Practices
1. **Verifica Directory**:
   - Prima di creare nuovi file, verificare la struttura corretta
   - Utilizzare i comandi artisan per generare i file nelle posizioni corrette

2. **Namespace**:
   - Seguire sempre il pattern `Modules\SaluteOra\App\{Directory}`
   - Mantenere la coerenza tra namespace e struttura directory

3. **Comandi Artisan**:
   ```bash
   # Generare una nuova Resource Filament
   php artisan make:filament-resource ResourceName --module=SaluteOra
   
   # Generare una nuova Page per una Resource
   php artisan make:filament-page PageName --resource=ResourceName --module=SaluteOra
   ```

4. **Verifica**:
   - Controllare sempre il namespace generato
   - Verificare che il file sia nella directory corretta
   - Assicurarsi che la struttura rifletta le convenzioni del progetto

## Errori Comuni da Evitare
1. ❌ Creare file nella directory `Filament` alla radice del modulo
2. ❌ Utilizzare namespace non conformi alla struttura directory
3. ❌ Spostare manualmente i file senza aggiornare i namespace
4. ❌ Non verificare la struttura directory prima di creare nuovi file

## Strumenti di Verifica
1. **Comando per verificare la struttura**:
   ```bash
   php artisan module:list-files SaluteOra
   ```

2. **Comando per verificare i namespace**:
   ```bash
   php artisan module:check-namespaces SaluteOra
   ```

## Collegamenti Correlati
- [Documentazione Filament](../../../Xot/docs/filament-best-practices.md)
- [Best Practices Moduli](../../../Xot/docs/module-best-practices.md)
- [Guida Namespace](../../../Xot/docs/namespace-guide.md) 