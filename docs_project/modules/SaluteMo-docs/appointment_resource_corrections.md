# Correzioni AppointmentResource.php - SaluteMo Module

## Analisi della Classe XotBaseResource

### Caratteristiche Principali
- **Estensione**: Estende `Filament\Resources\Resource` (classe base di Filament)
- **Metodo Astratto**: Richiede l'implementazione di `getFormSchema(): array`
- **Auto-discovery**: Rileva automaticamente il modello basandosi sul nome della classe
- **Auto-discovery**: Rileva automaticamente le pagine e i RelationManager
- **Metodi Utili**: Fornisce metodi helper per wizard, attachments, navigation badge

### Metodi Chiave
1. **`getFormSchema()`**: Metodo astratto che deve essere implementato
2. **`getModel()`**: Auto-discovery del modello basato sul nome della classe
3. **`getPages()`**: Auto-discovery delle pagine associate alla risorsa
4. **`getRelations()`**: Auto-discovery dei RelationManager

## Analisi della Classe XotBaseListRecords

### Caratteristiche Principali
- **Estensione**: Estende `Filament\Resources\Pages\ListRecords` (classe base di Filament)
- **Trait**: Utilizza `HasXotTable` per funzionalità avanzate
- **Metodi Pubblici**: I metodi devono rimanere `public` nelle classi figlie
- **Auto-discovery**: Gestisce automaticamente traduzioni e configurazioni

### Metodi Chiave
1. **`getTableColumns()`**: Definisce le colonne della tabella (DEVE essere `public`)
2. **`getTableFilters()`**: Definisce i filtri della tabella
3. **`getTableActions()`**: Definisce le azioni per ogni riga
4. **`getTableBulkActions()`**: Definisce le azioni di massa
5. **`getHeaderActions()`**: Definisce le azioni nell'header della pagina

