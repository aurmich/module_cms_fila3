# Model Inheritance in Patient Module

## Overview
This document explains the model inheritance patterns used in the Patient module of a modular Laravel application. Model inheritance allows for a structured approach to share common functionality and attributes among different entities like patients and doctors, ensuring code reusability and maintainability.

## Inheritance Patterns

1. **Single Table Inheritance (STI)**:
   - **Definition**: STI maps multiple models to a single database table, using a type column to differentiate between model types.
   - **Use Case**: Used in the Patient module to handle different types of users (e.g., Patient, Doctor) within a single `users` table.
   - **Implementation**:
     - A base model (e.g., `User`) defines common attributes and methods.
     - Child models (e.g., `Patient`, `Doctor`) extend the base model and define specific behaviors.
     - A `type` column in the table determines which model class to instantiate.
   - **Advantages**:
     - Simplifies database structure by using a single table.
     - Reduces the need for multiple joins when querying related data.
   - **Challenges**:
     - Can lead to a cluttered table with many nullable columns specific to certain types.
     - Performance may degrade with a large number of records due to table size.

2. **Class Table Inheritance (CTI)**:
   - **Definition**: CTI uses separate tables for each model in the inheritance hierarchy, with a base table for shared attributes.
   - **Use Case**: Suitable for scenarios where Patient and Doctor have significantly different attributes and relationships.
   - **Implementation**:
     - A base table (e.g., `users`) stores common data.
     - Specific tables (e.g., `patients`, `doctors`) store data unique to each type, linked via foreign keys.
   - **Advantages**:
     - Keeps data normalized and specific to each entity type.
     - Easier to manage when entities have distinct attributes.
   - **Challenges**:
     - Requires joins to access full entity data, which can impact performance.
     - More complex to maintain due to multiple tables.

## Implementation in Patient Module

- **Base User Model**:
  The Patient module uses a base `User` model to define shared attributes like `name`, `email`, and `password`. This model is extended by specific types:
  ```php
  namespace Modules\Patient\App\Models;

  use Illuminate\Foundation\Auth\User as Authenticatable;

  class User extends Authenticatable
  {
      protected $fillable = ['name', 'email', 'password', 'type'];

      protected $discriminator = 'type';

      protected $casts = [
          'email_verified_at' => 'datetime',
          'password' => 'hashed',
      ];
  }
  ```

- **Patient Model**:
  Extends `User` to include patient-specific attributes and relationships:
  ```php
  namespace Modules\Patient\App\Models;

  class Patient extends User
  {
      protected $fillable = ['name', 'email', 'password', 'type', 'medical_history'];

      public function appointments()
      {
          return $this->hasMany(Appointment::class);
      }
  }
  ```

- **Doctor Model**:
  Extends `User` for doctor-specific data and logic:
  ```php
  namespace Modules\Patient\App\Models;

  class Doctor extends User
  {
      protected $fillable = ['name', 'email', 'password', 'type', 'specialization', 'license_number'];

      public function patients()
      {
          return $this->hasManyThrough(Patient::class, Appointment::class);
      }
  }
  ```

## Best Practices

1. **Choose the Right Pattern**:
   - Use STI for simpler hierarchies with mostly shared attributes.
   - Opt for CTI when entities have significantly different data structures or relationships.

2. **Maintainability**:
   - Keep the base model lean, focusing on truly shared functionality.
   - Avoid deep inheritance chains which can complicate debugging and maintenance.

3. **Performance**:
   - Index the discriminator column in STI to speed up queries.
   - Use eager loading in CTI to minimize join operations.

4. **Documentation**:
   - Clearly document the inheritance strategy and rationale in module documentation.
   - Include diagrams if necessary to visualize table relationships and model hierarchies.

## Common Pitfalls and How to Avoid Them

- **Overusing Inheritance**: Use inheritance only when there is a clear, logical relationship between entities. For unrelated functionality, prefer composition or traits.
- **Ignoring Polymorphism**: Leverage Laravel's polymorphic relationships when entities interact with multiple types to avoid hardcoded logic.
- **Performance Overhead**: Regularly profile queries involving inherited models to identify and optimize slow operations.

## Conclusion

Model inheritance, when implemented correctly, provides a powerful way to structure entities like patients and doctors in the Patient module. Choosing the appropriate pattern (STI or CTI) based on data and relationship complexity is key to balancing performance and maintainability. Consistent documentation and adherence to best practices ensure the inheritance structure remains clear and effective over time.

## Related Documentation

- [Single Table Inheritance](SINGLE_TABLE_INHERITANCE.md)
- [Data Transfer Objects](DATA_TRANSFER_OBJECTS.md)
- [Performance Optimization](PERFORMANCE_OPTIMIZATION.md)
- [Error Resolution Guidelines](../../../../docs/ERROR_RESOLUTION_GUIDELINES.md)
- [Validation Errors](./VALIDATION_ERRORS.md)
- [Namespace Conventions](./NAMESPACE_CONVENTIONS.md)
- [Filament Customization](./FILAMENT_CUSTOMIZATION.md)
- [Translations](./TRANSLATIONS.md)
- [URL Localization](./URL_LOCALIZATION.md)
