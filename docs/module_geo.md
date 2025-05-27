# Modulo Geo

## Informazioni Generali
- **Nome**: `laraxot/module_geo_fila3`
- **Descrizione**: Modulo per la gestione delle funzionalità geografiche
- **Namespace**: `Modules\Geo`
- **Repository**: https://github.com/laraxot/module_geo_fila3.git

## Service Providers
1. `Livewire\LivewireServiceProvider`
2. `Modules\Geo\Providers\GeoServiceProvider`
3. `Modules\Geo\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi geografici
```

## Dipendenze
### Pacchetti Required
- `cheesegrits/filament-google-maps`: ^3.0
- `dotswan/filament-map-picker`: ^1.2
- `webbingbrasil/filament-maps`: ^3.0@beta

### Moduli Required
- Xot
- Tenant
- UI

## Database
### Factories
Namespace: `Modules\Geo\Database\Factories`

### Seeders
Namespace: `Modules\Geo\Database\Seeders`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Integrazione con Google Maps
- Selezione posizioni su mappa
- Gestione coordinate geografiche
- Widget per mappe in Filament

## Configurazione
### Google Maps
- Richiede API Key di Google Maps
- Configurazione in `.env`:
  ```
  GOOGLE_MAPS_API_KEY=your_api_key
  ```

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Gestire sempre le chiavi API in modo sicuro

## Troubleshooting
### Problemi Comuni
1. **Errori di API Key**
   - Verificare la presenza della chiave in `.env`
   - Controllare i permessi dell'API in Google Console

2. **Problemi di Visualizzazione Mappe**
   - Verificare il caricamento degli script Google Maps
   - Controllare la presenza di errori JavaScript
   - Verificare le restrizioni del dominio in Google Console

## Changelog
Le modifiche vengono tracciate nel repository GitHub. 