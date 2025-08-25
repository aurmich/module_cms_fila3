# Factory Best Practices - Boy Scout Rule

## 🚫 NEVER Use "@example.com" Emails

### The Golden Rule
**ALWAYS use proper Faker methods instead of hardcoded "@example.com" emails.**

### Correct Pattern
```php
// ✅ CORRECT - Use Faker methods
'email' => fake()->unique()->safeEmail(),
'email' => $this->faker->unique()->safeEmail(),

// ❌ WRONG - Never use hardcoded example emails
'email' => 'user@example.com',
'email' => 'test@example.com',
```

### Why This Matters
1. **Realistic Data**: Faker generates realistic email addresses
2. **Uniqueness**: `unique()` ensures no duplicate emails  
3. **Domain Variety**: Faker uses multiple domains, not just example.com
4. **Testing Quality**: Realistic data catches more edge cases
5. **Professionalism**: Looks more professional in demo data

### Approved Faker Methods for Emails
```php
// Basic safe email
fake()->safeEmail()

// Unique safe email  
fake()->unique()->safeEmail()

// Free email provider
fake()->freeEmail()

// Company email
fake()->companyEmail()
```

### Italian-Specific Best Practices (for SaluteOra)
```php
// Italian names and realistic data
'first_name' => fake()->randomElement(['Marco', 'Maria', 'Giuseppe', 'Anna']),
'last_name' => fake()->randomElement(['Rossi', 'Bianchi', 'Romano', 'Esposito']),
'phone' => '+39 ' . fake()->numerify('### ### ####'),
'fiscal_code' => // custom Italian fiscal code generation
```

### Database Population Commands
```bash
# Run the mass population seeder
php artisan db:seed --class=DatabaseMassPopulationSeeder

# Run via tinker
php artisan tinker --execute="require 'populate_with_tinker.php'"

# Run specific module seeders
php artisan module:seed Activity
php artisan module:seed SaluteOra
```

### Factory Creation Standards
1. **Use Faker**: Always `fake()` or `$this->faker`
2. **Realistic Data**: Country-specific where appropriate
3. **Unique Constraints**: Use `->unique()` for email, username, etc.
4. **States**: Define meaningful states (admin, doctor, patient)
5. **Relationships**: Set up proper relationships between models

### Remember: Boy Scout Rule
**"Leave the codebase better than you found it"** - Always improve factories with:
- More realistic data
- Better Italian localization  
- Proper error handling
- Comprehensive test coverage

### Monitoring
Regularly check factories for compliance:
```bash
# Search for example.com usage
grep -r "@example\.com" Modules/ --include="*.php" | grep -v test
```

This rule is NON-NEGOTIABLE and must be followed in ALL factory implementations.