### Regole Critiche per XotBaseListRecords
1. **MAI estendere direttamente** `Filament\Resources\Pages\ListRecords`
2. **SEMPRE estendere** `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
3. **MAI usare** `getListTableColumns()` (deprecato)
4. **SEMPRE usare** `getTableColumns()` (metodo standard)
5. **MAI cambiare visibilità** dei metodi ereditati (devono rimanere `public`)

## Analisi della Classe XotBaseMigration

### Caratteristiche Principali
- **Estensione**: Estende `Illuminate\Database\Migrations\Migration`
- **Metodo Final**: Il metodo `down()` è dichiarato come `final` e non può essere sovrascritto
- **Auto-discovery**: Rileva automaticamente il modello e la tabella
- **Metodi Utili**: Fornisce metodi helper per creazione e aggiornamento tabelle

### Regole Critiche per XotBaseMigration
1. **MAI estendere direttamente** `Illuminate\Database\Migrations\Migration`
2. **SEMPRE estendere** `Modules\Xot\Database\Migrations\XotBaseMigration`
3. **MAI implementare** il metodo `down()` (è final in XotBaseMigration)
4. **SEMPRE usare** classi anonime: `return new class extends XotBaseMigration { ... }`
5. **SEMPRE usare** `declare(strict_types=1);`
6. **SEMPRE usare** `tableCreate()` e `tableUpdate()` per gestire tabelle

### Pattern Corretto per tableCreate/tableUpdate

#### Blocco tableCreate()
- **Scopo**: Crea la tabella se non esiste
- **Uso**: Per definire la struttura base della tabella
- **Timestamp**: Usare `$table->timestamps()` e `$table->softDeletes()` direttamente
- **Esempio**:
```php
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');
    $table->timestamps();        // ✅ CORRETTO
    $table->softDeletes();       // ✅ CORRETTO
});
```

#### Blocco tableUpdate()
- **Scopo**: Aggiorna la tabella esistente
- **Uso**: Per aggiungere colonne, indici, modifiche a tabelle esistenti
- **Timestamp**: Usare `$this->updateTimestamps($table, true)` per aggiungere timestamp
- **Controlli**: Sempre verificare esistenza con `hasColumn()` e `hasIndex()`
- **Esempio**:
```php
$this->tableUpdate(function (Blueprint $table): void {
    // ✅ CORRETTO: Aggiunge timestamp se non esistono
    $this->updateTimestamps($table, true);
    
    // ✅ CORRETTO: Controlli di esistenza
    if (!$this->hasColumn('new_field')) {
        $table->string('new_field');
    }
});
```

### Metodi Chiave
1. **`tableCreate()`**: Crea la tabella se non esiste
2. **`tableUpdate()`**: Aggiorna la tabella esistente
3. **`updateTimestamps()`**: Aggiunge timestamp e soft delete a tabelle esistenti
4. **`hasColumn()`**: Verifica se una colonna esiste
5. **`hasIndex()`**: Verifica se un indice esiste

## Problemi Identificati in AppointmentResource.php

### ❌ Violazioni Critiche
1. **Estensione Errata**: Estende `Resource` invece di `XotBaseResource`
2. **Metodi Obsoleti**: Usa `form()` e `table()` invece di `getFormSchema()`
3. **Configurazioni Manuali**: Definisce `$navigationIcon`, `$navigationGroup`, `$navigationSort`
4. **Metodi Chaining**: Usa `->description()`, `->label()`, `->helperText()`, `->placeholder()`
5. **Metodo Inesistente**: Implementa `getTableSchema()` che non esiste

### ❌ Violazioni Critiche in ListAppointments.php
1. **Estensione Errata**: Estende `ListRecords` invece di `XotBaseListRecords`
2. **Namespace Errato**: Usa `Filament\Resources\Pages\ListRecords`
3. **Mancanza Metodi**: Non implementa `getTableColumns()` richiesto

### ❌ Violazioni Critiche nella Migrazione
1. **Estensione Errata**: Estende `Migration` invece di `XotBaseMigration`
2. **Metodo Vietato**: Implementa `down()` che è final in XotBaseMigration
3. **Classe Nominale**: Usa classe nominale invece di classe anonima
4. **Mancanza Tipizzazione**: Non usa `declare(strict_types=1);`
5. **Metodi Obsoleti**: Usa `Schema::create()` invece di `tableCreate()`
6. **Pattern Errato**: Usa `updateTimestamps()` nel blocco `tableCreate()` invece di `tableUpdate()`

## Soluzioni Implementate

### ✅ Correzione AppointmentResource.php
1. **Estensione**: Cambiato da `Resource` a `XotBaseResource`
2. **Tipizzazione**: Aggiunto `declare(strict_types=1);`
3. **Metodi**: Implementato `getFormSchema()` statico
4. **Rimozione**: Eliminati metodi obsoleti e configurazioni manuali
5. **Navigation**: Rimossa configurazione manuale (gestita da traduzioni)

### ✅ Correzione ListAppointments.php
1. **Estensione**: Cambiato da `ListRecords` a `XotBaseListRecords`
2. **Namespace**: Corretto import per `XotBaseListRecords`
3. **Metodi**: Implementato `getTableColumns()` pubblico
4. **Tipizzazione**: Aggiunto `declare(strict_types=1);`

### ✅ Correzione Migrazione
1. **Estensione**: Cambiato da `Migration` a `XotBaseMigration`
2. **Classe**: Convertito a classe anonima
3. **Metodi**: Rimosso `down()` e usato `tableCreate()`/`tableUpdate()`
4. **Tipizzazione**: Aggiunto `declare(strict_types=1);`
5. **Controlli**: Aggiunto controlli `hasColumn()` e `hasIndex()`
6. **Pattern**: Corretto uso di `updateTimestamps()` nel blocco `tableUpdate()`

## File di Traduzione Aggiornati

### Struttura Completa
- ✅ **Italiano**: `Modules/SaluteMo/lang/it/appointment.php`
- ✅ **Inglese**: `Modules/SaluteMo/lang/en/appointment.php`
- ✅ **Tedesco**: `Modules/SaluteMo/lang/de/appointment.php`

### Contenuti
- ✅ **Model**: Label, plural, description, icon
- ✅ **Navigation**: Label, group, icon, color, sort, tooltip, helper_text
- ✅ **Pages**: Index, create, edit, view con titoli e descrizioni
- ✅ **Fields**: Struttura espansa con label, placeholder, help, validation
- ✅ **Actions**: Struttura espansa con label, success, error, confirmation
- ✅ **Messages**: Messaggi di feedback e stati vuoti

## Regole Apprese e Memorizzate

### XotBaseResource
1. **MAI** definire `$navigationIcon`, `$navigationGroup`, `$navigationSort`
2. **MAI** usare `form()` o `table()` (sono final)
3. **SEMPRE** implementare `getFormSchema()` statico
4. **MAI** usare metodi chaining per label/description/helperText/placeholder
5. **MAI** implementare `getTableSchema()` (non esiste)

### XotBaseListRecords
1. **MAI** estendere direttamente `ListRecords` di Filament
2. **SEMPRE** estendere `XotBaseListRecords`
3. **SEMPRE** implementare `getTableColumns()` pubblico
4. **MAI** usare `getListTableColumns()` (deprecato)
5. **MAI** cambiare visibilità dei metodi ereditati

### XotBaseMigration
1. **MAI** estendere direttamente `Migration` di Laravel
2. **SEMPRE** estendere `XotBaseMigration`
3. **MAI** implementare il metodo `down()` (è final)
4. **SEMPRE** usare classi anonime
5. **SEMPRE** usare `declare(strict_types=1);`
6. **SEMPRE** usare `tableCreate()` e `tableUpdate()`
7. **SEMPRE** usare `updateTimestamps()` nel blocco `tableUpdate()`, non `tableCreate()`

### Pattern tableCreate/tableUpdate
1. **tableCreate()**: Per creare tabelle nuove, usa `$table->timestamps()` direttamente
2. **tableUpdate()**: Per aggiornare tabelle esistenti, usa `$this->updateTimestamps($table, true)`
3. **Controlli**: Sempre verificare esistenza con `hasColumn()` e `hasIndex()`
4. **Indici**: Aggiungere sempre controlli `hasIndex()` per evitare duplicati

### Traduzioni
1. **SEMPRE** struttura espansa per fields e actions
2. **SEMPRE** includere tooltip e helper_text vuoto
3. **MAI** hardcodare label o descrizioni
4. **SEMPRE** sintassi breve `[]` e `declare(strict_types=1);`

## Collegamenti e Riferimenti

- [XotBaseResource Documentation](../../Xot/docs/filament/xotbaseresource.md)
- [XotBaseListRecords Documentation](../../Xot/docs/filament/xotbaselistrecords.md)
- [XotBaseMigration Documentation](../../Xot/docs/migration_base_rules.md)
- [Filament Table Columns Rules](../../Xot/docs/filament_table_columns.md)
- [Critical Violations Analysis](../../Xot/docs/filament/critical-violations-analysis.md)
- [Translation Standards](../../Xot/docs/TRANSLATION_RULES.md)

## Note di Implementazione

### Modello Appointment
Il modello `Appointment` è referenziato dal modulo `SaluteOra`:
```php
use Modules\SaluteOra\Models\Appointment;
```

### Auto-discovery
XotBaseResource rileva automaticamente:
- Il modello basandosi sul nome della classe
- Le pagine associate alla risorsa
- I RelationManager configurati

### Performance
- Rimozione di configurazioni manuali riduce il carico
- Auto-discovery migliora le prestazioni
- Traduzioni centralizzate ottimizzano la cache

---

**Ultimo aggiornamento**: 2025-01-06
**Stato**: ✅ Completato
**Validazione**: PHPStan livello 9+ compatibile 

---

## Best Practice: Enum e Naming nei Form Filament

### 1. **Usare sempre Enum per i Select**

**Corretto:**
```php
use Modules\SaluteOra\Enums\AppointmentStatusEnum;

