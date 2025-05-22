# BaseUser

La classe `BaseUser` è una classe astratta che implementa le interfacce `UserContract` e `HasTeamsContract`. Fornisce l'implementazione base per la gestione degli utenti nel sistema.

## Interfacce Implementate

- `UserContract`: Contratto base per gli utenti
- `HasTeamsContract`: Contratto per la gestione dei team

## Traits Utilizzati

- `HasApiTokens`
- `HasFactory`
- `HasRoles`
- `HasTeams`
- `HasUuids`
- `HasAuthenticationLogTrait`
- `HasTenantsRelation`
- `Notifiable`
- `RelationX`

## Relazioni Principali

- `tenants(): BelongsToMany<Tenant>` - Relazione many-to-many con i tenant
- `teams(): BelongsToMany<Team>` - Relazione many-to-many con i team
- `roles(): BelongsToMany<Role>` - Relazione many-to-many con i ruoli
- `devices(): BelongsToMany<Device>` - Relazione many-to-many con i dispositivi
- `socialiteUsers(): HasMany<SocialiteUser>` - Relazione one-to-many con gli account social
- `authentications(): HasMany<AuthenticationLog>` - Relazione one-to-many con i log di autenticazione

## Metodi Principali

### Team Management

- `teamRole(Team $team): ?string` - Ottiene il ruolo dell'utente nel team specificato
- `canRemoveTeamMember(Team $team, HasTeamsContract $user): bool` - Verifica se l'utente può rimuovere un membro del team
- `canUpdateTeamMember(Team $team, HasTeamsContract $user): bool` - Verifica se l'utente può aggiornare un membro del team
- `teamPermissions(Team $team): array<string, bool>` - Ottiene i permessi dell'utente nel team

### Role Management

- `hasRole($roles, ?string $guard = null): bool` - Verifica se l'utente ha un determinato ruolo
- `assignRole($roles): self` - Assegna uno o più ruoli all'utente
- `removeRole($role): self` - Rimuove un ruolo dall'utente

## Note Importanti

- La classe utilizza UUID come chiave primaria
- Implementa il multi-tenancy attraverso la relazione `tenants`
- Supporta l'autenticazione social attraverso la relazione `socialiteUsers`
- Gestisce i log di autenticazione attraverso la relazione `authentications`

## Documentazione Correlata

- [Integrazione Laravel Passport](./passport.md) - Configurazione e utilizzo di OAuth2 con Laravel Passport
- [Trait HasAuthenticationLog](./traits/has_authentication_log.md) - Dettagli sul logging degli eventi di autenticazione

## Collegamenti Correlati

# BaseUser Model in Laravel Modules

## Overview
This document outlines the structure and usage of the `BaseUser` model within a Laravel module, serving as the foundation for user-related functionality.

## Key Principles
1. **Inheritance**: `BaseUser` provides common attributes and methods for all user types, allowing for easy extension.
2. **Modularity**: Designed to be reusable across projects without modification.
3. **Customization**: Can be extended to include specific user types like admin or customer.

## Implementation Guidelines
### 1. Model Structure
- The `BaseUser` model includes essential fields like `id`, `name`, `email`, and authentication-related attributes.
  ```php
  namespace Modules\User\Models;

  use Illuminate\Foundation\Auth\User as Authenticatable;

  class BaseUser extends Authenticatable
  {
      protected $fillable = ['name', 'email', 'password'];
      // Common methods and relationships
  }
  ```

### 2. Extending BaseUser
- Create specific user models by extending `BaseUser` to add custom fields or logic.
  ```php
  namespace Modules\User\Models;

  class User extends BaseUser
  {
      protected $fillable = ['name', 'email', 'password', 'role'];
      // Custom logic for this user type
  }
  ```

### 3. Single Table Inheritance
- Use single table inheritance to manage different user types within the same database table, using a `type` column to differentiate.

## Common Issues and Fixes
- **Inheritance Conflicts**: Ensure that extending models do not redefine essential `BaseUser` methods unless intentional.
- **Attribute Overlap**: Avoid duplicating attributes in child models that are already defined in `BaseUser`.

## Documentation and Updates
- Document any custom extensions or modifications to `BaseUser` in the relevant module's documentation folder.
- Update this document if significant changes are made to the `BaseUser` structure or functionality.

## Links to Related Documentation
- [User Module Index](./INDEX.md)
- [Authentication Pages Implementation](./AUTH_PAGES_IMPLEMENTATION.md)
- [Profile Management](./PROFILE_MANAGEMENT.md)
- [Routing Best Practices](./ROUTING_BEST_PRACTICES.md)
- [Session Management](./SESSION_MANAGEMENT.md)
- [[HasTeamsContract]]
- [[UserContract]]
- [[Team]]
- [[Role]]
- [[Tenant]]
- [[Device]]
- [[SocialiteUser]]
- [[AuthenticationLog]] 

## Collegamenti tra versioni di BaseUser.md
* [BaseUser.md](../../../User/docs/BaseUser.md)
* [BaseUser.md](../../../User/docs/Models/BaseUser.md)


## Collegamenti tra versioni di baseuser.md
* [baseuser.md](Models/baseuser.md)

