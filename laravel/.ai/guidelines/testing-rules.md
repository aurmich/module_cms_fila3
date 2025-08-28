# Testing Rules - Regole Essenziali per i Test

## 🎯 Regola Fondamentale: SOLO Pest Tests

**TUTTI i test devono essere scritti in formato Pest.** 

### ✅ Cosa Fare
- Usare sempre la sintassi Pest: `it()`, `describe()`, `test()`
- Seguire il formato fluent: `expect()->toBe()`
- Utilizzare `uses()` per i trait e setup
- Organizzare i test in `describe()` blocks per business logic

### ❌ Cosa NON Fare
- **MAI** usare classi PHPUnit che estendono TestCase
- **MAI** usare annotazioni `@test` o `#[Test]`
- **MAI** usare `$this->assert*()` methods
- **MAI** creare test senza la struttura Pest

## 🚀 Configurazione Testing

### Environment File
Sempre usare `.env.testing` per la configurazione dei test:
```bash
# Esegui test con environment testing
php artisan test --env=testing

# Oppure setta APP_ENV=testing
APP_ENV=testing php artisan test
```

### Database Testing
```bash
# Usa SQLite per testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:

# O file temporaneo  
DB_DATABASE=/tmp/test.sqlite
```

## 🧪 Struttura Test Pest

### Esempio Corretto
```php
<?php

declare(strict_types=1);

use Modules\Example\Models\ExampleModel;

uses(\Tests\TestCase::class);

describe('Example Business Logic', function () {
    
    it('does something meaningful', function () {
        $result = ExampleModel::doBusinessLogic();
        
        expect($result)->toBeTrue()
            ->and($result)->toBeBoolean();
    });
    
    it('handles edge cases', function () {
        // Test edge cases here
    });
});
```

### Esempio SBAGLIATO (PHPUnit)
```php
<?php
// ❌ NON USARE QUESTA STRUTTURA
class ExampleTest extends TestCase
{
    #[Test]
    public function testSomething(): void
    {
        $this->assertTrue(true); // ❌ PHPUnit style
    }
}
```

## 🔧 Conversioni Comuni

### Da PHPUnit a Pest
```php
// PHPUnit
$this->assertEquals('expected', $actual);

// Pest  
expect($actual)->toBe('expected');

// PHPUnit
$this->assertCount(2, $array);

// Pest
expect($array)->toHaveCount(2);

// PHPUnit
$this->assertInstanceOf(ExpectedClass::class, $object);

// Pest
expect($object)->toBeInstanceOf(ExpectedClass::class);
```

## 📋 Checklist Conversione

- [ ] Rimuovere `extends TestCase`
- [ ] Rimuovere annotazioni `@test` o `#[Test]`
- [ ] Convertire `$this->assert*()` in `expect()->toBe*()`
- [ ] Aggiungere `uses(TestCase::class)`
- [ ] Usare `it()` invece di metodi pubblici
- [ ] Organizzare in `describe()` blocks
- [ ] Verificare funzionamento con `php artisan test`

## 🚨 Errori Comuni

### RefreshDatabase
**MAI USARE RefreshDatabase TRAIT**
```php
// ❌ SBAGLIATO
use Illuminate\Foundation\Testing\RefreshDatabase;

// ✅ CORRETTO: Usare database configurato senza refresh
```

### Direct Model Instantiation
```php
// ❌ SBAGLIATO: Non istanziare modelli complessi direttamente
$model = new ComplexModel();

// ✅ CORRETTO: Usare oggetti semplici o reflection
$data = (object) ['id' => 1, 'name' => 'test'];
```

## 🎯 Business Logic Focus

I test devono verificare **COMPORTAMENTO BUSINESS**, non implementazione:
- ✅ Testare cosa fa il codice per l'utente finale
- ✅ Testare risultati business attesi  
- ✅ Testare validazioni e regole business
- ❌ NON testare proprietà, metodi, trait implementation

## 📊 Monitoring

Controlla periodicamente che tutti i test siano in formato Pest:
```bash
# Conta test PHPUnit rimanenti
find Modules -name "*Test.php" -path "*/tests/*" | grep -v "Pest" | wc -l

# Dovrebbe essere 0
```