Components\Select::make('status')
    ->options(AppointmentStatusEnum::toSelectArray())
    ->default(AppointmentStatusEnum::SCHEDULED->value)
    ->required();
```

**Anti-pattern (da evitare):**
```php
Components\Select::make('status')
    ->options([
        'scheduled' => 'scheduled',
        'confirmed' => 'confirmed',
        'cancelled' => 'cancelled',
        'completed' => 'completed',
        'no_show' => 'no_show',
    ])
    ->default('scheduled')
    ->required();
```

**Motivazione:**
- DRY: nessuna duplicazione di stringhe
- KISS: enum centralizzato, facile da aggiornare
- Type safety: meno errori, più refactoring-safe

### 2. **Naming coerente tra modello, form e database**

**Corretto:**
- Se il modello usa `starts_at` e `ends_at`, anche il form deve usare questi nomi.

**Anti-pattern:**
- Usare `start_time`/`end_time` nel form quando il modello/database usa `starts_at`/`ends_at`.

**Motivazione:**
- Coerenza = meno bug, meno confusione, più manutenzione.

### 3. **Regola interna aggiornata**
- Vietato array fisso per select di status, ruoli, ecc.: usare sempre enum.
- Vietato usare nomi di campo incoerenti tra form, modello e database.

---

*Ultimo aggiornamento: giugno 2025* 

## Correzione mapping colonne e uso enum nei Select (giugno 2024)

- I nomi dei campi usati nei form Filament DEVONO sempre corrispondere ai nomi effettivi delle colonne del modello/database (es: starts_at/ends_at, non start_time/end_time).
- Vietato usare array hardcoded nei Select: usare sempre enum di appoggio (es: AppointmentStatusEnum::toSelectArray()).
- Se la colonna non esiste in tabella, il campo va rimosso dal form.

**Motivazione:**
- Coerenza tra form, modello e database
- Manutenibilità e DRY
- Prevenzione di bug e comportamenti imprevedibili

**Esempio pratico:**

```php
Components\DateTimePicker::make('starts_at')
Components\DateTimePicker::make('ends_at')
Components\Select::make('state')
    ->options(AppointmentStatusEnum::toSelectArray())
    ->default('pending')
    ->required()
