# Errore Namespace UserResource

## Problema
Il file `UserResource.php` utilizza un namespace errato. Attualmente è:
```php
namespace Modules\SaluteOra\App\Filament\Resources;
```

## Soluzione
Il namespace corretto dovrebbe essere:
```php
namespace Modules\SaluteOra\Filament\Resources;
```

## Motivazione
- Il namespace deve riflettere la struttura delle cartelle
- Le risorse Filament devono essere nel namespace `Filament\Resources`
- Questo garantisce coerenza con la struttura del modulo e facilita l'autoloading
- Non usiamo mai `App\` nel namespace dei moduli

## Implicazioni
- Tutti i riferimenti alla classe UserResource devono essere aggiornati
- Eventuali import in altri file potrebbero dover essere aggiornati
- La documentazione deve essere aggiornata per riflettere il namespace corretto

## Collegamenti
- [Namespace Conventions](../../namespace.md)
- [Filament Directory Structure](../../filament-directory-structure.md)
- [XotBase Resource Guidelines](../../xot-base-resource-guidelines.md)
- [Indice Documentazione Centrale](../../../docs/INDEX.md)
- [Regole Namespace Xot](../../../Modules/Xot/docs/namespace-rules.md) 