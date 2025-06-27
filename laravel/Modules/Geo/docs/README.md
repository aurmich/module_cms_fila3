# Modulo Geo - Documentazione

## 🌍 Panoramica

Il modulo Geo fornisce tutti i dati geografici italiani necessari per l'applicazione SaluteOra, inclusi:
- Regioni
- Province  
- Comuni
- CAP
- Coordinate geografiche
- Dati demografici

## 🛠️ Modelli Principali

### Comune
Il modello principale che gestisce tutti i dati geografici tramite Sushi trait.

**Caratteristiche:**
- 8.000+ comuni italiani
- Dati completi con coordinate, popolazione, altitudine
- File JSON di 1.8MB con tutti i dati
- Metodi di ricerca ottimizzati

**API Principale:**
```php
// Ricerca per regione
$regioni = Comune::getRegioni();

// Province di una regione
$province = Comune::getProvinceByRegione('Lombardia');

// Comuni di una provincia
$comuni = Comune::getComuniByProvincia('Milano');

// Ricerca per nome
$milano = Comune::findByNome('Milano');

// Ricerca per CAP
$comuni = Comune::findByCap('20100');
```

## 🚨 Correzioni Critiche Implementate

### Dependency Cycle Fix (Dic 2024)
**Problema:** Loop infinito nel metodo `getJsonFile()` che causava crash dell'applicazione.

**Soluzione:** Sostituito `module_path()` con `base_path()` diretto per evitare circular dependency.

**File Coinvolti:**
- `/app/Models/Comune.php` (linea 105)
- Documentazione: `/docs/sushi-models-dependency-cycle-fix.md`

**Impatto:** Sistema completamente funzionale, form geografici operativi.

## 📂 Struttura File

```
Modules/Geo/
├── app/
│   └── Models/
│       ├── BaseModel.php
│       └── Comune.php ⭐ (Modello principale)
├── resources/
│   └── json/
│       └── comuni.json (1.8MB - Dati geografici)
└── docs/
    ├── README.md (questo file)
    └── sushi-models-dependency-cycle-fix.md
```

## 🔗 Integrazione con Altri Moduli

### Filament Forms
Il modulo si integra perfettamente con i form Filament per:
- Select gerarchici (Regione → Provincia → Comune)
- Autocomplete per ricerca comuni
- Validazione CAP

### SaluteOra Registration
Utilizzato nei form di registrazione per:
- Selezione studio medico per ubicazione
- Localizzazione pazienti e dottori
- Gestione indirizzi strutture sanitarie

## 🧪 Testing

### Test di Funzionalità Base
```php
// Verifica caricamento dati
$count = \Modules\Geo\Models\Comune::count();
// Dovrebbe restituire > 8000

// Test ricerca
$milano = \Modules\Geo\Models\Comune::findByNome('Milano');
// Dovrebbe restituire oggetto Comune con dati completi
```

### Performance Test
Il modello è ottimizzato per:
- Caricamento iniziale < 100ms
- Ricerche < 10ms
- Uso memoria < 50MB per dataset completo

## 🔧 Manutenzione

### Aggiornamento Dati
Per aggiornare i dati geografici:
1. Sostituire `/resources/json/comuni.json`
2. Verificare formato JSON
3. Test di caricamento
4. Deploy

### Monitoring
Monitorare:
- Tempo di caricamento modello
- Memory usage durante ricerche
- Errori di path resolution

## 🔗 Collegamenti

- [Correzione Dependency Cycle](sushi-models-dependency-cycle-fix.md)
- [Regole Sushi Models](../../.cursor/rules/sushi-models-dependency-cycle-prevention.mdc)
- [Modello Comune](/app/Models/Comune.php)

---

**Ultimo aggiornamento**: Dicembre 2024  
**Stato**: ✅ Funzionale  
**Criticità**: Modulo core per geografica
