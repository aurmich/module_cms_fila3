---
description: SaluteOra UserFactory Improvement Plan
---

# UserFactory Improvement (SaluteOra Module)

## Current Issues
1. `Modules/SaluteOra/Database/Factories/UserFactory.php` is empty → factories cannot create sample data.
2. Lack of support for Single-Table-Inheritance (`type` field) and state machine (`state` field).
3. No realistic user profile data (first name, last name, phone, etc.).
4. Password not hashed → security & login tests fail.

## Design Goals
* Generate **valid** default data for `Modules\SaluteOra\Models\User` respecting:
  * `type` enum (`patient`, `doctor`, `admin`).
  * Initial `state` (`pending`).
  * Casting & attributes defined in the model (`first_name`, `last_name`, etc.).
* Provide **named states** (`patient()`, `doctor()`, `admin()`) to quickly create specific user types.
* Keep factory **framework-agnostic** (usable in Seeder, Pest, tinker).
* Use `Faker` for realistic values, `Hash::make()` for a default *password*.
* Set connection automatically through the model (no manual DB switch).

## Implementation Steps
1. Import required classes: `User`, `UserTypeEnum`, `Pending` state, `Str`, `Hash`.
2. Define the default state with realistic faker data and sensible defaults.
3. Add fluent factory modifiers:
   ```php
   public function patient(): static { return $this->state(fn () => ['type' => UserTypeEnum::PATIENT]); }
   ```
4. Document the factory usage in README / docs:
   ```php
   $user = User::factory()->doctor()->create();
   ```
5. Ensure PHP 8.2+ strict types, PSR-12 formatting.

## QA Checklist
- [ ] `phpstan` level 9 passes for factory.
- [ ] Pest tests compile using the new factory.
- [ ] Seeders (`DatabaseSeeder`) can call the factory.
- [ ] No hard-coded strings except default password.
- [ ] Docs updated with examples.

---
*Last update: 2025-07-06*
