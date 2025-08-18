## Moderazione
- Tutta la logica di moderazione (stato, approvazione, rifiuto, sospensione, ecc.) va gestita tramite i campi `state`, `type`, `moderation_data` di questo modello.
- Non introdurre mai un modello UserModeration separato, salvo esigenze avanzate (vedi [UserModeration_model_valutazione.md](../UserModeration_model_valutazione.md)).
- L'audit trail delle transizioni di stato va gestito tramite activitylog. 
