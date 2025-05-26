# Tema One - SaluteOra

## Panoramica

Il tema One è un tema moderno e pulito per l'applicazione SaluteOra, progettato per fornire un'interfaccia utente intuitiva e professionale per pazienti, dottori e amministratori.

## Principi di Design

### Integrazione Widget
Il tema One segue il principio fondamentale di **non duplicare funzionalità esistenti**. Invece di ricreare componenti da zero, il tema richiama i widget Filament esistenti e applica solo styling specifico.

#### ✅ Approccio Corretto
```php
// Richiama widget esistente
@livewire(\Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget::class)
```

#### ❌ Approccio Sbagliato
```php
// NON ricreare funzionalità esistenti
<script>
    var calendar = new FullCalendar.Calendar(/* ... */);
</script>
```

## Componenti Principali

### Calendar Block
Il componente `calendar.blade.php` è stato completamente riprogettato per:

- **Riutilizzare Widget Esistenti**: Richiama i widget FullCalendar del modulo SaluteOra
- **Rispettare Sicurezza**: Mantiene tutti i controlli di accesso e tenancy
- **Applicare Styling**: Aggiunge solo CSS specifico del tema
- **Gestire Stati**: Mostra messaggi appropriati per utenti non autenticati o senza permessi

#### Funzionalità
- Rilevamento automatico tipo utente (Patient, Doctor, Admin)
- Verifica permessi e tenancy
- Styling responsive
- Stati di caricamento e errore
- Integrazione seamless con widget Filament

#### Utilizzo
```php
<x-one::blocks.calendar 
    title="Il Mio Calendario"
    height="600px"
    :show-toolbar="true"
/>
```

## Struttura File

```
resources/views/components/
├── blocks/
│   ├── calendar.blade.php          # ✅ Corretto - richiama widget
│   ├── calendar-dynamic.blade.php  # Da aggiornare
│   └── ...
├── layouts/
│   └── ...
└── ...
```

## Stili CSS

### Variabili Tema
```css
.theme-one-calendar {
    --calendar-primary: #3b82f6;
    --calendar-primary-hover: #2563eb;
    --calendar-border: #e5e7eb;
    --calendar-bg: #ffffff;
    --calendar-text: #111827;
    --calendar-text-muted: #6b7280;
}
```

### Integrazione Filament
Il tema applica stili specifici ai widget Filament senza modificarne la logica:

```css
/* Integrazione con widget Filament */
.theme-one-calendar .fi-wi-calendar {
    border: none;
    box-shadow: none;
    background: transparent;
}
```

## Responsive Design

Il tema è completamente responsive con breakpoint ottimizzati per:
- Desktop (>= 1024px)
- Tablet (768px - 1023px)  
- Mobile (< 768px)

## Sicurezza

### Controlli di Accesso
Il tema rispetta tutti i controlli di sicurezza implementati nei widget:
- Autenticazione utente
- Verifica tipo utente (Patient/Doctor/Admin)
- Tenancy multi-studio per dottori
- Filtri dati automatici

### Privacy
- Mascheramento dati sensibili quando necessario
- Rispetto GDPR
- Audit trail mantenuto dai widget

## Performance

### Ottimizzazioni
- Lazy loading dei widget
- Caching implementato nei widget sottostanti
- CSS ottimizzato per rendering veloce
- Immagini responsive

### Metriche Target
- First Contentful Paint: < 1.5s
- Largest Contentful Paint: < 2.5s
- Cumulative Layout Shift: < 0.1

## Accessibilità

### Standard WCAG 2.1 AA
- Contrasto colori conforme
- Navigazione keyboard
- Screen reader friendly
- Focus indicators visibili

### Supporto Tecnologie Assistive
- ARIA labels appropriati
- Semantic HTML
- Alt text per immagini
- Heading hierarchy corretta

## Manutenzione

### Aggiornamenti Widget
Quando i widget Filament vengono aggiornati, il tema eredita automaticamente:
- Nuove funzionalità
- Correzioni bug
- Miglioramenti sicurezza
- Ottimizzazioni performance

### Personalizzazioni
Per personalizzare l'aspetto:
1. Modificare solo variabili CSS
2. Non toccare logica widget
3. Testare su tutti i dispositivi
4. Verificare accessibilità

## Testing

### Test Richiesti
- [ ] Rendering corretto per tutti i tipi utente
- [ ] Responsive design su tutti i dispositivi
- [ ] Controlli di accesso funzionanti
- [ ] Performance entro target
- [ ] Accessibilità WCAG 2.1 AA

### Browser Supportati
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Troubleshooting

### Problemi Comuni

#### Widget Non Caricato
```
Errore: Class 'PatientCalendarWidget' not found
```
**Soluzione**: Verificare che il modulo SaluteOra sia installato e attivo.

#### Permessi Negati
```
Messaggio: "Accesso Limitato"
```
**Soluzione**: Verificare tipo utente e tenancy per dottori.

#### Styling Non Applicato
**Soluzione**: Verificare che i CSS del tema siano caricati dopo quelli di Filament.

## Contribuire

### Linee Guida
1. **Non Duplicare**: Mai ricreare funzionalità esistenti
2. **Solo Styling**: Modificare solo aspetto visivo
3. **Testare**: Verificare su tutti i dispositivi
4. **Documentare**: Aggiornare README per modifiche

### Pull Request
1. Fork del repository
2. Branch feature/fix
3. Test completi
4. Documentazione aggiornata
5. PR con descrizione dettagliata

## Changelog

### v2.0.0 (Corrente)
- ✅ **BREAKING**: Rimosso calendario custom, ora usa widget Filament
- ✅ Aggiunta integrazione sicura con widget SaluteOra
- ✅ Migliorato responsive design
- ✅ Aggiunto supporto tenancy multi-studio
- ✅ Ottimizzato performance e accessibilità

### v1.x.x (Deprecato)
- ❌ Implementazione calendario custom (rimossa)
- ❌ Duplicazione logica widget (corretta)

## Licenza

Questo tema è parte del progetto SaluteOra e segue la stessa licenza del progetto principale.

## Supporto

Per supporto tecnico:
- Documentazione: `/docs`
- Issues: Repository GitHub
- Email: support@saluteora.it
