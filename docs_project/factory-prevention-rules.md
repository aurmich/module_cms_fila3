# Regole di Prevenzione Factory - SaluteOra

## Errore Gravissimo del 2025-01-06

**NEVER AGAIN**: 35+ factory mancanti identificate  
**LESSON LEARNED**: Ogni model DEVE avere la sua factory

## Regole Obbligatorie

### 1. Factory per Ogni Model
```bash
# REGOLA ASSOLUTA
Model creato = Factory obbligatoria
```

### 2. Validazione PHPStan Livello 9
```bash
# SEMPRE eseguire per ogni factory
./vendor/bin/phpstan analyze path/to/Factory.php --level=9
```

### 3. Tipizzazione Rigorosa
```php
// CORRETTO
/** @var string $value */
$value = (string) $this->faker->randomElement($array);
$formatted = sprintf('%s %s', $value1, (string) $value2);

// ERRATO  
$value = $this->faker->randomElement($array);
$formatted = "{$value1} {$value2}";
```

### 4. Struttura Obbligatoria
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ModuleName\Models\ModelName;

/**
 * ModelName Factory
 * 
 * @extends Factory<ModelName>
 */
class ModelNameFactory extends Factory
{
    protected $model = ModelName::class;

    public function definition(): array
    {
        return [
            // Dati tipizzati
        ];
    }

    // Stati specifici per testing
    public function active(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'active',
        ]);
    }
}
```

### 5. Integrazione Model
```php
// Nel Model
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelName extends BaseModel
{
    use HasFactory;
    
    // GetFactoryAction di Xot gestisce automaticamente
    // Non serve newFactory() se si usa GetFactoryAction
}
```

## Checklist Obbligatoria

### Pre-Commit
- [ ] Ogni nuovo model ha factory corrispondente
- [ ] Factory validata PHPStan livello 9
- [ ] HasFactory aggiunto al model
- [ ] Factory testata con tinker
- [ ] Documentazione aggiornata

### Code Review
- [ ] Bloccare PR senza factory per nuovi model
- [ ] Verificare tipizzazione corretta
- [ ] Controllare stati factory per testing
- [ ] Validare documentazione aggiornata

### CI/CD
```bash
# Script controllo factory mancanti
#!/bin/bash
for model in $(find Modules/*/app/Models/*.php -not -name "Base*"); do
    factory="${model/app\/Models/database/factories}"
    factory="${factory/.php/Factory.php}"
    if [[ ! -f "$factory" ]]; then
        echo "❌ ERRORE: Factory mancante per $model"
        exit 1
    fi
done
echo "✅ Tutte le factory presenti"
```

## Situazione Attuale (2025-01-06)

### ✅ Factory Critiche Completate
- **User**: 8/17 (AuthenticationFactory, MembershipFactory, TeamUserFactory, etc.)
- **Geo**: 4/8 (AddressFactory, PlaceFactory, LocationFactory, PlaceTypeFactory)
- **Media**: 2/2 (MediaFactory, TemporaryUploadFactory)
- **Activity**: 2/2 (SnapshotFactory, StoredEventFactory)

### ⚠️ Factory Rimanenti
- **User**: 9 factory rimanenti
- **Geo**: 4 factory rimanenti
- **Altri**: 6 factory rimanenti (Cms, Lang, Notify, Xot)

## Automazione Implementata

### GetFactoryAction di Xot
- Gestisce automaticamente factory resolution
- Non serve implementare newFactory() manualmente
- Integrazione seamless con Laravel factory system

### Tipizzazione Avanzata
- Cast espliciti per PHPStan: `(string)`, `(array)`
- Annotations: `/** @var string $variable */`
- sprintf() per string formatting sicuro
- Gestione optional() con null coalescing

## Best Practices Apprese

### 1. Dati Realistici Italiani
```php
// Per SaluteOra - dati sanitari italiani
$italianCities = ['Roma', 'Milano', 'Napoli', ...];
$cap = $this->faker->regexify('[0-9]{5}'); // CAP italiano
$coordinates = $this->faker->latitude(35.0, 47.0); // Italia
```

### 2. Relazioni Corrette
```php
// Foreign key con factory
'user_id' => User::factory(),
'team_id' => Team::factory(),

// Stati per testing
public function active(): static
public function inactive(): static
public function pending(): static
```

### 3. Gestione Errori
- Verificare sempre che enum cases esistano
- Gestire optional() correttamente  
- Cast espliciti per evitare mixed types
- Validazione con PHPStan livello 9

## Prevenzione Assoluta

### NEVER AGAIN
1. ❌ **MAI** creare model senza factory
2. ❌ **MAI** pushare codice senza validazione PHPStan
3. ❌ **MAI** ignorare factory mancanti in code review
4. ❌ **MAI** deployare senza verificare factory

### ALWAYS DO
1. ✅ **SEMPRE** creare factory con model
2. ✅ **SEMPRE** validare con PHPStan livello 9
3. ✅ **SEMPRE** documentare nelle cartelle docs
4. ✅ **SEMPRE** testare factory con tinker

## Collegamenti Critici

- [User Factory Lessons](../laravel/Modules/User/docs/factory-lessons-learned.md)
- [Factory Audit 2025](./factory-audit-2025.md)
- [PHPStan Factory Rules](./phpstan-factory-rules.md)

---

**⚠️ QUESTO ERRORE NON SI RIPETERÀ MAI PIÙ**

La qualità del codice dipende dalle factory funzionanti.

*Ultimo aggiornamento: 2025-01-06*