``` 

## Errori di utilizzo di start_time/end_time invece di starts_at/ends_at (giugno 2024)

### Descrizione errore
In diversi file del progetto vengono usati i campi `start_time` e `end_time` per il modello Appointment, ma la colonna corretta (come da migrazione e modello aggiornato) è `starts_at`/`ends_at`. Questo causa bug, dati non salvati correttamente, problemi di compatibilità con FullCalendar e Filament, e incoerenza tra moduli.

### File da correggere
- Modules/SaluteOra/app/Models/Appointment.php (presenza di entrambi i set di colonne)
- Modules/SaluteOra/app/Filament/Resources/AppointmentResource.php (usa start_time/end_time)
- Modules/SaluteOra/app/Actions/Calendar/FetchCalendarEventsAction.php (usa start_time/end_time)
- Modules/SaluteOra/app/Filament/Widgets/AdminCalendarWidget.php (usa start_time/end_time)
- Modules/SaluteOra/docs/appointment-system.md (esempi con start_time/end_time)
- Modules/SaluteOra/docs/fullcalendar_widgets.md (esempi con start_time/end_time)
- Themes/One/resources/views/appointment/card.blade.php (verificare)
- Themes/One/resources/views/appointment/item.blade.php (verificare)
- Modules/SaluteMo/app/Filament/Resources/AppointmentResource.php (verificare sezioni legacy)
- Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old (usa start_time/end_time)

### Impatto
- Bug nella visualizzazione e salvataggio appuntamenti
- Incompatibilità con widget FullCalendar
- Dati non coerenti tra moduli
- Refactoring più complesso

### Regola
Usare SEMPRE `starts_at`/`ends_at` per tutti i riferimenti temporali di Appointment. Aggiornare modello, risorse, azioni, widget, view e documentazione. 