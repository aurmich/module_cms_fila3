# Specifica Tecnica Module.json

## Struttura File
Il file deve essere posizionato in:
```
/module.json
```

## Requisiti Tecnici

### Configurazione Base
```json
{
    "name": "SaluteMo",
    "alias": "salutemo",
    "description": "Gestione dei pazienti",
    "keywords": ["pazienti", "isee", "anamnesi", "documenti", "gestanti"],
    "priority": 10,
    "active": 1,
    "order": 10
}
```

### Providers
```json
"providers": [
    "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
    "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
]
```

### Alias e File
```json
"aliases": {
},
"files": [
]
```

## Best Practices

### 1. Naming e Alias
- `name`: Nome ufficiale del modulo (PascalCase)
- `alias`: Nome in lowercase per riferimenti interni
- Mantenere coerenza tra name e alias
- Evitare spazi e caratteri speciali

### 2. Descrizione e Keywords
- Descrizione chiara e concisa
- Keywords rilevanti per la ricerca
- Mantenere keywords in italiano
- Includere termini tecnici importanti

### 3. Priorità e Ordine
- `priority`: Importanza del modulo (1-10)
- `order`: Ordine di caricamento
- `active`: Stato del modulo (0/1)
- Mantenere coerenza con altri moduli

### 4. Providers
- Includere tutti i provider necessari
- Mantenere l'ordine corretto
- Seguire il namespace corretto
- Documentare lo scopo di ogni provider

### 5. Alias
- Definire alias per classi/facade
- Mantenere coerenza con altri moduli
- Documentare lo scopo degli alias
- Evitare conflitti di naming

### 6. File
- Includere file di configurazione
- Includere file di helper
- Mantenere l'ordine corretto
- Documentare lo scopo dei file

## Note di Implementazione

### Priorità
- Alta priorità per la configurazione base
- Media priorità per providers
- Bassa priorità per alias e file

### Coerenza
- Mantenere coerenza con SaluteOra
- Seguire le convenzioni del progetto
- Rispettare la struttura modulare
- Documentare le differenze

### Manutenibilità
- Struttura chiara e organizzata
- Commenti appropriati
- Documentazione aggiornata
- Versioning corretto

### Sicurezza
- Validare i dati di input
- Sanitizzare gli output
- Gestire correttamente i permessi
- Implementare logging appropriato

## Esempio Completo
```json
{
    "name": "SaluteMo",
    "alias": "salutemo",
    "description": "Gestione dei pazienti",
    "keywords": ["pazienti", "isee", "anamnesi", "documenti", "gestanti"],
    "priority": 10,
    "active": 1,
    "order": 10,
    "providers": [
        "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
        "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
    ],
    "aliases": {
    },
    "files": [
    ]
}
```

## Note Aggiuntive
- Mantenere il file aggiornato
- Documentare le modifiche
- Testare dopo ogni modifica
- Verificare la compatibilità 
