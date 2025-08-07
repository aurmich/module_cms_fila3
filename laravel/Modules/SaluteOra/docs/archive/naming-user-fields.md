# Errore: Uso di `name` e `surname` invece di `first_name` e `last_name`

## Problema
Nel modulo Patient è stato usato `name` e/o `surname` per rappresentare nome e cognome di una persona. Questo è un errore.

## Regola corretta
- Usare SEMPRE `first_name` per il nome di battesimo
- Usare SEMPRE `last_name` per il cognome
- Se il design richiede un campo unico per "Nome e Cognome", il nome del campo deve essere SEMPRE `full_name` (mai `name`, `first_name`, `last_name`)
- **Mai** usare `name` o `surname` nei modelli, form, API, migrazioni, traduzioni

## Implementazione
- Tutti i modelli devono usare `first_name` e `last_name` nei loro attributi
- Tutte le migrazioni devono definire colonne `first_name` e `last_name` (mai `name` o `surname`)
- Tutti i form e le API devono accettare e restituire `first_name` e `last_name`
- Le traduzioni devono mappare correttamente questi campi nelle varie lingue
- **Eccezione:** Se il design richiede un campo unico per "Nome e Cognome", il nome del campo deve essere SEMPRE `full_name` (mai `name`, `first_name`, `last_name`).

## Motivazione
Vedi la [doc generale in Xot](../../Xot/docs/naming-user-fields.md) per spiegazioni dettagliate su coerenza, internazionalizzazione, compatibilità e best practice.

## Collegamenti
- [Doc generale naming campi utente in Xot](../../Xot/docs/naming-user-fields.md)

**Questa regola è obbligatoria per tutti i moduli.**

## Collegamenti tra versioni di naming-user-fields.md
* [naming-user-fields.md](../../Xot/docs/naming-user-fields.md)

## Wizard Step nei Resource Filament
- Nei wizard step di registrazione (es. DoctorResource) usare SEMPRE i campi `first_name`, `last_name`, `email`.
- **Mai** usare `full_name` come campo di input principale.
- La composizione di full_name va fatta solo a livello di model/accessor, mai nel form.
- Motivazione: coerenza, internazionalizzazione, compatibilità, best practice di naming.
- Vedi anche: [filament-resources.md](filament-resources.md)

