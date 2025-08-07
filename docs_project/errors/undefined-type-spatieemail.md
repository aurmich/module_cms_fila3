# Undefined Type 'Modules\Patient\Filament\Resources\SpatieEmail'

## Descrizione dell'Errore

Questo errore si verifica in `DoctorResource.php` alla linea 358, dove il tipo `Modules\Patient\Filament\Resources\SpatieEmail` non è definito. Inoltre, alla linea 359, ci si aspetta un tipo `Illuminate\Contracts\Mail\Mailable` ma viene trovato `SpatieEmail`.

## Possibili Cause

1. La classe `SpatieEmail` non esiste nel namespace specificato.
2. La classe non implementa l'interfaccia `Mailable`.
3. Manca un'importazione o una configurazione corretta.

## Soluzione Proposta

- Verificare l'esistenza della classe `SpatieEmail` e assicurarsi che implementi `Illuminate\Contracts\Mail\Mailable`.
- Se non esiste, creare la classe o correggere il riferimento.

## Riferimenti

- [Namespace Issues](../../../docs/references/namespace-issues.md)
