# Errore: DoctorResource::getFormSchemaWidget non allineato a PatientResource

## Errore specifico
Il primo step del Wizard in `DoctorResource::getFormSchemaWidget` non era allineato ai file di design forniti:
- `/docs/images/13.md`
- `/docs/images/13.html`
- `/docs/images/13.blade.php`

Il design richiede:
- Campo unico per “Nome e Cognome” (il nome del campo DEVE essere `full_name`)
- FileUpload per “Certificazione iscrizione Ordine”
- Nessun altro campo nel primo step
- UI coerente con l'immagine e il markup fornito

**Nota vincolante:**
Se il design prevede un campo unico per nome e cognome, il nome del campo deve essere sempre `full_name` (mai `name`, `first_name`, `last_name`).

### Motivo dell'errore
- Non sono stati presi come riferimento i file di design/documentazione forniti
- Mancata verifica della coerenza tra UX, documentazione e codice
- Riutilizzo di pattern generici invece di allinearsi al design validato

## Regola vincolante
- Ogni volta che si implementa o aggiorna un Wizard simile, **il primo step DEVE essere allineato ai file di design forniti** (md/blade/html)
- La fonte dei dati di input e delle scelte UI va sempre citata nella doc
- La procedura va seguita anche in fase di refactoring

## Procedura obbligatoria
1. Consultare SEMPRE i file di design forniti prima di implementare/aggiornare il primo step
2. Citare la fonte nella doc del modulo
3. Inserire collegamento bidirezionale a questa doc in ogni best practice relativa ai Wizard/PatientResource

---

**Questa regola è ora parte delle convenzioni interne di sviluppo dei moduli.**
