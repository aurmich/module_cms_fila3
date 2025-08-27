# Pattern di Testing per BaseModel con Trait Complessi

## Problema Identificato

### BindingResolutionException con BaseModel
Quando si testano modelli che estendono `BaseModel`, si verifica spesso l'errore:
```
Target class [config] does not exist.
BindingResolutionException
```

### Causa Root
Il `BaseModel` di Laraxot utilizza molti trait complessi:
- `InteractsWithMedia` (Spatie Media Library)
- `Updater` (Xot Custom Trait) 
- `HasFactory` (Laravel Factories)
- `RelationX` (Xot Relations)

Questi trait si auto-inizializzano nel costruttore Eloquent e richiedono:
1. Container Laravel completamente configurato
2. Servizi di configurazione (`config` binding)
3. Database connection attiva
4. Provider di servizio registrati

### Perché Falliscono i Test Tradizionali

```php
// ❌ FALLISCE - Anonymous class instantiation
$model = new class extends BaseModel {
    protected $table = 'test';
}; // -> BindingResolutionException

// ❌ FALLISCE - Direct instantiation 
$model = new TestModel(); // -> BindingResolutionException

// ❌ FALLISCE - MockBuilder (anche deprecato)
$this->getMockBuilder(BaseModel::class)
    ->disableOriginalConstructor()
    ->getMock(); // -> Deprecation warnings + binding issues
```

## Soluzione Consolidata: Pattern Reflection

### 1. Test Strutturali (Preferito)
Per verificare la presenza di metodi e struttura della classe:

```php
it('has required methods', function () {
    // ✅ SICURO - No instantiation needed
    expect(method_exists(BaseModel::class, 'getMedia'))->toBeTrue();
    expect(method_exists(BaseModel::class, 'casts'))->toBeTrue();
});

it('uses required traits', function () {
    $traits = class_uses_recursive(BaseModel::class);
    expect(array_key_exists(InteractsWithMedia::class, $traits))->toBeTrue();
    expect(array_key_exists(HasFactory::class, $traits))->toBeTrue();
});
```

### 2. Test di Metodi con newInstanceWithoutConstructor
Quando serve invocare metodi protetti/privati:

```php
it('exposes casts correctly', function () {
    $reflection = new ReflectionClass(BaseModel::class);
    expect($reflection->hasMethod('casts'))->toBeTrue();
    
    // ✅ SICURO - Bypassa il costruttore e i trait initializers
    $instance = $reflection->newInstanceWithoutConstructor();
    
    $method = $reflection->getMethod('casts');
    $method->setAccessible(true);
    
    $result = $method->invoke($instance);
    expect($result)->toBeArray();
    expect($result)->toHaveKey('id');
});
```

### 3. Pattern di Classe di Test Concreta
Per test più complessi:

```php
// Classe helper nel test file
class TestBaseModel extends BaseModel 
{
    protected $table = 'test_models';
    protected $connection = 'sqlite';
}

// Poi usare reflection su questa classe
it('works with concrete test class', function () {
    $reflection = new ReflectionClass(TestBaseModel::class);
    $instance = $reflection->newInstanceWithoutConstructor();
    // ... test logic
});
```

## Regole di Sicurezza

### DO ✅
1. **Usa Reflection** per accedere a metodi senza istanziazione
2. **Usa newInstanceWithoutConstructor()** quando devi invocare metodi
3. **Testa la struttura** (method_exists, class_uses_recursive, interface implementation)
4. **Testa il comportamento** via reflection controllata
5. **Crea classi concrete di test** se necessario per complex scenarios

### DON'T ❌
1. **MAI istanziare direttamente** BaseModel o sue estensioni nei unit test
2. **MAI usare RefreshDatabase** con questi test (regola generale Laraxot)
3. **MAI usare anonymous classes** che estendono BaseModel 
4. **EVITA MockBuilder** (deprecato e problematico)
5. **NON testare dettagli implementativi** come $fillable, $casts values

## Best Practices Specifiche

### Per Test di Casts
```php
// ✅ Testa la presenza e signature
expect($reflection->hasMethod('casts'))->toBeTrue();
expect($method->getReturnType()?->getName())->toBe('array');

// ✅ Testa il risultato via reflection
$instance = $reflection->newInstanceWithoutConstructor();
expect($method->invoke($instance))->toBeArray();
```

### Per Test di Trait
```php
// ✅ Verifica trait usage
$traits = class_uses_recursive(ModelClass::class);
expect(array_key_exists(TraitName::class, $traits))->toBeTrue();

// ✅ Verifica interface implementation  
expect(is_subclass_of(ModelClass::class, InterfaceName::class))->toBeTrue();
```

### Per Test di Metodi Media
```php
// ✅ Verifica presenza metodi via method_exists
expect(method_exists(ModelClass::class, 'getMedia'))->toBeTrue();
expect(method_exists(ModelClass::class, 'addMedia'))->toBeTrue();
```

## Esempi di Errori Comuni Risolti

### Errore: "Target class [config] does not exist"
**Causa**: Trait initialization nel constructor
**Soluzione**: `newInstanceWithoutConstructor()`

### Errore: "Undefined array key Model@anonymous"
**Causa**: Anonymous class con trait complex initialization
**Soluzione**: Classe concreta + reflection pattern

### Errore: MockBuilder deprecation warnings
**Causa**: PHPUnit evolution
**Soluzione**: Abbandonare mocking, usare reflection

## Compatibilità

- ✅ **Laravel 12+**: Supportato
- ✅ **PHPUnit 10+**: Supportato  
- ✅ **Pest 3+**: Supportato
- ✅ **Spatie Media Library**: Compatibile
- ✅ **Laraxot Xot Traits**: Compatibile

---
**Creato**: Gennaio 2025
**Ultima revisione**: Gennaio 2025
**Caso di Studio**: SaluteMo BaseModelTest fix