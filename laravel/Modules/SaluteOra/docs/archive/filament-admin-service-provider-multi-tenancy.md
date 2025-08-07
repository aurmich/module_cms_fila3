# Modifiche Dettagliate a AdminServiceProvider per Multi-Tenancy e Visibilità UserType (STI/Parental) in Filament

---

## Regola fondamentale: UserType enum

**Non usare mai costanti stringa per i tipi utente.** Usare sempre l'enum `UserType` (implementa HasLabel Filament) per ogni controllo, policy, scoping, navigation.

### Esempio enum:
```php
use Modules\Patient\Enums\UserType;
use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    public function getLabel(): string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
}
```

---

## 1. Concetti Chiave: Parental (STI) e Filament

- Il modello `User` usa [Parental (Single Table Inheritance)](../standards/single-table-inheritance.md):
  - Il campo `type` è castato a `UserType::class`.
  - Tutte le policies, scoping, navigation devono usare `user->type === UserType::DOCTOR` ecc.
- **Vantaggi**: type safety, refactoring, compatibilità Filament, uniformità tra moduli.

---

## 2. Flusso di Autenticazione e Identificazione Type

- All'accesso, recuperare l'utente autenticato (`auth()->user()`)
- Determinare il type:
  - Patient: `user->type === UserType::PATIENT`
  - Doctor: `user->type === UserType::DOCTOR`
  - Admin: `user->type === UserType::ADMIN`
- In base al type, applicare scoping, navigation e policies diverse
- **Nota**: se il type non è valorizzato, mostrare errore o forzare logout

---

## 3. Setup Tenancy e Scoping in AdminServiceProvider

### 3.1. Patient (UserType::PATIENT)
- **Disabilitare tenancy** (nessun tenant attivo)
- **Filtrare risorse**:
  - Appuntamenti: mostrare solo quelli dove `appointment.user_id == user->id`
  - Dati personali: mostrare solo il proprio profilo
- **Implementazione**:
  - In `bootPanel()` o `panel()` di AdminServiceProvider, registrare un global scope su AppointmentResource e PatientResource:
    ```php
    Appointment::addGlobalScope('patient', function ($query) {
        $user = auth()->user();
        if ($user?->type === UserType::PATIENT) {
            $query->where('user_id', $user->id);
        }
    });
    Patient::addGlobalScope('self', function ($query) {
        $user = auth()->user();
        if ($user?->type === UserType::PATIENT) {
            $query->where('id', $user->id);
        }
    });
    ```
  - Bloccare accesso a risorse non pertinenti tramite policies o Filament navigation
  - **Edge case**: se un patient tenta di accedere a risorse tenant, mostrare errore 403

### 3.2. Doctor (UserType::DOCTOR)
- **Abilitare tenancy**: settare il tenant corrente (studio medico)
- **Filtrare risorse**:
  - Pazienti: mostrare solo quelli associati allo studio selezionato (tenant)
  - Appuntamenti: mostrare solo quelli dello studio selezionato
  - Studi: mostrare solo quelli dove il doctor è associato
- **Implementazione**:
  - In `bootPanel()`, usare il middleware tenancy di Filament:
    ```php
    Filament::setTenantResolver(function () {
        $user = auth()->user();
        if ($user?->type === UserType::DOCTOR) {
            return $user->currentStudio();
        }
        return null;
    });
    ```
  - Applicare global scope su Patient, Appointment, ecc.:
    ```php
    Patient::addGlobalScope('tenant', function ($query) {
        if (Filament::getTenant()) {
            $query->where('studio_id', Filament::getTenant()->id);
        }
    });
    Appointment::addGlobalScope('tenant', function ($query) {
        if (Filament::getTenant()) {
            $query->where('studio_id', Filament::getTenant()->id);
        }
    });
    ```
  - Consentire switch tenant (studio) tramite dropdown o menu custom
  - **Edge case**: se il doctor non ha studi associati, mostrare messaggio e bloccare accesso alle risorse tenant

### 3.3. Admin (UserType::ADMIN)
- **Disabilitare tenancy** (o abilitare super-tenant/global)
- **Accesso completo** a tutte le risorse
- **Moderazione**: può accedere a tutte le risorse, vedere e modificare dati di pazienti e dottori, accedere a reportistiche
- **Implementazione**:
  - Nessun global scope limitante
  - Policies che permettono tutte le azioni
  - Navigation completa
  - **Edge case**: se l'admin ha anche altri type (STI), dare priorità a admin

---

## 4. Policies, Navigation e Scoping Avanzato

### 4.1. Policies custom (esempio Appointment)
```php
public function view(User $user, Appointment $appointment)
{
    if ($user->type === UserType::ADMIN) {
        return true;
    }
    if ($user->type === UserType::DOCTOR) {
        return $appointment->studio_id === $user->currentStudio()?->id;
    }
    if ($user->type === UserType::PATIENT) {
        return $appointment->user_id === $user->id;
    }
    return false;
}
```
- **Nota**: tutte le policies devono sempre controllare il type tramite enum UserType

### 4.2. Navigation dinamica
```php
$panel->navigation(function (NavigationBuilder $nav) {
    $user = auth()->user();
    if ($user->type === UserType::PATIENT) {
        $nav->add(PatientAppointmentsResource::class);
    } elseif ($user->type === UserType::DOCTOR) {
        $nav->add(StudioResource::class);
        $nav->add(PatientResource::class);
    } elseif ($user->type === UserType::ADMIN) {
        $nav->add(PatientResource::class);
        $nav->add(DoctorResource::class);
        $nav->add(ReportResource::class);
    }
});
```
- **Best practice**: mostrare solo le voci di menu pertinenti al type e tenant attivo

---

## Collegamenti
- [Regola UserType Enum](./Enums/ENUM_USER_TYPE.mdc)
- [Best Practices Enum](./Enums/ENUM_BEST_PRACTICES.md)
- [Filament Enums Docs](https://filamentphp.com/docs/3.x/support/enums)
- [Parental (STI) Best Practice](../standards/single-table-inheritance.md)
