## Errore: uso del campo date per Appointment (giugno 2024)

### Descrizione errore
In alcuni file legacy viene usato il campo `date` per Appointment, ma la struttura corretta prevede solo `starts_at`/`ends_at` come campi temporali. L'uso di `date` è un errore di design e va eliminato.

### File coinvolti
- database/migrations/2024_03_31_000010_create_appointments_table.php.old
- resources/views/emails/appointments/reminder.blade.php
- UI/resources/views/components/blocks/appointments_list.blade.php

### Regola
Usare solo `starts_at`/`ends_at` per Appointment. Eliminare ogni riferimento a `date` come colonna o attributo.

### Impatto
- Bug nella visualizzazione e salvataggio appuntamenti
- Incoerenza tra moduli e database
- Refactoring più complesso 