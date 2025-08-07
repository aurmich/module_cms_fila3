# Data Objects nel Modulo Patient

## Struttura e Namespace

1. **Directory Corretta**:
   - ✅ `/var/www/html/[progetto]/laravel/Modules/Patient/Datas/`
   - ❌ `/var/www/html/[progetto]/Modules/Patient/Datas/`

2. **Namespace Corretto**:
   - ✅ `namespace Modules\Patient\Datas;`
   - ❌ `namespace Modules\Patient\App\Datas;`

## Implementazione

1. **Struttura Base**:
   ```php
   <?php

   declare(strict_types=1);

   namespace Modules\Patient\Datas;

   use Spatie\LaravelData\Data;

   class DoctorData extends Data
   {
       public function __construct(
           public ?string $first_name,
           public ?string $last_name,
           public ?string $email,
           public ?string $phone,
           public ?string $address,
           public ?string $city,
           public ?string $registration_number,
           public ?array $certifications,
           public ?array $availability,
       ) {
       }
   }
   ```

2. **Validazione**:
   ```php
   public static function rules(): array
   {
       return [
           'first_name' => ['required', 'string', 'max:255'],
           'last_name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'email', 'unique:users,email'],
           'phone' => ['nullable', 'string', 'max:20'],
           'address' => ['nullable', 'string', 'max:255'],
           'city' => ['nullable', 'string', 'max:100'],
           'registration_number' => ['nullable', 'string', 'max:50'],
           'certifications' => ['nullable', 'array'],
           'availability' => ['nullable', 'array'],
       ];
   }
   ```

## Best Practices

1. **Validazione**:
   - Implementare sempre le regole di validazione
   - Usare tipi di ritorno stretti
   - Documentare le regole di business

2. **Tipizzazione**:
   - Usare tipi di ritorno PHP 8
   - Usare nullable quando appropriato
   - Documentare i tipi complessi

3. **Documentazione**:
   - Aggiungere docblock per la classe
   - Documentare le proprietà
   - Aggiungere esempi di utilizzo

## Errori Comuni

1. **Errore**: Directory errata
   - ❌ `/var/www/html/[progetto]/Modules/Patient/Datas/`
   - ✅ `/var/www/html/[progetto]/laravel/Modules/Patient/Datas/`

2. **Errore**: Namespace errato
   - ❌ `namespace Modules\Patient\App\Datas;`
   - ✅ `namespace Modules\Patient\Datas;`

3. **Errore**: Validazione mancante
   - ❌ Manca `rules()`
   - ✅ Implementare `rules()`

## Collegamenti

- [Data Objects Xot](../Xot/docs/data-objects.md)
- [Best Practices](../Xot/docs/best-practices.md)
- [Convenzioni di Codice](../Xot/docs/coding-standards.md) 
