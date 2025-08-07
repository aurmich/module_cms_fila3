# Undefined Method 'can'

## Descrizione dell'Errore

Questo errore si verifica in più punti di `DoctorResource.php` (linee 163, 175, 209, 213), dove il metodo `can()` non è definito per l'oggetto corrente.

## Possibili Cause

1. L'oggetto su cui viene chiamato `can()` non ha il metodo definito.
2. Manca un trait o un'interfaccia che fornisce il metodo `can()`.
3. Potrebbe essere necessario utilizzare un metodo diverso per la verifica dei permessi.

## Soluzione Proposta

- Verificare se il metodo `can()` deve essere sostituito con un altro metodo o se manca un trait come `Authorizable`.
- Considerare l'uso di policy o middleware per la gestione dei permessi.

## Riferimenti

- [Namespace Issues](../../../docs/references/namespace-issues.md)
