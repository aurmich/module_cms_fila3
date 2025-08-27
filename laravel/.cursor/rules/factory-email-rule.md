# REGOLA CRITICA: Email Faker nei Factory

## ⚠️ REGOLA FONDAMENTALE ⚠️

**MAI usare email hardcoded come `@example.com` nei factory!**

## ✅ Pattern Corretti

### Email Sicure (Recommended)
```php
'email' => $this->faker->unique()->safeEmail(),
```

### Email Aziendali  
```php
'email' => $this->faker->unique()->companyEmail(),
```

### Email Gratuite
```php
'email' => $this->faker->unique()->freeEmail(),
```

## ❌ Pattern Vietati

```php
// MAI FARE QUESTO!
'email' => 'test@example.com',
'email' => $name . '@example.com',
'email' => $name . '+' . uniqid() . '@example.com',
'email' => strtolower($firstName . '.' . $lastName . '@domain.com'),
```

## Motivazione

- **Dati realistici**: Faker genera email vere e variate
- **Testing migliore**: Nessun pattern ripetitivo
- **Unicità garantita**: `unique()` previene duplicati
- **Flessibilità**: Diversi provider email

## Controllo Factory

### Comando per verificare violazioni
```bash
grep -r "@example\.com\|@domain\.com\|@test\.com" Modules/*/database/factories/
```

### Comando per verificare pattern hardcoded
```bash
grep -r "'\w+@\w+\.\w+'" Modules/*/database/factories/
```

## Esempi Concreti

### UserFactory ✅
```php
public function definition(): array
{
    return [
        'name' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(), // ✅ CORRETTO
        'password' => Hash::make('password'),
    ];
}
```

### DoctorFactory ✅
```php
public function definition(): array
{
    return [
        'name' => 'Dr. ' . $this->faker->name(),
        'email' => $this->faker->unique()->companyEmail(), // ✅ CORRETTO
        'specialization' => $this->faker->randomElement($specializations),
    ];
}
```

## Checklist Factory

Prima di ogni commit:

- [ ] Nessuna email hardcoded `@example.com`
- [ ] Utilizzo di `$this->faker->unique()->safeEmail()`
- [ ] Nessun pattern fisso per email
- [ ] Test di unicità eseguiti

## Boy Scout Rule

Ogni volta che tocchi un factory:
1. Controlla email pattern
2. Correggi se necessario
3. Aggiorna documentazione
4. Lascia migliore di come hai trovato

---
**PRIORITÀ: CRITICA**  
**APPLICAZIONE: SEMPRE**  
**VIOLAZIONE: INACCETTABILE**




