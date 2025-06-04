# AdminPanelProvider – Best Practice e Policy

## Ruolo
- Centralizza la configurazione del pannello Filament admin per il modulo SaluteMo.
- Permette di registrare widget, plugin, policy, branding, tenancy, ecc.

## Regole fondamentali
- Estendere sempre `Modules\Xot\Providers\Filament\XotBasePanelProvider`.
- Non duplicare logica già gestita dalla base.
- Namespace: `Modules\SaluteMo\Providers\Filament`.
- Tipizzazione e PHPDoc completi.
- Documentare ogni personalizzazione.

## Esempio di struttura

```php
namespace Modules\SaluteMo\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'SaluteMo';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Custom widgets, plugins, etc.

        return $panel;
    }
}
```

## Checklist
- [x] Estende XotBasePanelProvider
- [x] Namespace corretto
- [x] Tipizzazione e PHPDoc
- [x] Solo personalizzazioni specifiche
- [x] Documentazione aggiornata

## Collegamenti
- [Regole ServiceProvider](../../Xot/docs/SERVICE_PROVIDER.md)
- [Best Practice Filament](../../Xot/docs/filament/README.md)
