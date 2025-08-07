# Undefined Type 'Modules\Tenant\Facades\Tenant'

## Descrizione dell'Errore

Questo errore si verifica in `DoctorResource.php` alla linea 122, dove il tipo `Modules\Tenant\Facades\Tenant` non è definito.

## Possibili Cause

1. La classe `Tenant` non esiste nel namespace specificato.
2. Manca un'importazione corretta della classe.
3. La classe si trova in un altro namespace o modulo.

## Soluzione Proposta

- Verificare l'esistenza della classe `Tenant` nel namespace `Modules\Tenant\Facades`.
- Se non esiste, creare la facade o correggere il riferimento al namespace corretto.
- Assicurarsi che il modulo `Tenant` sia correttamente configurato e caricato.

## Riferimenti

- [Namespace Issues](../../../docs/references/namespace-issues.md)
