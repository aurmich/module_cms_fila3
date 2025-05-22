# Modelli del Modulo Patient

## Struttura e Namespace

1. **Namespace Corretto**:
   - ✅ `namespace Modules\Patient\Models;`
   - ❌ `namespace Modules\Patient\App\Models;`

2. **Ereditarietà**:
   - I modelli devono estendere la classe base appropriata
   - Esempio: `User extends BaseUser`

3. **Deprecazione proprietà $casts**:
   - ⚠️ L'uso di `protected $casts` come proprietà è deprecato. Se serve override, usare il metodo `protected function casts(): array`.
   - Esempio:
   ```php
   protected function casts(): array
   {
       return array_merge(parent::casts(), [
           'certifications' => 'array',
       ]);
   }
   ```
   - Vedi anche: [Regole Namespace Xot](../../Xot/docs/NAMESPACE_RULES.md)

## Single Table Inheritance (STI)

1. **Configurazione Base**:
   ```php
   protected $connection = 'user';
   protected $childColumn = 'type';
   protected $childTypes = [
       'patient' => Patient::class,
       'doctor' => Doctor::class,
   ];
   ```

2. **Regole Fondamentali**:
   - Tutti i campi usati dai modelli specializzati devono essere nella tabella base
   - I campi specifici vanno aggiunti con migration idempotenti
   - I namespace devono riflettere la struttura delle directory

## Best Practices

1. **Casts e Attributes**:
   ```php
   protected $casts = [
       'email_verified_at' => 'datetime',
       'password' => 'hashed',
       'certifications' => 'array',
   ];

   protected $attributes = [
       'certifications' => '[]',
   ];
   ```

2. **Relazioni**:
   - Definire sempre le relazioni nel modello appropriato
   - Usare i trait necessari
   - Documentare le relazioni complesse

3. **Validazione**:
   - Implementare le regole di validazione nel modello
   - Usare i trait di validazione quando necessario
   - Documentare le regole di business

## Errori Comuni e Soluzioni

1. **Errore: ValidationException custom**
   - ❌ throw new ValidationException(...)
   - ✅ throw ValidationException::withMessages(['email' => ['Messaggio personalizzato']]);

2. **Errore: Proprietà $casts deprecata**
   - ❌ protected $casts = [...];
   - ✅ protected function casts(): array { return array_merge(parent::casts(), [...]); }

3. **Errore: Ereditarietà errata**
   - ❌ class Doctor extends XotBaseModel
   - ✅ class Doctor extends \Modules\Patient\Models\User

4. **Errore: Controllo su User invece che Doctor**
   - ❌ User::where('email', ...)
   - ✅ Doctor::where('email', ...)

5. **Errore: Fallback enum/status non gestito**
   - ✅ Usare metodo privato per fallback:
   ```php
   private function getDoctorRegistrationStatus(): string {
       if (!class_exists(DoctorRegistrationStatus::class)) return 'pending';
       try {
           foreach (DoctorRegistrationStatus::cases() as $case) {
               if (strtolower($case->name) === 'pending') return $case->value;
           }
           return 'pending';
       } catch (\Exception $e) { return 'pending'; }
   }
   ```

## Checklist
- [ ] Namespace corretti
- [ ] Ereditarietà STI
- [ ] Proprietà deprecate rimosse
- [ ] Error handling idiomatico
- [ ] Fallback enum/status
- [ ] Collegamenti bidirezionali
- [ ] Test e validazione

## Collegamenti
- [Regole Namespace Xot](../../Xot/docs/NAMESPACE_RULES.md)
- [Error Handling Xot](../../Xot/docs/error-handling.md)
- [README Xot](../../Xot/docs/README.md)
