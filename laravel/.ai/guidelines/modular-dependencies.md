# REGOLE FONDAMENTALI DIPENDENZE MODULARI

## PRINCIPIO ARCHITETTURALE CRITICO

**I MODULI BASE NON POSSONO MAI DIPENDERE DA MODULI SPECIFICI!**

### Gerarchia delle Dipendenze

```
SaluteOra (specifico) ──► User (base)
     ✓ CORRETTO

User (base) ──► SaluteOra (specifico)
     ❌ SBAGLIATO - MAI FARE!
```

### Esempi Concreti

#### ❌ SBAGLIATO:
```php
// Nel modulo User NON può mai esserci:
use Modules\SaluteOra\Enums\UserTypeEnum;

// Questo violerebbe l'architettura modulare!
```

#### ✅ CORRETTO:
```php
// Nel modulo SaluteOra può esserci:
use Modules\User\Models\User;
use Modules\User\Enums\UserType;

// Questo rispetta l'architettura modulare
```

### Regole Pratiche

1. **Modulo User**: Può solo usare i suoi enum/models interni
   - `UserType::MasterAdmin`
   - `UserType::BoUser`
   - `UserType::CustomerUser`
   - `UserType::System`
   - `UserType::Technician`

2. **Modulo SaluteOra**: Può estendere/usare User ma con i suoi enum
   - `UserTypeEnum::ADMIN`
   - `UserTypeEnum::DOCTOR` 
   - `UserTypeEnum::PATIENT`

3. **Test nel modulo User**: Devono usare SOLO le enum/classi del modulo User

### Perché è Importante

- **Modularità**: I moduli base devono essere indipendenti
- **Riusabilità**: User può essere usato in altri progetti senza SaluteOra
- **Manutenibilità**: Cambiare SaluteOra non deve rompere User
- **Architettura Pulita**: Dipendenze fluiscono dal specifico al generico

### Come Verificare

Prima di aggiungere un `use` statement, chiediti:
- "Questo modulo è più generico di quello che sto importando?"
- "Se rimuovo il modulo che sto importando, questo modulo funziona ancora?"

Se la risposta a una delle due è "no", stai violando l'architettura!

### MANTRA DA RICORDARE

🏗️ **"BASE NON DIPENDE DA SPECIFICO"** 🏗️

Questa regola è inviolabile e deve guidare ogni decisione di import/dipendenza tra moduli.