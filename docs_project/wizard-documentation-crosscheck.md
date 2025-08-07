# Regola: Crosscheck Documentazione Wizard/UI

## Analisi dell’Errore
Nel primo step del wizard `FindDoctorAndAppointmentWidget.php` non è stata consultata la documentazione già presente nei file `/docs/images/9.md`, `/docs/images/9.blade.php`, `/docs/images/9.html`. Questo ha portato a una comprensione errata dei requisiti e dell’interfaccia.

## Cause
- Mancata consultazione sistematica dei file di documentazione visuale e funzionale.
- Assenza di una regola operativa che imponga la verifica preventiva.
- Mancata cross-referenziazione tra documentazione e codice/widget.

## Procedura per Prevenire l’Errore
1. Prima di sviluppare o modificare uno step di un wizard, consultare TUTTI i file di documentazione associati (markdown, blade, html in `/docs/images/`, documenti funzionali in `/docs/`).
2. Annotare nel codice il riferimento ai file consultati.
3. Aggiornare la documentazione se ci sono discrepanze.
4. In caso di dubbio, consultare il team di design/analisi.
5. Cross-referenziare nei file di documentazione lo step/widget coinvolto e viceversa.

## Applicazione
- Questa regola è obbligatoria per tutti i wizard, UI step e componenti interattivi.
- Aggiornare questa regola anche nei file `.mdc` e nella documentazione windsurf.

---
Ultimo aggiornamento: 2025-05-27
Responsabile: Cascade AI
