# Struttura progetto e STI

## Gestione campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [Modello Doctor](../Models/Doctor.md)
- [Gestione campi e migrazioni con STI (README Patient)](../README.md)
- [Standard Xot: Ereditarietà dei Modelli](../../../Xot/docs/standards/README.md)
- [DoctorResource: Step Informazioni Personali](../filament/resources/doctor-resource.md)
- [Migrazioni e database](../database/migrations.md) 
