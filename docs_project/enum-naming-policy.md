# Policy di Naming per Enum

## Regola fondamentale
Il nome della classe enum DEVE sempre corrispondere al nome del file.

- Se il file si chiama `UserTypeEnum.php`, la dichiarazione DEVE essere:
  ```php
  enum UserTypeEnum: string { ... }
  ```
- Se il file si chiama `AppointmentStatusEnum.php`, la dichiarazione DEVE essere:
  ```php
  enum AppointmentStatusEnum: string { ... }
  ```

## Motivazione
- Coerenza tra filesystem e codice
- Autoloading PSR-4 senza errori
- Refactoring e ricerca più semplici
- Prevenzione di bug e ambiguità

## Applicazione
- Aggiornare sempre sia il nome del file che il nome della classe enum
- Aggiornare tutti i riferimenti nei typehint, use statement, docblock
- Propagare la regola in docs/xot.md, .windsurf/rules/ e .cursor/rules/

## Collegamenti
- Vedi anche: docs/xot.md, docs/rules/filament_best_practices.md 