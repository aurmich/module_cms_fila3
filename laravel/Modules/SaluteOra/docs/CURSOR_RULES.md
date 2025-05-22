## Regola: Struttura File e Namespace

### Struttura File
- Tutti i file PHP devono essere sotto la directory `app/`
- Non creare mai directory come `Enums`, `Models`, `Filament` direttamente nella root del modulo
- La struttura corretta è sempre `Modules/<Modulo>/app/<Tipo>/<File>`

### Namespace
- Il namespace base è `Modules\<Modulo>\`
- Non includere mai `app\` nel namespace
- Esempio:
  ```php
  // File: Modules/SaluteOra/app/Enums/UserType.php
  namespace Modules\SaluteOra\Enums;
  ```

### Checklist
- [ ] File sotto `app/`
- [ ] Namespace senza `app\`
- [ ] Eseguito `composer dump-autoload`
- [ ] IDE riconosce il file
- [ ] Test passano 