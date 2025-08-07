# Specifica Tecnica Dashboard Filament

## Struttura File
Il file deve essere posizionato in:
```
/app/Filament/Pages/Dashboard.php
```

## Requisiti Tecnici

### Namespace e Import
```php
namespace Modules\SaluteMo\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Pages\Dashboard as FilamentDashboard;
```

### Classe Base
- Deve estendere `XotBasePage`
- NON deve estendere direttamente `FilamentDashboard`
- NON deve usare `BaseDashboard` come alias

### Proprietà Richieste
- `protected static string $navigationIcon = 'heroicon-o-home'`
- `protected static string $navigationLabel = 'Dashboard'`
- `protected static ?int $navigationSort = -2`
- `protected static ?string $navigationGroup = 'SaluteMo'`

### Widget da Implementare
1. **Statistiche Generali**
   - Numero totale di pazienti
   - Appuntamenti del giorno
   - Visite in corso
   - Metriche di performance

2. **Attività Recenti**
   - Ultime visite
   - Modifiche ai pazienti
   - Notifiche importanti
   - Eventi del calendario

3. **Quick Actions**
   - Nuovo appuntamento
   - Nuovo paziente
   - Accesso rapido alle risorse
   - Azioni frequenti

4. **Metriche di Performance**
   - Tempi di attesa
   - Occupazione
   - Efficienza
   - KPI principali

### Metodi da Implementare
- `getHeaderWidgets(): array`
- `getFooterWidgets(): array`
- `getTitle(): string`
- `getSubheading(): ?string`

### Autorizzazioni
- Implementare i gate necessari
- Verificare i permessi utente
- Gestire l'accesso ai widget
- Controllare le azioni disponibili

### Traduzioni
- Implementare le traduzioni per:
  - Titoli
  - Etichette
  - Messaggi
  - Tooltip

### Performance
- Implementare il caching per:
  - Statistiche
  - Metriche
  - Dati frequenti
- Ottimizzare le query
- Minimizzare le richieste al database

### Integrazione
- Con il sistema di navigazione
- Con altri moduli
- Con il sistema di notifiche
- Con il sistema di autorizzazioni

## Best Practices
1. **Codice**
   - Seguire PSR-12
   - Documentare i metodi
   - Utilizzare type hints
   - Implementare interfacce quando appropriato

2. **UX**
   - Layout responsive
   - Caricamento lazy dei widget
   - Feedback visivo per le azioni
   - Gestione degli errori

3. **Sicurezza**
   - Validazione input
   - Sanitizzazione output
   - Protezione CSRF
   - Controllo accessi

4. **Manutenibilità**
   - Codice modulare
   - Test unitari
   - Documentazione inline
   - Logging appropriato

## Dipendenze
- XotBasePage
- Widget necessari
- Provider di servizi
- Helper functions

## Note di Implementazione
- Priorità alta
- Fondamentale per l'usabilità
- Punto di ingresso principale
- Coerenza con altri moduli 
