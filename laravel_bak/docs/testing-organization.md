# Test Organization in Laraxot SaluteOra

## Introduzione

Questo documento definisce l'organizzazione dei test nel progetto Laraxot SaluteOra. **Tutti i test utilizzano Pest** come framework di testing, abbandonando completamente PHPUnit per una sintassi più moderna e leggibile.

## Framework di Testing: Pest

### Perché Pest?

Pest fornisce:
- **Sintassi più pulita e leggibile**
- **Better developer experience**
- **Expectation API potente**
- **Hook lifecycle (beforeEach, afterEach)**
- **Plugin ecosystem robusto**
- **100% compatibile con PHPUnit**

### Documentazione di Riferimento

- [Pest Documentation](https://pestphp.com/)
- [Pest Laravel Plugin](https://pestphp.com/docs/plugins/laravel)

## Regola Universale

**Se un test verifica codice da `Modules\{ModuleName}\*`, il test DEVE essere in `Modules/{ModuleName}/tests/`**

## Struttura per Modulo

### SaluteOra (Modulo Principale)
```
Modules/SaluteOra/tests/
├── Pest.php                    # Configurazione Pest per SaluteOra
├── TestCase.php                # TestCase base del modulo
├── Feature/                    # Test di integrazione
│   ├── HomepageContentTest.php
│   └── HomepageRequirementsTest.php
├── Unit/                       # Test unitari
│   └── Actions/
│       └── GenerateReportActionTest.php
└── Browser/                    # Test Dusk (se presenti)
```

### Cms (Modulo Frontend)
```
Modules/Cms/tests/
├── Pest.php                    # Configurazione Pest per Cms
├── Feature/
│   └── Auth/                   # Test autenticazione
│       ├── AuthenticationTest.php
│       ├── EmailVerificationTest.php
│       ├── PasswordConfirmationTest.php
│       ├── PasswordResetTest.php
│       ├── PasswordUpdateTest.php
│       ├── ProfileUpdateTest.php
│       └── RegistrationTest.php
└── Unit/
```

### Xot (Modulo Core)
```
Modules/Xot/tests/
├── Pest.php                    # Configurazione Pest per Xot
├── CreatesApplication.php      # Trait per creazione applicazione
├── TestCase.php                # TestCase base globale
└── Unit/
    └── MetatagDataTest.php
```

## File di Configurazione Pest.php

Ogni modulo ha il suo file `Pest.php` per configurazione specifica:

### Modulo SaluteOra
```php
<?php

declare(strict_types=1);

use Modules\SaluteOra\Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit', 'Browser');

// Expectations personalizzate per SaluteOra
// expect()->extend('toBeValidAppointment', function () {
//     // Logic here
// });
```

### Modulo Cms  
```php
<?php

declare(strict_types=1);

use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

// Expectations per frontend/CMS
// expect()->extend('toBeValidHtml', function () {
//     return $this->toContain('<html');
// });
```

### Modulo Xot
```php
<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

// Core expectations
```

## Sintassi Pest vs PHPUnit

### Struttura Base del Test

**❌ PHPUnit (Vecchio)**
```php
class MyTest extends TestCase 
{
    /** @test */
    public function it_can_do_something(): void
    {
        $this->assertTrue(true);
    }
}
```

**✅ Pest (Nuovo)**
```php
test('it can do something', function () {
    expect(true)->toBeTrue();
});
```

### Assertions vs Expectations

**❌ PHPUnit Assertions**
```php
$this->assertEquals('expected', $actual);
$this->assertTrue($condition);
$this->assertNull($value);
$this->assertCount(3, $array);
```

**✅ Pest Expectations**
```php
expect($actual)->toBe('expected');
expect($condition)->toBeTrue();
expect($value)->toBeNull();
expect($array)->toHaveCount(3);
```

### Setup e Teardown

**❌ PHPUnit Setup**
```php
protected function setUp(): void
{
    parent::setUp();
    // setup logic
}

protected function tearDown(): void
{
    // cleanup logic
    parent::tearDown();
}
```

**✅ Pest Hooks**
```php
beforeEach(function () {
    // setup logic
});

afterEach(function () {
    // cleanup logic
});
```

### Test con Eccezioni

**❌ PHPUnit**
```php
$this->expectException(ValidationException::class);
$this->expectExceptionMessage('Error message');
```

**✅ Pest**
```php
expect(fn() => $action->execute())
    ->toThrow(ValidationException::class, 'Error message');
```

### Laravel Helpers

**❌ PHPUnit**
```php
$response = $this->get('/');
$response->assertStatus(200);
$this->actingAs($user);
```

**✅ Pest**
```php
use function Pest\Laravel\{get, post, actingAs};

$response = get('/');
$response->assertStatus(200);
actingAs($user);
```

## Best Practices Pest

### 1. Test Descriptivi
```php
test('user can register with valid email and password', function () {
    // test logic
});

test('registration fails with invalid email format', function () {
    // test logic  
});
```

### 2. Chaining Expectations
```php
expect($user)
    ->toBeInstanceOf(User::class)
    ->and($user->email)->toBe('test@example.com')
    ->and($user->isActive())->toBeTrue();
```

### 3. Custom Expectations
```php
// Nel file Pest.php del modulo
expect()->extend('toBeValidEmail', function () {
    return $this->toMatch('/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
});

// Utilizzo nel test
expect($email)->toBeValidEmail();
```

### 4. Dataset Testing
```php
test('email validation works correctly', function (string $email, bool $isValid) {
    $result = validateEmail($email);
    expect($result)->toBe($isValid);
})->with([
    ['test@example.com', true],
    ['invalid-email', false],
    ['another@valid.email', true],
]);
```

### 5. Group Testing
```php
describe('User Authentication', function () {
    test('user can login with valid credentials', function () {
        // test logic
    });
    
    test('user cannot login with invalid credentials', function () {
        // test logic
    });
});
```

## Mappatura Tipi di Test

| Tipo Test | Directory | Scopo |
|-----------|-----------|--------|
| **Unit** | `Unit/` | Test di singole classi/metodi isolati |
| **Feature** | `Feature/` | Test di integrazione di funzionalità complete |
| **Browser** | `Browser/` | Test end-to-end con Dusk |

## TestCase Hierarchy

```
BaseTestCase (Laravel)
├── Tests\TestCase (Root Laravel)          # Per test globali
├── Modules\Xot\Tests\TestCase            # Per moduli che estendono Xot
└── Modules\SaluteOra\Tests\TestCase      # Per test specifici SaluteOra
```

## Esecuzione Test

### Tutti i test (Pest)
```bash
./vendor/bin/pest
```

### Test specifici per modulo
```bash
./vendor/bin/pest Modules/SaluteOra/tests/
./vendor/bin/pest Modules/Cms/tests/Feature/Auth/
./vendor/bin/pest Modules/Xot/tests/Unit/
```

### Con coverage
```bash
./vendor/bin/pest --coverage
```

### Con dataset specifico
```bash
./vendor/bin/pest --filter="authentication"
```

## Migrazione da PHPUnit a Pest

### Checklist di Conversione

- [ ] ✅ **File Pest.php creati per ogni modulo**
- [ ] ✅ **TestCase base aggiornati** 
- [ ] ✅ **Sintassi test convertita da class/method a function**
- [ ] ✅ **Assertions convertite a expectations**
- [ ] ✅ **Setup/teardown convertiti a beforeEach/afterEach**
- [ ] ✅ **Laravel helpers importati con use function**
- [ ] ✅ **File duplicati/misti rimossi**
- [ ] ✅ **Namespace puliti (rimossi se non necessari)**

### Pattern di Conversione Automatica

```php
// Trova e sostituisci pattern comuni:

// Classes -> Functions
'class (\w+)Test extends TestCase' → test('nome descrittivo', function ()

// Methods -> Tests  
'public function test(\w+)' → test('nome descrittivo', function ()

// Assertions -> Expectations
'$this->assertEquals($a, $b)' → expect($b)->toBe($a)
'$this->assertTrue($x)' → expect($x)->toBeTrue()
'$this->assertNull($x)' → expect($x)->toBeNull()
'$this->assertCount($n, $arr)' → expect($arr)->toHaveCount($n)
```

## Validazione e Quality Assurance

### Script di Verifica Pest
```bash
#!/bin/bash
# Verifica che tutti i test siano in formato Pest

echo "Verifica conversione Pest..."

# Cerca classi PHPUnit rimaste
echo "🔍 Cerca classi PHPUnit..."
find Modules/*/tests/ -name "*.php" -exec grep -l "class.*extends.*TestCase" {} \;

# Cerca assertions PHPUnit rimaste  
echo "🔍 Cerca assertions PHPUnit..."
find Modules/*/tests/ -name "*.php" -exec grep -l "\$this->assert" {} \;

# Verifica file Pest.php esistenti
echo "🔍 Verifica file Pest.php..."
find Modules/*/tests/ -name "Pest.php" -exec echo "✅ {}" \;

echo "Verifica completata!"
```

### CI/CD Integration
```yaml
test:
  stage: test
  script:
    - composer install
    - ./vendor/bin/pest --coverage --coverage-clover=coverage.xml
  artifacts:
    reports:
      coverage_report:
        coverage_format: cobertura
        path: coverage.xml
```

## Errori Comuni e Soluzioni

### 1. "Test not found" Error
**Problema**: File Pest.php mancante o configurato male
**Soluzione**: Verificare che `uses(TestCase::class)->in('Feature', 'Unit')` sia presente

### 2. "Method not found" Error  
**Problema**: Mixing PHPUnit syntax in Pest
**Soluzione**: Convertire `$this->assertX()` in `expect()->toX()`

### 3. "Class not found" Error
**Problema**: Namespace errato o mancante import
**Soluzione**: Verificare use statements e namespace

### 4. Setup non funziona
**Problema**: Setup in TestCase non richiamato
**Soluzione**: Verificare che il TestCase sia specificato correttamente in Pest.php

## Links e References

### Internal Documentation
- [Testing Guidelines - SaluteOra](../Modules/SaluteOra/docs/testing.md)
- [Testing Guidelines - Cms](../Modules/Cms/docs/testing.md)  
- [Testing Guidelines - Xot](../Modules/Xot/docs/testing.md)
- [Register Type Test Implementation](../Modules/Cms/docs/tests/register-type-test-implementation.md)

### External Resources
- [Pest Official Documentation](https://pestphp.com/)
- [Pest Laravel Plugin](https://pestphp.com/docs/plugins/laravel)
- [Migration from PHPUnit](https://pestphp.com/docs/upgrade-guide)

## 🎯 PestPHP Pattern Identificati (2025)

Durante l'implementazione dei test nel modulo Cms, abbiamo identificato **pattern critici** per PestPHP che devono essere seguiti in tutto il progetto SaluteOra.

### ✅ **Struttura File Corretta**
```php
<?php

declare(strict_types=1);

use Livewire\Livewire;
use Modules\User\Filament\Widgets\RegistrationWidget;
use Modules\Xot\Datas\XotData;

uses(\Modules\Xot\Tests\TestCase::class);

// Helper functions globali
function generateUniqueTestEmail(): string {
    return fake()->unique()->safeEmail();
}

describe('RegistrationWidget Core Tests', function () {
    test('widget can be rendered for patient type', function () {
        Livewire::test(RegistrationWidget::class, ['type' => 'patient'])
            ->assertStatus(200);
    });
});
```

### ❌ **Anti-Pattern Critici**
```php
// ❌ MAI dichiarare namespace nel corpo del file
namespace Modules\Cms\Tests\Feature\Auth;

// ❌ MAI usare sintassi errata con covers()
test('name')->with('dataset')->covers(function() {});

// ❌ MAI property static non inizializzate
static $__latestDescription;
```

### 🎯 **Separazione Architettonica**
- **{Feature}Test.php**: Test della PAGINA (rendering, layout, middleware)  
- **{Feature}WidgetTest.php**: Test del WIDGET Filament (form logic, validation)
- **MAI** mischiare i due livelli di testing

### 🚀 **Performance Results**
- **9 test** in **4.44s** (0.49s average)
- **17 assertions** senza fallimenti  
- **Error handling robusto** con try-catch patterns

### **Riferimenti Completi**
- [PestPHP Best Practices - Cms](../Modules/Cms/docs/tests/pestphp-best-practices.md)
- [Registration Widget Test Strategy](../Modules/Cms/docs/tests/registration-widget-test-strategy.md)

---

**Ultimo aggiornamento**: Dicembre 2024  
**Framework**: Pest (completamente migrato da PHPUnit)  
**Responsabile**: Team Laraxot SaluteOra 