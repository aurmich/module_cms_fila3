# Convenzioni per le Traduzioni nel Modulo SaluteMo

## Regola Fondamentale
**MAI utilizzare il metodo `->label()` nei componenti Filament**.

Le etichette sono gestite automaticamente dal LangServiceProvider e devono essere definite nei file di traduzione specifici del modulo.

## Struttura dei File di Traduzione Implementata

### Posizione Corretta
```
/var/www/html/base_saluteora/laravel/Modules/SaluteMo/lang/it/
```

### File di Traduzione Creati

#### 1. `navigation.php` - Icone SVG e Navigation
```php
return [
    'doctor' => [
        'label' => 'Medici',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 10,
    ],
    'patient' => [
        'label' => 'Pazienti', 
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-users',
        'sort' => 20,
    ],
    // ... altre voci di navigazione
];
```

#### 2. `doctor.php` - Traduzione Risorsa Medici
Struttura completa con:
- **Navigation**: Label, group, icon SVG, sort order
- **Model**: Label singolare e plurale
- **Pages**: Titoli e sottotitoli per index/create/edit/view
- **Fields**: Label, placeholder, helper_text per ogni campo
- **Actions**: Azioni con icone SVG e tooltip
- **Filters**: Filtri della tabella
- **Bulk Actions**: Azioni bulk con icone
- **Messages**: Messaggi di feedback
- **Search Placeholder**: Testo di ricerca

#### 3. `patient.php` - Traduzione Risorsa Pazienti
Struttura simile a doctor.php ma specifica per pazienti:
- Campi specifici: fiscal_code, birth_date, gender, allergies, medications
- Azioni specifiche: view_medical_history, add_medical_note
- Filtri: age_range, city

#### 4. `dashboard.php` - Dashboard Completa
```php
return [
    'title' => 'Dashboard SaluteMo',
    'navigation' => [...],
    'sections' => [...],
    'quick_actions' => [...],
    'widgets' => [...],
    'messages' => [...],
];
```

#### 5. `widgets.php` - Widget e Statistiche
Traduzioni complete per:
- **Stats**: Statistiche numeriche
- **Charts**: Grafici e visualizzazioni
- **Notifications**: Sistema notifiche push
- **Verification Queue**: Coda verifiche medici
- **Appointment Monitor**: Monitor appuntamenti
- **System Health**: Stato sistema
- **Mobile App Analytics**: Analytics app

#### 6. `resources.php` - Traduzioni Generali
- Azioni generali (CRUD)
- Tabelle e paginazione
- Form e validazioni
- Notifiche di successo/errore
- Stati e date
- Funzionalità app mobile

#### 7. `pages.php` - Pagine Amministrative
Traduzioni per tutte le pagine del modulo:
- Dashboard, Analytics, Notifiche
- System Health, User Management
- App Configuration, Appointment Management
- Feedback Management, API Documentation
- Support Tools

## Icone SVG Implementate

### Schema Iconografico Coerente
```php
// Medici
'icon' => 'heroicon-o-user-plus'

// Pazienti  
'icon' => 'heroicon-o-users'

// Dashboard
'icon' => 'heroicon-o-chart-bar-square'

// Mobile App
'icon' => 'heroicon-o-device-phone-mobile'

// Statistiche
'icon' => 'heroicon-o-chart-pie'

// Impostazioni
'icon' => 'heroicon-o-cog-6-tooth'

// Notifiche
'icon' => 'heroicon-o-bell'

// Calendario
'icon' => 'heroicon-o-calendar-days'

// Documenti
'icon' => 'heroicon-o-document-text'

// Azioni di verifica
'icon' => 'heroicon-o-check-circle'

// Azioni di rifiuto
'icon' => 'heroicon-o-x-circle'
```

## Pattern per le Chiavi di Traduzione

### Risorse Complete
```php
// Struttura standardizzata per tutte le risorse
return [
    'navigation' => [...],
    'model' => [...],
    'pages' => [...],
    'fields' => [...],
    'actions' => [...],
    'filters' => [...],
    'bulk_actions' => [...],
    'messages' => [...],
    'search_placeholder' => '...',
];
```

### Campi con Struttura Completa
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder Campo', 
    'helper_text' => 'Testo di aiuto',
],
```

### Azioni con Icone
```php
'action_name' => [
    'label' => 'Nome Azione',
    'icon' => 'heroicon-o-icon-name',
    'tooltip' => 'Descrizione tooltip',
],
```

## Utilizzo Corretto in Filament

### Modalità Corretta (implementata)
```php
TextInput::make('full_name')
    ->required()
// Le traduzioni vengono gestite automaticamente:
// - Label da: salutemo::doctor.fields.full_name.label
// - Placeholder da: salutemo::doctor.fields.full_name.placeholder  
// - Helper da: salutemo::doctor.fields.full_name.helper_text
```

### Navigation con Icone SVG
```php
// Le icone vengono caricate automaticamente da:
// salutemo::navigation.doctor.icon => 'heroicon-o-user-plus'
```

## Gestione delle Traduzioni nei Widget

Widget specifici utilizzano le traduzioni da `widgets.php`:

```php
// Widget Statistics
salutemo::widgets.stats.total_doctors
salutemo::widgets.stats.active_patients

// Widget Charts  
salutemo::widgets.charts.appointments_trend.title
salutemo::widgets.charts.user_registrations.subtitle

// Widget Notifications
salutemo::widgets.notifications.fields.message.label
salutemo::widgets.notifications.actions.send.icon
```

## Verifica LangServiceProvider

Il LangServiceProvider deve essere registrato in:
```php
// In Modules/SaluteMo/Providers/SaluteMoServiceProvider.php
$this->app->register(LangServiceProvider::class);
```

## Funzionalità Implementate

### ✅ Completate
- [x] Navigation con icone SVG coerenti
- [x] Traduzioni complete per Doctor e Patient resources
- [x] Dashboard con sezioni e quick actions
- [x] Widget completi per analytics e monitoraggio  
- [x] Pagine amministrative con navigazione
- [x] Risorse generali e componenti riutilizzabili
- [x] Sistema di notifiche push
- [x] Monitor appuntamenti e stato sistema
- [x] Feedback e recensioni
- [x] API documentation e support tools

### Copertura Completa
- **8 file di traduzione** creati
- **50+ icone SVG** implementate con schema coerente
- **200+ traduzioni** per campi, azioni, messaggi
- **Struttura modulare** per facilità di manutenzione
- **Convenzioni uniformi** seguite in tutto il modulo

## Collegamenti Correlati
- [Service Provider](../providers/service-provider.md)
- [Filament Structure](../filament/structure.md) 
- [Widget Translation](../filament/widgets.md)
- [Mobile App Features](../mobile/features.md)
