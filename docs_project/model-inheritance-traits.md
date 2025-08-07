# Ereditarietà dei Modelli e Uso dei Trait

## Panoramica

Questo documento descrive la corretta struttura di ereditarietà dei modelli nel sistema SaluteOra e l'utilizzo appropriato dei trait in relazione a questa struttura.

## Catena di Ereditarietà

Il sistema utilizza un'architettura di ereditarietà a più livelli per garantire una separazione delle responsabilità e facilitare il riutilizzo del codice:

```
BaseUser (Modules\User\app\Models\BaseUser)
   ↑
   └── User (Modules\SaluteOra\Models\User)
       ↑
       ├── Doctor (Modules\SaluteOra\Models\Doctor)
       ├── Patient (Modules\SaluteOra\Models\Patient)
       └── Admin (Modules\SaluteOra\Models\Admin)
```

## Trait già disponibili nelle classi base

### BaseUser

La classe `BaseUser` già include i seguenti trait essenziali:
- `HasUuids`
- `HasFactory`
- `Notifiable`
- `HasApiTokens`
- `HasRoles` (Spatie Permission)
- `HasChildren` (Parental)
- `RelationX` (Modulo Xot)
- `HasTeams`

### User (SaluteOra)

La classe `User` di SaluteOra aggiunge i seguenti trait:
- `HasRoles` (ridefinito)
- `LogsActivity`
- `Notifiable` (ridefinito)
- `HasStates` (Spatie ModelStates)

## Errori Comuni da Evitare

1. **Ripetizione di Trait**: Non aggiungere trait nelle classi derivate se sono già presenti nelle classi base.
   ```php
   // ERRATO
   class Doctor extends User
   {
       use RelationX; // Già presente in BaseUser
       use SoftDeletes; // Da aggiungere solo se necessario
       use BelongsToTenant; // Obsoleto, usare HasTenants
   }
   
   // CORRETTO
   class Doctor extends User
   {
       // Nessun trait ridondante
   }
   ```

2. **Uso di trait obsoleti**: Non utilizzare `BelongsToTenant` quando `HasTenants` è già disponibile in `BaseUser`.

3. **Aggiunta prematura di trait**: Non aggiungere trait come `SoftDeletes` fino a quando non sono effettivamente necessari, e in quel caso documentare chiaramente la decisione.

## Principi Guida

1. **Conoscere la catena di ereditarietà**: Prima di modificare un modello, esaminare attentamente le sue classi genitore.
2. **Rispettare la separazione delle responsabilità**: Ogni livello dell'ereditarietà ha uno scopo specifico.
3. **Evitare la ridondanza**: Non duplicare funzionalità già disponibili.
4. **Documentare le decisioni**: Se si aggiunge un nuovo trait, documentare chiaramente il motivo.

## Considerazioni sulla Progettazione

Quando si progettano nuovi modelli o si estendono quelli esistenti, considerare:

1. **Quale livello dell'ereditarietà è più appropriato per la funzionalità**
2. **Se un trait esistente può essere esteso invece di crearne uno nuovo**
3. **L'impatto delle modifiche sui modelli derivati**

## Collegamenti ad Altri Documenti

- [Modello BaseUser](/var/www/html/_bases/base_saluteora/laravel/Modules/User/docs/models/base-user.md)
- [Modello User](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/models/user.md)
- [Modello Doctor](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor.md)
