# Errori nell'uso di label e placeholder nei widget Filament

## Descrizione
Gli errori relativi all'uso di `->label()` e `->placeholder()` nei widget Filament sono comuni e possono causare problemi di manutenibilità e localizzazione.

## Contesto
Nel modulo SaluteOra, i widget Filament devono seguire le convenzioni di localizzazione e utilizzare correttamente le traduzioni.

## Cause
1. Uso diretto di stringhe hardcoded in `->label()` e `->placeholder()`
2. Mancanza di utilizzo delle traduzioni
3. Inconsistenza nell'uso delle chiavi di traduzione

## Soluzioni
1. Utilizzare sempre le traduzioni per label e placeholder:
```php
// ❌ Non fare questo
->label('Tipo di visita')
->placeholder('Inserisci note')

// ✅ Fare questo
->label(trans('saluteora::fields.appointment_type'))
->placeholder(trans('saluteora::placeholders.notes'))
```

2. Seguire la convenzione di naming per le chiavi di traduzione:
- `saluteora::fields.*` per le label dei campi
- `saluteora::placeholders.*` per i placeholder
- `saluteora::messages.*` per i messaggi
- `saluteora::buttons.*` per i pulsanti

3. Mantenere le traduzioni in file separati per lingua:
```
resources/lang/it/saluteora.php
resources/lang/en/saluteora.php
```

## Best Practices
1. Non utilizzare mai stringhe hardcoded
2. Utilizzare sempre la funzione `trans()`
3. Mantenere le chiavi di traduzione organizzate e documentate
4. Verificare la presenza di tutte le traduzioni necessarie
5. Utilizzare prefissi coerenti per le chiavi di traduzione

## Checklist
- [ ] Rimuovere tutte le stringhe hardcoded
- [ ] Utilizzare `trans()` per tutte le label e placeholder
- [ ] Verificare la presenza delle traduzioni in tutti i file di lingua
- [ ] Documentare le nuove chiavi di traduzione
- [ ] Testare l'applicazione in tutte le lingue supportate

## Documentazione Correlata
- [Convenzioni di Traduzione](../translations.md)
- [Best Practices Filament](../standards/filament-best-practices.md)
- [Gestione delle Lingue](../langserviceprovider-labels.md) 