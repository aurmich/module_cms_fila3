# Gestione delle Traduzioni

## Documentazione Principale

- [Regole Generali](../../Xot/docs/translations.md) - Regole generali per tutte le traduzioni
- [Regole CMS](../../Cms/docs/translations.md) - Regole specifiche per il CMS

## Struttura delle Traduzioni

### 1. Regole Generali
- Tutte le traduzioni devono essere gestite tramite file di traduzione
- Non utilizzare mai stringhe hardcoded
- Seguire la struttura gerarchica dei namespace
- Mantenere la coerenza tra i file
- Utilizzare il prefisso del modulo (es: `cms::`) per le traduzioni
- Mantenere la coerenza tra le diverse lingue

### 2. Regole Specifiche CMS
- Gestione dei blocchi di contenuto
- Traduzioni per form e campi
- Struttura gerarchica per sezioni e blocchi
- Tooltip e descrizioni per tutti i campi

## Best Practices

### 1. Organizzazione
- Mantenere una struttura coerente
- Utilizzare namespace corretti
- Creare collegamenti bidirezionali
- Documentare le eccezioni

### 2. Implementazione
- Utilizzare sempre le traduzioni
- Aggiungere tooltip descrittivi
- Includere messaggi di validazione
- Gestire le traduzioni per le azioni

### 3. Manutenzione
- Aggiornare regolarmente la documentazione
- Verificare la presenza di stringhe hardcoded
- Controllare la coerenza tra i file
- Testare le traduzioni

## Troubleshooting

### Problemi Comuni
1. **Stringhe Hardcoded**
   - Verificare che non ci siano `->label()` con stringhe
   - Utilizzare sempre le traduzioni

2. **Namespace Errati**
   - Controllare che i namespace non includano `App`
   - Seguire la struttura corretta

3. **Traduzioni Mancanti**
   - Verificare la presenza di tutte le traduzioni
   - Aggiungere le traduzioni mancanti

4. **Struttura Errata**
   - Seguire la gerarchia corretta
   - Mantenere la coerenza tra i file

## Collegamenti Utili

- [Documentazione Laravel](https://laravel.com/docs/10.x/localization)
- [Best Practices Filament](https://filamentphp.com/docs/3.x/panels/resources/forms#localization)
- [Guida Traduzioni](https://laravel.com/docs/10.x/localization#using-translation-strings-as-keys) 

## Collegamenti tra versioni di translations.md
* [translations.md](../../../Chart/docs/translations.md)
* [translations.md](../../../Reporting/docs/translations.md)
* [translations.md](../../../Gdpr/docs/translations.md)
* [translations.md](../../../Notify/docs/translations.md)
* [translations.md](../../../Xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../Xot/docs/translations.md)
* [translations.md](../../../Dental/docs/translations.md)
* [translations.md](../../../User/docs/translations.md)
* [translations.md](../../../UI/docs/translations.md)
* [translations.md](../../../Lang/docs/packages/translations.md)
* [translations.md](../../../Lang/docs/translations.md)
* [translations.md](../../../Job/docs/translations.md)
* [translations.md](../../../Media/docs/translations.md)
* [translations.md](../../../Tenant/docs/translations.md)
* [translations.md](../../../Activity/docs/translations.md)
* [translations.md](../../../Patient/docs/translations.md)
* [translations.md](../../../Cms/docs/translations.md)

