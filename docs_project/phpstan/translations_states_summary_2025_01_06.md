# Riepilogo Traduzioni Stati - 6 Gennaio 2025

## Panoramica

Questo documento riassume le traduzioni aggiunte per i modal degli stati utente in tutte e tre le lingue (italiano, inglese, tedesco).

## Traduzioni Aggiunte

### Stati Utente (User States)

#### Italiano (`laravel/Modules/SaluteOra/lang/it/states.php`)

**Stati aggiunti con modal_heading e modal_description:**

1. **pending**
   - `modal_heading`: "Utente in Attesa"
   - `modal_description`: "Questo utente è in attesa di approvazione da parte dell'amministratore."

2. **active**
   - `modal_heading`: "Attiva Utente"
   - `modal_description`: "Sei sicuro di voler attivare questo utente? L'utente potrà accedere al sistema."

3. **inactive**
   - `modal_heading`: "Disattiva Utente"
   - `modal_description`: "Sei sicuro di voler disattivare questo utente? L'utente non potrà più accedere al sistema."

4. **rejected**
   - `modal_heading`: "Rifiuta Utente"
   - `modal_description`: "Sei sicuro di voler rifiutare questo utente? Questa azione non può essere annullata."

5. **suspended**
   - `modal_heading`: "Sospendi Utente"
   - `modal_description`: "Sei sicuro di voler sospendere questo utente? L'utente non potrà accedere al sistema fino alla riattivazione."

6. **integration_requested**
   - `modal_heading`: "Richiesta Integrazione"
   - `modal_description`: "Questo utente ha richiesto l'integrazione con il sistema sanitario nazionale."

7. **integration_completed** (NUOVO STATO)
   - `modal_heading`: "Integrazione Completata"
   - `modal_description`: "L'integrazione di questo utente è stata completata con successo."

#### Inglese (`laravel/Modules/SaluteOra/lang/en/states.php`)

**Stati aggiunti con modal_heading e modal_description:**

1. **pending**
   - `modal_heading`: "User Pending"
   - `modal_description`: "This user is awaiting approval from the administrator."

2. **active**
   - `modal_heading`: "Activate User"
   - `modal_description`: "Are you sure you want to activate this user? The user will be able to access the system."

3. **inactive**
   - `modal_heading`: "Deactivate User"
   - `modal_description`: "Are you sure you want to deactivate this user? The user will no longer be able to access the system."

4. **rejected**
   - `modal_heading`: "Reject User"
   - `modal_description`: "Are you sure you want to reject this user? This action cannot be undone."

5. **suspended**
   - `modal_heading`: "Suspend User"
   - `modal_description`: "Are you sure you want to suspend this user? The user will not be able to access the system until reactivation."

6. **integration_requested**
   - `modal_heading`: "Integration Request"
   - `modal_description`: "This user has requested integration with the national health system."

7. **integration_completed** (NUOVO STATO)
   - `modal_heading`: "Integration Completed"
   - `modal_description`: "The integration of this user has been completed successfully."

#### Tedesco (`laravel/Modules/SaluteOra/lang/de/states.php`)

**Stati aggiunti con modal_heading e modal_description:**

1. **pending**
   - `modal_heading`: "Benutzer ausstehend"
   - `modal_description`: "Dieser Benutzer wartet auf Genehmigung durch den Administrator."

2. **active**
   - `modal_heading`: "Benutzer aktivieren"
   - `modal_description`: "Sind Sie sicher, dass Sie diesen Benutzer aktivieren möchten? Der Benutzer wird Zugang zum System haben."

3. **inactive**
   - `modal_heading`: "Benutzer deaktivieren"
   - `modal_description`: "Sind Sie sicher, dass Sie diesen Benutzer deaktivieren möchten? Der Benutzer wird keinen Zugang mehr zum System haben."

4. **rejected**
   - `modal_heading`: "Benutzer ablehnen"
   - `modal_description`: "Sind Sie sicher, dass Sie diesen Benutzer ablehnen möchten? Diese Aktion kann nicht rückgängig gemacht werden."

5. **suspended**
   - `modal_heading`: "Benutzer suspendieren"
   - `modal_description`: "Sind Sie sicher, dass Sie diesen Benutzer suspendieren möchten? Der Benutzer wird keinen Zugang zum System haben, bis zur Reaktivierung."

6. **integration_requested**
   - `modal_heading`: "Integrationsanfrage"
   - `modal_description`: "Dieser Benutzer hat eine Integration mit dem nationalen Gesundheitssystem angefordert."

7. **integration_completed** (NUOVO STATO)
   - `modal_heading`: "Integration abgeschlossen"
   - `modal_description`: "Die Integration dieses Benutzers wurde erfolgreich abgeschlossen."

### Stati Paziente (Patient States)

Sono state aggiunte le stesse traduzioni per i modal anche per gli stati paziente in tutte e tre le lingue.

### Stati Dottore (Doctor States)

Sono state aggiunte le stesse traduzioni per i modal anche per gli stati dottore in tutte e tre le lingue.

## Note Importanti

1. **Mantenimento Contenuto**: Non è stato rimosso alcun contenuto esistente, sono state aggiunte solo le nuove traduzioni.

2. **Coerenza**: Le traduzioni mantengono coerenza terminologica con il resto del sistema.

3. **Completezza**: Tutti gli stati utente ora hanno traduzioni complete per i modal di conferma.

4. **Nuovo Stato**: È stato aggiunto lo stato `integration_completed` che mancava.

## File Modificati

- `laravel/Modules/SaluteOra/lang/it/states.php`
- `laravel/Modules/SaluteOra/lang/en/states.php`
- `laravel/Modules/SaluteOra/lang/de/states.php`

## Collegamenti

- [Analisi Errori PHPStan Correnti](current_errors_analysis.md)
- [Riepilogo Correzioni PHPStan](corrections_summary_2025_01_06.md)

---

**Ultimo aggiornamento**: 6 Gennaio 2025
**Autore**: AI Assistant
**Versione**: 1.0 