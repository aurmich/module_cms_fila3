# Studio Address Repeater - Campo Name Condizionale

## Problema
Nel `StudioResource`, il repeater degli indirizzi utilizzava direttamente lo schema dell'`AddressResource`, mostrando sempre il campo `name` anche quando c'era un solo indirizzo. L'utente voleva che il campo `name` venisse visualizzato solo quando ci sono più di 1 elemento nel repeater.

## Filosofia e Motivazione
- **Filosofia**: UX intelligente che mostra i campi solo quando sono necessari per distinguere elementi multipli.
- **Logica**: Se c'è un solo indirizzo, il nome non serve per distinguerlo; se ce ne sono più di uno, il nome aiuta a identificarli.
- **Religione**: "Non mostrare campi inutili all'utente finale".
- **Politica**: UI pulita e contestuale, che si adatta dinamicamente al contenuto.
- **Zen**: Serenità nell'editing dei form, interfaccia che respira e si adatta.

## Soluzione Implementata

### 1. Schema Personalizzato per il Repeater
Invece di utilizzare direttamente `AddressResource::getFormSchema()`, ho creato un metodo personalizzato `getAddressFormSchema()` che:

- Ottiene lo schema base dall'AddressResource
- Modifica il campo `name` per renderlo condizionale
- Mantiene tutti gli altri campi identici all'originale

### 2. Logica Condizionale del Campo Name
```php
$baseSchema['name'] = Forms\Components\TextInput::make('name')
    ->maxLength(255)
    ->visible(function (Get $get): bool {
        $addresses = $get('../../addresses') ?? [];
        return count($addresses) > 1;
    })
    ->live();
```

### 3. Configurazione Repeater Reattivo
```php
'addresses' => Forms\Components\Repeater::make('addresses')
    ->relationship('addresses')
    ->schema(static::getAddressFormSchema())
    ->columnSpanFull()
    ->defaultItems(1)
    ->live()
    ->addActionLabel('Aggiungi Indirizzo'),
```

## Pattern Tecnico

### Uso di `live()` e `visible()`
- **`live()`** sul repeater: permette aggiornamenti real-time quando si aggiungono/rimuovono elementi
- **`live()`** sul campo name: assicura che la visibilità si aggiorni immediatamente
- **`visible()`** con closure: logica dinamica basata sul contesto del form

### Path Navigation nel Get
- **`$get('../../addresses')`**: naviga due livelli sopra per accedere all'array degli indirizzi
- **Fallback `?? []`**: gestisce il caso in cui gli indirizzi non siano ancora inizializzati
- **`count($addresses) > 1`**: condizione che determina la visibilità

## Comportamento UX

### Scenario 1: Singolo Indirizzo (Default)
- Il repeater inizia con 1 elemento (defaultItems)
- Il campo `name` è **nascosto** perché non necessario
- L'utente vede solo i campi essenziali dell'indirizzo

### Scenario 2: Indirizzi Multipli
- L'utente clicca "Aggiungi Indirizzo"
- Il campo `name` **appare automaticamente** in tutti gli elementi
- L'utente può distinguere gli indirizzi con nomi descrittivi (es. "Sede Principale", "Filiale Nord")

### Scenario 3: Ritorno a Singolo Indirizzo
- Se l'utente rimuove indirizzi fino a lasciarne uno solo
- Il campo `name` **scompare automaticamente**
- L'interfaccia si pulisce e diventa più semplice

## Vantaggi della Soluzione

### 1. **UX Ottimizzata**
- Interfaccia pulita quando non serve complessità
- Campi contestuali che appaiono solo quando necessari
- Transizioni fluide senza confondere l'utente

### 2. **Manutenibilità**
- Schema base rimane nell'AddressResource (DRY)
- Customizzazioni isolate nel StudioResource
- Logica facilmente estendibile ad altri campi

### 3. **Consistenza**
- Tutti gli altri campi dell'AddressResource rimangono identici
- Stessa validazione e comportamento
- Nessuna duplicazione di codice

### 4. **Performance**
- Aggiornamenti real-time ma solo quando necessari
- Nessun overhead per form semplici
- Logica efficiente e diretta

## Possibili Estensioni

### 1. Altri Campi Condizionali
```php
// Esempio: campo 'description' visibile solo con più di 2 indirizzi
$baseSchema['description'] = Forms\Components\Textarea::make('description')
    ->visible(function (Get $get): bool {
        $addresses = $get('../../addresses') ?? [];
        return count($addresses) > 2;
    })
    ->live();
```

### 2. Validazione Condizionale
```php
// Nome obbligatorio solo se ci sono più indirizzi
$baseSchema['name'] = Forms\Components\TextInput::make('name')
    ->maxLength(255)
    ->visible(function (Get $get): bool {
        $addresses = $get('../../addresses') ?? [];
        return count($addresses) > 1;
    })
    ->required(function (Get $get): bool {
        $addresses = $get('../../addresses') ?? [];
        return count($addresses) > 1;
    })
    ->live();
```

### 3. Placeholder Dinamici
```php
$baseSchema['name'] = Forms\Components\TextInput::make('name')
    ->maxLength(255)
    ->placeholder(function (Get $get): string {
        $addresses = $get('../../addresses') ?? [];
        $currentIndex = count($addresses);
        return "Nome per indirizzo #{$currentIndex}";
    })
    ->visible(function (Get $get): bool {
        $addresses = $get('../../addresses') ?? [];
        return count($addresses) > 1;
    })
    ->live();
```

## Test Cases

### Test 1: Inizializzazione
- Aprire form Studio
- Verificare che il campo name NON sia visibile di default

### Test 2: Aggiunta Secondo Indirizzo
- Cliccare "Aggiungi Indirizzo"
- Verificare che il campo name appaia in entrambi gli elementi

### Test 3: Rimozione Fino a Uno
- Rimuovere tutti gli indirizzi tranne uno
- Verificare che il campo name scompaia

### Test 4: Salvataggio e Ricaricamento
- Salvare studio con più indirizzi con nomi
- Ricaricare il form
- Verificare che i nomi siano visibili e editabili

## Collegamenti
- [StudioResource.php](../app/Filament/Resources/StudioResource.php) - Implementazione principale
- [AddressResource.php](../../Geo/app/Filament/Resources/AddressResource.php) - Schema base degli indirizzi
- [filament-conditional-fields.md](../../../docs/filament-conditional-fields.md) - Pattern generali per campi condizionali

*Ultimo aggiornamento: giugno 2025*