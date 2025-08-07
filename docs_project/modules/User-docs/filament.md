# Filament nel Modulo User

## Documentazione

1. [Errori Comuni](filament-errors.md) - Documentazione degli errori comuni e delle loro soluzioni
2. [Struttura delle Risorse](structure.md#filament-resources) - Come sono strutturate le risorse Filament
3. [Best Practices](filament-errors.md#best-practices) - Best practices per lo sviluppo con Filament

## Risorse

- UserResource
  - TeamsRelationManager
  - RolesRelationManager
  - PermissionsRelationManager
- TeamResource
- RoleResource
- PermissionResource

## Widgets

- LoginWidget
- RecentLoginsWidget
- UserStatsWidget

## RelationManager

### TeamsRelationManager
- Gestisce la relazione many-to-many tra User e Team
- Implementa le operazioni CRUD per i team associati a un utente
- Supporta attach/detach di team esistenti

### RolesRelationManager
- Gestisce la relazione many-to-many tra User e Role
- Implementa le operazioni CRUD per i ruoli associati a un utente
- Supporta attach/detach di ruoli esistenti

### PermissionsRelationManager
- Gestisce la relazione many-to-many tra User e Permission
- Implementa le operazioni CRUD per i permessi associati a un utente
- Supporta attach/detach di permessi esistenti

## Note Importanti

- Seguire sempre le best practices documentate
- Consultare la documentazione degli errori prima di fare modifiche
- Mantenere aggiornata la documentazione con nuovi errori o soluzioni
- Verificare la compatibilità con la versione di Filament in uso

## Versione di Filament

- Versione supportata: 3.x
- Breaking changes: [Documentazione ufficiale](https://filamentphp.com/docs/3.x/panels/upgrade-guide)
- Compatibilità: Laravel 10.x/11.x 