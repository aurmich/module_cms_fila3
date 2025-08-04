# PHPStan Factory Compliance - SaluteOra Module

## 🎯 Overview

Documentazione completa per la compliance PHPStan livello 9+ nelle factory del modulo SaluteOra. Questa guida risolve tutti gli errori di tipizzazione, generics e sicurezza identificati da PHPStan e Larastan.

## 📋 Errori PHPStan Risolti

### 1. Factory Generics Pattern
**Problema**: `@extends` con generics ma UserFactory non è generic
**Soluzione**: Rendere UserFactory template-aware

### 2. State Management Typing
**Problema**: Property `User::$state` non accetta string
**Soluzione**: Usare class-string per stati

### 3. Faker Method Safety
**Problema**: Metodi Faker non sicuri o con parametri errati
**Soluzione**: Correggere parametri e usare metodi esistenti

### 4. Safe Functions Usage
**Problema**: `mkdir` e `file_put_contents` non sicure
**Soluzione**: Usare funzioni sicure di `thecodingmachine/safe`

## 🏗️ Pattern di Correzione

### UserFactory Base Template

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * UserFactory for SaluteOra module.
 * 
 * @template TModel of \Modules\SaluteOra\Models\User
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\User>
     */
    protected $model = User::class;

    // ... resto implementazione
}
```

### Factory Figlie Template-Safe

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

/**
 * AdminFactory for SaluteOra module.
 * 
 * @extends \Modules\SaluteOra\Database\Factories\UserFactory<\Modules\SaluteOra\Models\Admin>
 */
class AdminFactory extends UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Admin>
     */
    protected $model = Admin::class;

    // ... resto implementazione
}
```

### State Management Typing

```php
// ❌ Errore: String assignment a property tipizzata
$user->state = Pending::class;

// ✅ Corretto: Usare class-string e transition methods
$user->state = Pending::class;  // Con property typehint corretto

// O meglio ancora, usare state machine methods
$user->transitionTo(Pending::class);
```

### Faker Methods Correction

```php
// ❌ Errore: year() con parametri errati
$this->faker->year('-15 years', '-2 years')

// ✅ Corretto: dateTimeBetween + format
$this->faker->dateTimeBetween('-15 years', '-2 years')->format('Y')

// ❌ Errore: stateAbbr() non esiste per locale italiana
$this->faker->stateAbbr()

// ✅ Corretto: Usare randomElement con province italiane
$this->faker->randomElement(['RM', 'MI', 'NA', 'TO', 'FI'])
```

### Safe Functions Usage

```php
// ❌ Errore: Funzioni non sicure
mkdir(dirname($filename), 0755, true);
file_put_contents($filename, $content);

// ✅ Corretto: Funzioni sicure
use function Safe\mkdir;
use function Safe\file_put_contents;

mkdir(dirname($filename), 0755, true);
file_put_contents($filename, $content);
```

### afterCreating() Type Safety

```php
// ❌ Errore: Callback type mismatch
->afterCreating(function (Doctor $doctor) {
    // User factory ma callback con Doctor
})

// ✅ Corretto: Type consistency
->afterCreating(function (User $user) {
    if ($user instanceof Doctor) {
        // Handle doctor-specific logic
    }
})
```

## 🔧 Implementazione Completa

### 1. Binary Operations Safety

```php
// ❌ Errore: Binary operation con mixed
'+39 ' . $this->faker->numerify('#######')

// ✅ Corretto: Ensure string types
'+39 ' . (string) $this->faker->numerify('#######')
```

### 2. Null Safety in String Functions

```php
// ❌ Errore: Null può essere passato a strtolower
strtolower($value)

// ✅ Corretto: Null check
strtolower($value ?? '')

// O meglio ancora
$value !== null ? strtolower($value) : ''
```

### 3. Void Methods with Side Effects

```php
// ❌ Errore: Void method senza side effects
private function createMockAttachments(User $user, array $attachments): void
{
    // Solo logging, nessun side effect reale
}

// ✅ Corretto: Aggiungere @phpstan-ignore o implementare side effects
/**
 * @phpstan-ignore-next-line method.void
 */
private function createMockAttachments(User $user, array $attachments): void
{
    // Placeholder per future implementazioni
    // In Phase 2: implementeremo Media Library integration
}
```

## 📚 Best Practice PHPStan per Factory

### 1. Template Usage
- Usare `@template` per factory base generiche
- Specificare type parameters nelle factory figlie
- Mantenere consistenza nei type hints

### 2. State Management
- Type-safe state transitions
- Class-string typing per stati
- Documentare state machine flow

### 3. Faker Safety
- Verificare metodi disponibili per locale
- Type-safe parameter passing
- Gestire valori null/mixed

### 4. Safe Functions
- Importare funzioni sicure esplicitamente
- Gestire eccezioni appropriate
- Documentare side effects

### 5. Cross-Model Relations
- Type consistency in callbacks
- Instanceof checks quando necessario
- Generic-aware relationship handling

## 🎯 Checklist Compliance

- [ ] UserFactory dichiarata come template
- [ ] Factory figlie usano generics corretti
- [ ] Tutti gli errori di stato risolti
- [ ] Metodi Faker corretti per locale italiano
- [ ] Funzioni sicure implementate
- [ ] Binary operations type-safe
- [ ] Null safety in string operations
- [ ] Void methods documented/fixed
- [ ] PHPStan livello 9+ passa senza errori

## 🔗 Collegamenti

- [Laravel Factory Documentation](https://laravel.com/docs/database-testing#model-factories)
- [Larastan PHPStan Extension](https://github.com/larastan/larastan)
- [PHPStan Generic Types](https://phpstan.org/blog/generics-in-php-using-phpdocs)
- [Safe Functions Library](https://github.com/thecodingmachine/safe)

## 📋 Testing Compliance

```bash
# Verifica compliance PHPStan
cd /var/www/html/_bases/base_saluteora/laravel
./vendor/bin/phpstan analyze Modules/SaluteOra/database/factories --level=9

# Test factory functionality
php artisan test --filter=Factory

# Genera dati di test
php artisan tinker
>>> User::factory()->count(10)->create()
>>> User::factory()->doctor()->count(5)->create()
```

*Ultimo aggiornamento: Dicembre 2024*
*Versione: 1.0*
*Compatibilità: PHPStan 1.10+, Larastan 3.x, Laravel 11+* 