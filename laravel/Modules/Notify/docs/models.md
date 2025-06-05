# Modelli nel Modulo Notify

## Struttura dei Modelli

### Gerarchia di Ereditarietà
```
Illuminate\Database\Eloquent\Model
└── Modules\Xot\Models\XotBaseModel
    └── Modules\Notify\Models\BaseModel
        └── Modules\Notify\Models\NotificationTemplate
        └── Altri modelli del modulo
```

### BaseModel
La classe `BaseModel` è una classe astratta che fornisce funzionalità comuni a tutti i modelli del modulo Notify.
Si trova nello stesso namespace dei modelli che la estendono (`Modules\Notify\Models`).

#### Caratteristiche
- Estende `XotBaseModel` che fornisce funzionalità base comuni a tutti i moduli
- Implementa `HasMedia` per la gestione dei media
- Include trait comuni come `HasFactory`, `InteractsWithMedia`, `Updater`
- Configura la connessione al database specifica del modulo (`notify`)
- Definisce proprietà e metodi base comuni

#### Perché non estendere direttamente Model?
1. **Coerenza del Modulo**: 
   - Ogni modulo ha il suo `BaseModel` con configurazioni specifiche
   - Garantisce uniformità tra i modelli dello stesso modulo
   - Centralizza le configurazioni comuni

2. **Namespace e Autoloading**:
   - Il `BaseModel` è nello stesso namespace dei modelli che lo estendono
   - Non richiede import esplicito (`use`) grazie al namespace comune
   - Migliora la leggibilità e manutenibilità del codice

3. **Funzionalità Specifiche**:
   - Ogni modulo può avere requisiti specifici implementati nel suo `BaseModel`
   - Facilita l'aggiunta di funzionalità a tutti i modelli del modulo
   - Permette override controllato dei metodi base

4. **Gestione delle Dipendenze**:
   - Il `BaseModel` può includere trait e interfacce necessarie
   - Centralizza la gestione delle dipendenze del modulo
   - Riduce la duplicazione del codice

## Best Practices

1. **Estensione Corretta**:
   ```php
   // ❌ ERRATO: Non estendere Model direttamente
   class NotificationTemplate extends Model
   
   // ✅ CORRETTO: Estendere BaseModel del modulo
   class NotificationTemplate extends BaseModel
   ```

2. **Namespace**:
   ```php
   namespace Modules\Notify\Models;
   
   // BaseModel è nello stesso namespace, non serve use
   class NotificationTemplate extends BaseModel
   ```

3. **Configurazioni**:
   - Usare il `BaseModel` per configurazioni comuni del modulo
   - Override solo quando necessario
   - Mantenere la coerenza delle configurazioni

## NotificationTemplate

### Panoramica
NotificationTemplate è il modello base per la gestione dei template delle notifiche. Estende `BaseModel` e implementa le funzionalità necessarie per la gestione dei template.

### Proprietà
- `id`: int - ID univoco del template
- `name`: string - Nome del template
- `code`: string - Codice univoco del template
- `description`: string|null - Descrizione del template
- `subject`: string - Oggetto dell'email
- `body_html`: string|null - Contenuto HTML dell'email
- `body_text`: string|null - Contenuto testuale dell'email
- `channels`: array - Canali di invio supportati
- `variables`: array - Variabili disponibili nel template
- `conditions`: array|null - Condizioni di invio
- `preview_data`: array|null - Dati per l'anteprima
- `metadata`: array|null - Metadati aggiuntivi
- `category`: string|null - Categoria del template
- `is_active`: bool - Indica se il template è attivo
- `version`: int - Versione corrente del template
- `tenant_id`: int|null - Tenant associato al template
- `grapesjs_data`: array|null - Dati dell'editor GrapesJS

### Relazioni
- `versions`: HasMany - Versioni del template
- `logs`: HasMany - Log delle notifiche inviate

### Metodi Principali
- `createNewVersion(string $createdBy, ?string $notes = null)`: self - Crea una nuova versione del template
- `compile(array $data = [])`: array - Compila il template con i dati forniti
- `shouldSend(array $data = [])`: bool - Verifica se la notifica deve essere inviata
- `preview(array $data = [])`: array - Anteprima del template con i dati forniti

### Scope
- `scopeActive($query)`: Query - Filtra i template attivi
- `scopeForChannel($query, string $channel)`: Query - Filtra i template per canale
- `scopeForCategory($query, string $category)`: Query - Filtra i template per categoria

### Traduzioni
Le traduzioni sono gestite tramite il file `resources/lang/it/template.php` e seguono la struttura:
```php
'fields' => [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome del template',
    ],
    // ...
],
'actions' => [
    'create' => [
        'label' => 'Crea Template',
        'icon' => 'heroicon-o-plus',
        'color' => 'primary',
    ],
    // ...
],
```

### Best Practices Seguite
1. **Estensione Corretta**
   - Estende `BaseModel` dallo stesso namespace
   - Non richiede use statement per la classe base
   - Segue le convenzioni di namespace

2. **Gestione Cast**
   - Utilizza il metodo `casts()` invece della proprietà `$casts`
   - Mantiene i cast del modello base con `parent::casts()`
   - Definisce tipi appropriati per i campi

3. **Struttura Namespace**
   - Segue la struttura standard dei moduli
   - Non include `app` nel namespace
   - Mantiene coerenza con altri modelli

4. **Documentazione**
   - PHPDoc completo per classe, proprietà e metodi
   - Tipizzazione precisa dei parametri e dei valori di ritorno
   - Esempi di utilizzo e best practices

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura dei Modelli](../../../../docs/architecture/models.md)
- [Gestione Notifiche](../../../../docs/architecture/notifications.md)

### Collegamenti ai Moduli
- [XotBaseModel](../../Xot/docs/XotBaseModel.md)
- [Gestione Template](../template-management.md)

## Note Importanti

1. I modelli estendono sempre BaseModel dallo stesso namespace
2. I cast sono gestiti tramite il metodo `casts()`
3. Il namespace non include il segmento `app`
4. Le relazioni sono definite in modo tipizzato
5. La documentazione è mantenuta aggiornata
6. Le traduzioni seguono la struttura standard con label, placeholder e tooltip
### Versione HEAD

7. Le azioni includono icon e color per una migliore UX 

### Versione Incoming

7. Le azioni includono icon e color per una migliore UX 
## Collegamenti tra versioni di models.md
* [models.md](../../Xot/docs/architecture/models.md)


---

