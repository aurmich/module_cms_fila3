# Testing Environment Configuration (.env.testing)

## CRITICAL RULE: Always Use .env.testing for Tests

**FONDAMENTALE**: Tutti i test DEVONO utilizzare la configurazione da `.env.testing`, mai da `.env` principale. Questa è una regola assoluta e non negoziabile.

## Configuration Structure

### 1. Environment File Hierarchy

```
laravel/
├── .env              # Development environment (MAI usare per i test)
├── .env.testing      # ✅ Testing environment (OBBLIGATORIO per i test)
├── .env.production   # Production environment
└── phpunit.xml       # PHPUnit configuration
```

### 2. .env.testing Configuration

```bash
# File: .env.testing
APP_ENV=testing
APP_DEBUG=true
APP_URL=http://localhost

# Database testing configuration
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
# OR for file-based testing:
# DB_DATABASE=database/testing.sqlite

# Cache and session for testing
CACHE_DRIVER=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync

# Mail testing
MAIL_MAILER=log
MAIL_FROM_ADDRESS="test@example.com"
MAIL_FROM_NAME="Test Application"

# Feature flags for testing
PENNANT_DEFAULT=true
```

## Test Execution Commands

### 1. Correct Test Execution

```bash
# ✅ CORRETTO - Usa .env.testing automaticamente
php artisan test

# ✅ CORRETTO - Specifica environment testing
php artisan test --env=testing

# ✅ CORRETTO - Usa database sqlite per testing
DB_CONNECTION=sqlite php artisan test

# ❌ SBAGLIATO - Non usare mai .env principale per i test
php artisan test --env=local
```

### 2. Module-Specific Testing

```bash
# Test specifico modulo con environment testing
DB_CONNECTION=sqlite php artisan test Modules/SaluteOra/tests/

# Test specifica classe
DB_CONNECTION=sqlite php artisan test Modules/SaluteOra/tests/Feature/AppointmentTest.php

# Test con filtro
DB_CONNECTION=sqlite php artisan test --filter="test_appointment_creation"
```

## PHPUnit Configuration

### 1. phpunit.xml Configuration

```xml
<!-- phpunit.xml -->
<phpunit>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

### 2. Environment Precedence

La precedenza di configurazione è:
1. Variabili d'ambiente della shell (più alta priorità)
2. `.env.testing` file
3. `phpunit.xml` configuration
4. `.env` file (MAI usare per testing)

## Database Testing Strategies

### 1. In-Memory Database (Recommended)

```bash
# .env.testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

**Vantaggi**:
- Più veloce
- Isolamento completo tra test
- Nessun file system cleanup necessario

### 2. File-Based SQLite

```bash
# .env.testing  
DB_CONNECTION=sqlite
DB_DATABASE=database/testing.sqlite
```

```bash
# Cleanup prima dei test
rm -f database/testing.sqlite
touch database/testing.sqlite
```

### 3. MySQL Testing (Solo se necessario)

```bash
# .env.testing
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_database
DB_USERNAME=root
DB_PASSWORD=
```

## Test Setup Best Practices

### 1. Test Case Base Class

```php
<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure we're using testing environment
        $this->assertSame('testing', app()->environment());
        
        // Additional test setup
        $this->withoutExceptionHandling();
    }
}
```

### 2. Environment Verification in Tests

```php
/** @test */
public function it_runs_in_testing_environment(): void
{
    $this->assertEquals('testing', app()->environment());
    $this->assertTrue(config('app.debug'));
}
```

### 3. Database Configuration Check

```php
/** @test */
public function it_uses_sqlite_for_testing(): void
{
    $connection = config('database.default');
    $this->assertEquals('sqlite', $connection);
    
    $database = config('database.connections.sqlite.database');
    $this->assertTrue($database === ':memory:' || str_contains($database, 'testing'));
}
```

## Common Testing Patterns

### 1. Pest Test Example

