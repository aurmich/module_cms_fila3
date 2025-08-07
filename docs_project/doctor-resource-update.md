# Aggiornamento di DoctorResource.php

## Modifica del 2025-05-15 (Ultimo)

Ho aggiornato il metodo `getPersonalInfoStep` nella classe `DoctorResource.php` per includere i campi `first_name`, `last_name` ed `email`. Questa modifica è essenziale per raccogliere le informazioni personali del dottore, in particolare l'email, che è necessaria per inviare comunicazioni durante il processo di registrazione.

### Dettagli della Modifica
- **Rimozione di `full_name`**: Sostituito con `first_name` e `last_name` per una raccolta dati più granulare.
- **Aggiunta di `email`**: Campo obbligatorio con validazione per unicità nel modello `Doctor`.
- **Motivazione**: L'email è cruciale per l'invio di email di conferma o altre comunicazioni relative alla registrazione.

### Note
Questa modifica è stata implementata per migliorare l'usabilità del processo di registrazione e garantire che tutte le informazioni necessarie siano raccolte al primo passo del wizard.

Ho aggiornato ulteriormente la classe `DoctorResource.php` per risolvere un problema legato alla proprietà `$translationPrefix`. Anche se inizialmente rimossa per seguire le linee guida di `XotBaseResource`, è stata reintrodotta per garantire il corretto funzionamento delle traduzioni. Tuttavia, nei metodi come `getPersonalInfoStep()`, `getContactsStep()`, `getProfessionalStep()`, e `getAvailabilityStep()`, ho rimosso i riferimenti diretti a `$translationPrefix`, utilizzando direttamente il namespace di traduzione (`patient::doctor-resource`).

### Dettagli della Modifica
- **Reintroduzione di `$translationPrefix`**: Necessaria per le traduzioni personalizzate.
- **Rimozione dei riferimenti diretti**: Sostituito l'uso di `$translationPrefix` con namespace di traduzione diretti per migliorare la leggibilità e la coerenza.

### Motivazione
Questa modifica garantisce che le traduzioni siano gestite correttamente senza compromettere le linee guida di centralizzazione di `XotBaseResource`. L'uso di namespace diretti per le traduzioni elimina la dipendenza da variabili statiche nei metodi, rendendo il codice più chiaro.

**Collegamenti correlati**:
- [Documentazione principale](../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Implementazione del workflow](../Modules/Patient/docs/implementation-di.md)
- [Linee Guida XotBaseResource](./xot-base-resource-guidelines.md)
- [Documentazione Doctor Model](./doctor-model-update.md)
