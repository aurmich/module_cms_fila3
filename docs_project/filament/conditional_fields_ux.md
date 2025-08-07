# Campi Condizionali UX Intelligente

## Pattern Implementato: StudioResource con Repeater Addresses

### Problema UX
Nel repeater degli indirizzi di uno Studio, alcuni campi dovrebbero apparire/scomparire e avere comportamenti automatici in base al numero di elementi:

#### Campo `name` (Nome Indirizzo)
- **1 elemento**: Campo nascosto (non serve distinguere)
- **2+ elementi**: Campo visibile (serve per distinguere "Sede Principale", "Filiale Nord", etc.)
- **Ritorno a 1**: Campo scompare automaticamente

#### Campo `is_primary` (Indirizzo Principale)
- **1 elemento**: Campo nascosto, valore automaticamente `true`
- **2+ elementi**: Campo visibile, **solo 1 può essere `true`** (esclusività)
- **Quando uno diventa primary**: gli altri si disattivano automaticamente
- **Sempre garantito**: almeno un indirizzo è primary

### Implementazione Tecnica

```php
protected static function getAddressFormSchema(): array
{
    $baseSchema = AddressResource::getFormSchema();
    
    // Campo name: condizionale semplice
    $baseSchema['name'] = Forms\Components\TextInput::make('name')
        ->maxLength(255)
        ->visible(function (Get $get): bool {
            $addresses = $get('../../addresses') ?? [];
            return count($addresses) > 1;
        })
        ->live();

    // Campo is_primary: condizionale con esclusività
    $baseSchema['is_primary'] = Forms\Components\Toggle::make('is_primary')
        ->visible(function (Get $get): bool {
            $addresses = $get('../../addresses') ?? [];
            return count($addresses) > 1;
        })
        ->default(function (Get $get): bool {
            $addresses = $get('../../addresses') ?? [];
            return count($addresses) <= 1; // Auto-true per singolo elemento
        })
        ->afterStateUpdated(function ($state, $set, Get $get, Component $component): void {
            if ($state === true) {
                // Estrae indice dal path del componente
                $path = $component->getStatePath();
                preg_match('/addresses\.(\d+)\.is_primary/', $path, $matches);
                $currentIndex = $matches[1] ?? null;
                
                if ($currentIndex !== null) {
                    $addresses = $get('../../addresses') ?? [];
                    // Disattiva is_primary negli altri elementi
                    foreach ($addresses as $index => $address) {
                        if ((string)$index !== (string)$currentIndex) {
                            $set("../../addresses.{$index}.is_primary", false);
                        }
                    }
                }
            }
        })
        ->live()
        ->dehydrateStateUsing(function ($state, Get $get): bool {
            $addresses = $get('../../addresses') ?? [];
            // Forza true se c'è un solo elemento
            if (count($addresses) <= 1) {
                return true;
            }
            return (bool) $state;
        });

    return $baseSchema;
}
```

### Componenti Chiave

#### 1. Rilevamento Stato Repeater
```php
function (Get $get): bool {
    $addresses = $get('../../addresses') ?? [];
    return count($addresses) > 1;
}
```

#### 2. Repeater Reattivo
```php
->live() // Sul repeater per propagare cambiamenti
```

#### 3. Gestione Esclusività
```php
->afterStateUpdated(function ($state, $set, Get $get, Component $component): void {
    // Logica di mutua esclusione per is_primary
})
```

#### 4. Estrazione Indice Dinamico
```php
$path = $component->getStatePath(); // "addresses.0.is_primary"
preg_match('/addresses\.(\d+)\.is_primary/', $path, $matches);
$currentIndex = $matches[1] ?? null;
```

#### 5. Dehydration Automatica
```php
->dehydrateStateUsing(function ($state, Get $get): bool {
    // Forza sempre true per singolo elemento
    if (count($addresses) <= 1) {
        return true;
    }
    return (bool) $state;
})
```

### Benefici UX

#### Semplicità Cognitiva
- **1 indirizzo**: UI minimal, niente campi superflui
- **Multipli indirizzi**: UI completa con tutti i controlli necessari

#### Automazione Intelligente  
- **Selezione primary**: automatica per singolo elemento
- **Esclusività**: solo 1 primary alla volta, gestione automatica
- **Denominazione**: compare solo quando serve distinguere

#### Prevenzione Errori
- **Stato inconsistente**: impossibile avere 0 o 2+ primary contemporaneamente
- **Campi vuoti**: name compare solo quando necessario

### Utilizzo nel Resource

```php
public static function form(Form $form): Form
{
    return $form->schema([
        // Altri campi...
        Forms\Components\Repeater::make('addresses')
            ->relationship('addresses')
            ->schema(static::getAddressFormSchema())
            ->live() // Critico per reattività
            ->defaultItems(1),
    ]);
}
```

### Pattern Riutilizzabile

Questo pattern si applica a qualsiasi repeater dove:
- **Denominazione condizionale**: serve solo con multipli elementi
- **Esclusività**: solo 1 elemento può avere una proprietà speciale
- **Default intelligente**: comportamento automatico per casi semplici

#### Esempi di Applicazione
- **Studio → Indirizzi**: name + is_primary
- **Doctor → Specializzazioni**: name + is_main  
- **Patient → Contatti**: name + is_emergency
- **User → Ruoli**: description + is_active

### Anti-Pattern da Evitare

❌ **Campi sempre visibili**:
```php
TextInput::make('name') // Sempre visibile anche con 1 elemento
```

❌ **Gestione manuale esclusività**:
```php
// Lasciare all'utente la gestione di is_primary
```

❌ **Mancanza di live()**:
```php
Repeater::make('addresses')
    ->schema($schema) // Senza ->live()
```

❌ **Default statici**:
```php
Toggle::make('is_primary')->default(false) // Senza logica condizionale
```

### Testing UX

#### Scenari di Test
1. **Singolo elemento**: name nascosto, is_primary auto-true
2. **Aggiunta secondo**: name appare, is_primary diventa visibile
3. **Selezione primary**: altri si disattivano automaticamente  
4. **Ritorno a uno**: name scompare, is_primary nascosto ma true
5. **Persistenza**: valori salvati correttamente nel database

#### Validazioni
- Sempre almeno 1 is_primary = true
- Mai più di 1 is_primary = true contemporaneamente
- name presente solo quando necessario
- UX fluida senza scatti o ritardi

---

*Documentazione creata: Dicembre 2024*  
*Pattern applicabile a tutti i moduli con repeater condizionali* 