```php
<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('uses testing environment', function () {
    // Verify environment
    expect(app()->environment())->toBe('testing');
    
    // Verify database connection
    expect(config('database.default'))->toBe('sqlite');
});

it('can access homepage', function () {
    get('/')->assertSuccessful();
});
```

### 2. PHPUnit Test Example

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /** @test */
    public function it_runs_in_testing_environment(): void
    {
        $this->assertEquals('testing', app()->environment());
    }
    
    /** @test */
    public function it_uses_testing_database(): void
    {
        $connection = config('database.default');
        $this->assertEquals('sqlite', $connection);
    }
}
```

## Debugging Test Environment Issues

### 1. Environment Verification Commands

```bash
# Check current environment
php artisan tinker --env=testing
>>> app()->environment();

# Check database configuration  
php artisan tinker --env=testing
>>> config('database.default');
>>> config('database.connections.sqlite.database');

# List all environment variables
php artisan tinker --env=testing
>>> $_ENV;
```

### 2. Common Issues and Solutions

**Problema**: Test usa .env invece di .env.testing
**Soluzione**:
```bash
# Verifica quale environment viene usato
php artisan test --env=testing --filter="environment_test"
```

**Problema**: Database configuration mismatch
**Soluzione**:
```bash
# Pulisci cache di configurazione
php artisan config:clear

# Verifica configurazione database
php artisan tinker --env=testing
>>> config('database');
```

**Problema**: File .env.testing mancante o corrotto
**Soluzione**:
```bash
# Ricrea .env.testing
cp .env .env.testing
# Modifica le variabili per testing
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env.testing
sed -i 's/DB_DATABASE=.*/DB_DATABASE=:memory:/' .env.testing
sed -i 's/APP_ENV=.*/APP_ENV=testing/' .env.testing
```

## Continuous Integration Setup

### 1. GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, xml, sqlite3
        coverage: pcov
    
    - name: Copy testing environment
      run: cp .env.testing .env
    
    - name: Install dependencies
      run: composer install --prefer-dist --no-progress
    
    - name: Generate key
      run: php artisan key:generate
    
    - name: Run tests
      run: vendor/bin/pest --coverage --colors=always
```

### 2. Local Development Script

```bash
#!/bin/bash
# scripts/run-tests.sh

# Set testing environment
export APP_ENV=testing
export DB_CONNECTION=sqlite
export DB_DATABASE=:memory:

# Run tests
php artisan test "$@"
```

## Security Considerations

### 1. Test Data Isolation

```bash
# .env.testing NON deve contenere dati sensibili
# Usare valori di test o placeholder

# ✅ CORRETTO
MAIL_FROM_ADDRESS="test@example.com"
MAIL_FROM_NAME="Test App"

# ❌ SBAGLIATO
MAIL_FROM_ADDRESS="real-email@company.com"
MAIL_FROM_NAME="Real Company Name"
```

### 2. API Keys and Secrets

```bash
# Usare valori fittizi per testing
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
AWS_ACCESS_KEY_ID=AKIAXXXXXXXXXXXXXXXX
AWS_SECRET_ACCESS_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

## Summary of Critical Rules

1. **MAI** usare `.env` principale per i test
2. **SEMPRE** usare `.env.testing` per l'ambiente di test
3. **VERIFICARE** che `APP_ENV=testing` sia impostato
4. **PREFERIRE** database SQLite in-memory per velocità
5. **ISOLARE** i dati di test da quelli di sviluppo
6. **PULIRE** la cache di configurazione prima dei test
7. **DOCUMENTARE** le dipendenze di ambiente nei test

## Checklist Pre-Test

- [ ] `.env.testing` esiste e è configurato correttamente
- [ ] `APP_ENV=testing` nel file .env.testing
- [ ] Database configurato per testing (preferibilmente sqlite)
- [ ] Cache driver impostato su 'array'
- [ ] Session driver impostato su 'array'  
- [ ] Mail driver impostato su 'log' o 'array'
- [ ] Configurazione cache pulita (`php artisan config:clear`)
- [ ] Eventuali file di database di test puliti
- [ ] Environment verificato (`app()->environment() === 'testing'`)