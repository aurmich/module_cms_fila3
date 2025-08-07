# Console Commands - Modulo User

## Panoramica
I comandi console del modulo User forniscono interfacce interattive moderne per la gestione di utenti, ruoli e moduli.

## Comandi Disponibili

### AssignModuleCommand
**Comando**: `user:assign-module`
**Descrizione**: Assegnazione/revoca moduli con multiselect pre-checked
**Funzionalità**:
- ✅ Multiselect interattivo con Laravel Prompts
- ✅ Moduli già assegnati pre-checked
- ✅ Assegnazione nuovi moduli
- ✅ Revoca moduli dechecked
- ✅ Feedback visivo completo
- ✅ Gestione errori robusta

**Utilizzo**:
```bash
php artisan user:assign-module
```

**Esempio Output**:
```
email ? admin@example.com
Current modules for admin@example.com: User, Xot, UI

Select modules (checked = assigned, unchecked = will be revoked):
 ◉ User
 ◉ Xot  
 ◉ UI
 ◯ Performance
 ◯ Patient

✓ Assigned module: Performance
✗ Revoked module: UI
Module assignment updated for admin@example.com
```

### AssignRoleCommand
**Comando**: `user:assign-role`
**Descrizione**: Assegnazione ruoli specifici
**Documentazione**: [Dettagli](assign-role-command.md)

### RemoveRoleCommand
**Comando**: `user:remove-role`
**Descrizione**: Rimozione ruoli specifici
**Documentazione**: [Dettagli](remove-role-command.md)

### SuperAdminCommand
**Comando**: `user:super-admin`
**Descrizione**: Gestione super admin
**Documentazione**: [Dettagli](super-admin-command.md)

## Architettura

### Filosofia Laraxot
- **Strict Types**: `declare(strict_types=1);` obbligatorio
- **Laravel Prompts**: Solo API moderne (`text()`, `multiselect()`)
- **XotData**: Accesso centralizzato ai dati
- **Contracts**: Type safety con interfacce
- **Error Handling**: Controlli preventivi

### Pattern Comuni
```php
// Recupero utente con controllo
$user = XotData::make()->getUserByEmail($email);
if (!$user) {
    $this->error("User with email '{$email}' not found.");
    return;
}

// Prompts interattivi
$email = text('email ?');
$selectedModules = multiselect(
    label: 'Select modules',
    options: $modules_opts,
    default: $currentModules,
    required: false,
    scroll: 10,
);
```

## Gestione Ruoli

### Pattern dei Ruoli
- **Formato**: `{module}::admin` (es. `user::admin`, `performance::admin`)
- **Creazione**: `Role::firstOrCreate()` automatica
- **Guard**: Default web guard
- **Relazioni**: `model_has_roles` pivot table

### Operazioni Supportate
- **Assegnazione**: `$user->assignRole($role)`
- **Revoca**: `$user->removeRole($role_name)`
- **Verifica**: `$user->hasRole($role)`
- **Lista**: `$user->roles` (relazione)

## Best Practices

### Codice
- Utilizzare sempre `declare(strict_types=1);`
- Implementare controlli preventivi per utenti non trovati
- Fornire feedback visivo chiaro per ogni operazione
- Gestire errori con messaggi appropriati
- Utilizzare contracts per type safety

### UX
- Mostrare stato corrente prima delle modifiche
- Utilizzare simboli visivi (✓, ✗) per feedback
- Permettere operazioni di revoca
- Fornire messaggi di riepilogo
- Gestire casi edge (utente non trovato, nessuna modifica)

### Testing
- Verificare sintassi con `php -l`
- Testare con utenti esistenti e non esistenti
- Verificare assegnazione e revoca
- Controllare feedback visivo
- Testare gestione errori

## Collegamenti
- [Console Commands Philosophy](console_commands_philosophy.md)
- [User Models](../models/README.md)
- [Role Management](../models/role-management.md)
- [README.md](../README.md)

## Aggiornamenti Recenti

### 2025-01-27 - AssignModuleCommand
- ✅ **Multiselect con Pre-checked**: I moduli già assegnati sono pre-checked
- ✅ **Revoca Moduli**: Possibilità di revocare moduli dechecking
- ✅ **Feedback Migliorato**: Messaggi chiari per assegnazioni e revoche
- ✅ **Gestione Errori**: Controlli preventivi per utenti non trovati
- ✅ **Documentazione**: Documentazione completa con esempi

*Ultimo aggiornamento: 2025-01-27* 