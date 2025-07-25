# Sistema di Autenticazione e Registrazione

## Panoramica
Il sistema di autenticazione e registrazione è implementato utilizzando Livewire Volt e Filament, garantendo una gestione flessibile dei diversi tipi di utenti.

## Componenti Principali

### Registrazione Utenti
## Collegamenti correlati
- [Documentazione centrale](../../../docs/README.md)
- [Implementazione Auth Pages](../../Modules/User/docs/AUTH_PAGES_IMPLEMENTATION.md)
- [Implementazione Logout](../../Modules/User/docs/LOGOUT_BLADE_IMPLEMENTATION.md)
- [Analisi Logout](../../Modules/User/docs/LOGOUT_BLADE_ANALYSIS.md)
- [Conclusioni Logout](../../Modules/User/docs/LOGOUT_BLADE_CONCLUSIONS.md)
- [Analisi Errore Logout](../../Modules/User/docs/LOGOUT_IMPLEMENTATION_ERROR.md)
- [Logout con Widget Filament](../../Modules/User/docs/LOGOUT_FILAMENT_WIDGET.md)
- [Struttura Widget](../../Modules/User/docs/WIDGETS_STRUCTURE.md)
- [Componenti Filament](FILAMENT_COMPONENTS.md)

## Panoramica
Il sistema di autenticazione e registrazione è implementato utilizzando Laravel Folio, Livewire Volt e componenti Filament, garantendo una gestione flessibile dei diversi tipi di utenti e una UX coerente.

## Componenti Principali

### Login (login.blade.php)
- Implementazione basata su Livewire Volt
- Utilizzo dei componenti Blade nativi di Filament
- Localizzazione degli URL con `app()->getLocale()`
- Validazione e gestione degli errori

### Registrazione (register.blade.php)
- Implementazione basata su Livewire Volt
- Supporto per diversi tipi di utenti (Patient, Doctor, etc.)
- UI moderna con componenti Filament
- Gestione personalizzata dei percorsi di registrazione

### Collegamenti Correlati
- [Convenzioni Namespace](../../Modules/Xot/docs/NAMESPACE-CONVENTIONS.md)
- [Componenti Filament](FILAMENT_COMPONENTS.md)
- [Struttura Moduli](../../Modules/Xot/docs/module-structure.md)
### Logout (logout.blade.php)

#### Approccio Raccomandato: Folio con PHP puro
- Implementazione basata su Folio con PHP puro
- Reindirizzamento immediato alla home page localizzata
- Sicurezza della sessione (invalidazione e rigenerazione token)
- Nessuna interazione utente richiesta

#### Approccio Alternativo: Widget Filament
- Implementazione basata su widget Filament per casi che richiedono conferma
- UI coerente con componenti Filament nativi
- Riutilizzabilità in diverse parti dell'applicazione
- Separazione chiara tra logica e presentazione

## Struttura dei File
```
Themes/One/
├── resources/
│   └── views/
│       └── pages/
│           └── auth/
│               └── register.blade.php
│               ├── login.blade.php
│               ├── register.blade.php
│               ├── logout.blade.php
│               ├── [type]/
│               │   └── register.blade.php
│               ├── password/
│               │   ├── [token].blade.php
│               │   ├── confirm.blade.php
│               │   └── reset.blade.php
│               ├── thank-you.blade.php
│               └── verify.blade.php
└── docs/
    └── AUTH.md
```

## Decisioni Architetturali
1. Utilizzo di Livewire Volt per la gestione dello stato
2. Componenti Filament per l'UI consistente
3. Sistema modulare per i tipi di utenti
4. Routing dinamico basato sul tipo di utente

## Note di Implementazione
- La registrazione è gestita tramite il componente Volt `register`
- I tipi di utente sono recuperati dinamicamente dal modello User
- L'UI è responsive e segue le linee guida di design del progetto 
