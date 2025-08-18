# MedicalHistory

## Introduzione
Il modello `MedicalHistory` rappresenta una voce di storia clinica associata a un utente (paziente). Permette di tracciare eventi, annotazioni, referti o allegati rilevanti per la storia sanitaria.

## Campi principali
- `id`: identificativo univoco
- `user_id`: riferimento all'utente (uuid)
- `date`: data dell'evento clinico (nullable)
- `note`: annotazioni libere (nullable)
- `attachments`: eventuali allegati (stringa lunga, nullable)
- `created_at`, `updated_at`, `deleted_at`: gestione automatica timestamp e soft delete

## Relazioni
- `user()`: relazione BelongsTo verso il modello User

## Best Practice
- Utilizzare sempre la relazione `user()` per accedere all'utente associato
- Validare la presenza di `user_id` e la correttezza della data
- Gestire allegati come path/URL o JSON serializzato se necessario
- Documentare ogni campo e relazione in modo neutro

## Collegamenti correlati
- [User.md](./User.md)
- [Patient.md](./Patient.md)
- [Doctor.md](./Doctor.md)
- [DoctorRegistrationWorkflow.md](./DoctorRegistrationWorkflow.md)
- [INDEX.md](./INDEX.md) 
