# ApplyMetatagToPanelAction

## Descrizione
Action responsabile dell'applicazione delle configurazioni metatag al pannello Filament.

## Metodi
### execute(Panel &$panel): Panel
Applica le configurazioni metatag al pannello Filament.

#### Parametri
- `$panel`: Panel - Riferimento al pannello Filament da configurare

#### Return
- `Panel` - Il pannello configurato

## Dipendenze
- [MetatagData](../../datas/MetatagData.md)

## Errori PHPStan Comuni
1. Chiamata al metodo inesistente `getColors()`
   - **Problema**: Il metodo viene chiamato su `MetatagData` ma non esiste
   - **Soluzione**: Sostituire con `getFilamentColors()`
   ```php
   // Errato
   ->colors($metatag->getColors())
   
   // Corretto
   ->colors($metatag->getFilamentColors())
   ```

## Note sulla Correzione
La correzione dell'errore PHPStan richiede la modifica del metodo chiamato da `getColors()` a `getFilamentColors()`. Questo metodo è specificamente progettato per restituire i colori nel formato richiesto da Filament.

## Migrazione brandLogo
Quando si configura il logo del brand, sostituire la chiamata deprecata:
```php
// Errato
->brandLogo($metatag->getLogoHeader())
```
con la nuova:
```php
// Corretto
->brandLogo($metatag->getBrandLogo())
```
`getBrandLogo()` offre una semantica chiara per operazioni legate al branding, mentre `getLogoHeader()` è ora deprecato.

## Collegamenti
- [MetatagData](../../datas/MetatagData.md)
- [Filament Best Practices](../../FILAMENT-BEST-PRACTICES.md)
- [PHPStan Common Exceptions](../../PHPSTAN-COMMON-EXCEPTIONS.md) 
## Collegamenti tra versioni di ApplyMetatagToPanelAction.md
* [ApplyMetatagToPanelAction.md](../../../Xot/docs/actions/ApplyMetatagToPanelAction.md)
* [ApplyMetatagToPanelAction.md](../../../Xot/docs/actions/panel/ApplyMetatagToPanelAction.md)


## Collegamenti tra versioni di applymetatagtopanelaction.md
* [applymetatagtopanelaction.md](../applymetatagtopanelaction.md)
