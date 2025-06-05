# Value Objects

Questo documento contiene la documentazione dettagliata dei value objects.

## Struttura

### Base Value Objects
- `TaxCode`: Codice fiscale italiano
- `PhoneNumber`: Numero di telefono
- `Email`: Indirizzo email
- `Address`: Indirizzo completo
- `BirthDate`: Data di nascita

### Medical Value Objects
- `BloodType`: Gruppo sanguigno
- `Height`: Altezza in cm
- `Weight`: Peso in kg
- `BMI`: Indice di massa corporea
- `Allergy`: Allergia specifica

## Implementazione

### Esempio Base
```php
namespace Modules\Patient\app\ValueObjects;

final class TaxCode
{
    private string $value;
    
    public function __construct(string $taxCode)
    {
        if (!$this->isValid($taxCode)) {
            throw new InvalidTaxCodeException($taxCode);
        }
        
        $this->value = $taxCode;
    }
    
    public function value(): string
    {
        return $this->value;
    }
    
    private function isValid(string $taxCode): bool
    {
        return (bool) preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/', $taxCode);
    }
    
    public function getBirthDate(): ?DateTimeImmutable
    {
        $year = substr($this->value, 6, 2);
        $month = substr($this->value, 8, 1);
        $day = substr($this->value, 9, 2);
        
        return DateTimeImmutable::createFromFormat(
            'y-m-d',
            "{$year}-{$month}-{$day}"
        ) ?: null;
    }
    
    public function getGender(): ?GenderType
    {
        $day = (int) substr($this->value, 9, 2);
        return $day > 40 ? GenderType::FEMALE : GenderType::MALE;
    }
}
```

### Utilizzo nei Modelli
```php
namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\app\ValueObjects\TaxCode;

class Patient extends Model
{
    public function setTaxCodeAttribute(string $value): void
    {
        $this->attributes['tax_code'] = (new TaxCode($value))->value();
    }
    
    public function getTaxCodeAttribute(string $value): TaxCode
    {
        return new TaxCode($value);
    }
}
```

### Validazione
```php
namespace Modules\Patient\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Patient\app\ValueObjects\TaxCode;

class ValidTaxCode implements Rule
{
    public function passes($attribute, $value): bool
    {
        try {
            new TaxCode($value);
            return true;
        } catch (InvalidTaxCodeException) {
            return false;
        }
    }
    
    public function message(): string
    {
        return 'Il codice fiscale non è valido.';
    }
}
```

## Medical Value Objects

### BloodType
```php
namespace Modules\Patient\app\ValueObjects;

enum BloodGroup: string
{
    case A_POSITIVE = 'A+';
    case A_NEGATIVE = 'A-';
    case B_POSITIVE = 'B+';
    case B_NEGATIVE = 'B-';
    case AB_POSITIVE = 'AB+';
    case AB_NEGATIVE = 'AB-';
    case O_POSITIVE = 'O+';
    case O_NEGATIVE = 'O-';
}

final class BloodType
{
    public function __construct(
        private BloodGroup $group,
        private ?string $rhFactor = null
    ) {}
    
    public function isCompatible(BloodType $other): bool
    {
        return match($this->group) {
            BloodGroup::O_POSITIVE, BloodGroup::O_NEGATIVE => true,
            BloodGroup::A_POSITIVE, BloodGroup::A_NEGATIVE => 
                $other->group === BloodGroup::A_POSITIVE || 
                $other->group === BloodGroup::A_NEGATIVE,
            BloodGroup::B_POSITIVE, BloodGroup::B_NEGATIVE => 
                $other->group === BloodGroup::B_POSITIVE || 
                $other->group === BloodGroup::B_NEGATIVE,
            BloodGroup::AB_POSITIVE, BloodGroup::AB_NEGATIVE => 
                $other->group === BloodGroup::AB_POSITIVE || 
                $other->group === BloodGroup::AB_NEGATIVE,
        };
    }
}
```

### BMI
```php
namespace Modules\Patient\app\ValueObjects;

final class BMI
{
    private float $value;
    
    public function __construct(
        private Height $height,
        private Weight $weight
    ) {
        $this->value = $this->calculate();
    }
    
    private function calculate(): float
    {
        $heightInMeters = $this->height->inMeters();
        return $this->weight->inKg() / ($heightInMeters * $heightInMeters);
    }
    
    public function getCategory(): string
    {
        return match(true) {
            $this->value < 18.5 => 'Underweight',
            $this->value < 25 => 'Normal',
            $this->value < 30 => 'Overweight',
            default => 'Obese',
        };
    }
}
```

## Testing

### Unit Tests
```php
class TaxCodeTest extends TestCase
{
    /** @test */
    public function it_validates_correct_tax_code(): void
    {
        $taxCode = new TaxCode('RSSMRA90A01H501R');
        
        $this->assertEquals('RSSMRA90A01H501R', $taxCode->value());
    }
    
    /** @test */
    public function it_throws_exception_for_invalid_tax_code(): void
    {
        $this->expectException(InvalidTaxCodeException::class);
        
        new TaxCode('INVALID');
    }
}
```

### Integration Tests
```php
class PatientWithTaxCodeTest extends TestCase
{
    /** @test */
    public function it_stores_tax_code_correctly(): void
    {
        $patient = Patient::factory()->create([
            'tax_code' => 'RSSMRA90A01H501R',
        ]);
        
        $this->assertInstanceOf(TaxCode::class, $patient->tax_code);
        $this->assertEquals('RSSMRA90A01H501R', $patient->tax_code->value());
    }
}
```

## Best Practices

### Immutabilità
- Tutti i value objects sono immutabili
- Nessun metodo setter
- Costruttore con validazione
- Metodi che ritornano nuove istanze

### Validazione
- Validazione nel costruttore
- Eccezioni specifiche
- Messaggi di errore chiari
- Validazione completa

### Tipizzazione
- Tipi stretti
- Return type hints
- Parametri tipizzati
- PHPDoc completo

### Testing
- Test per ogni metodo
- Test per validazione
- Test per edge cases
- Test per immutabilità 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

