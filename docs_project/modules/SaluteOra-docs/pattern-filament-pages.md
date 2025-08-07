# Pattern Pagine Filament nel Progetto SaluteOra

## Architettura di Base

Nel progetto SaluteOra, tutte le pagine Filament seguono una struttura basata sul pattern di ereditarietà dove:

1. Le classi base con prefisso `XotBase*` sono astratte e si trovano in `Modules\Xot\app\Filament\Resources\Pages\`
2. Le classi concrete (es. `ListStudios`, `CreateStudio`, `EditStudio`, `ViewStudio`) implementano i metodi astratti richiesti

## Pattern per Pagine di Visualizzazione (ViewRecord)

### Struttura Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Resources\{ResourceName}\Pages;

use Modules\{ModuleName}\Filament\Resources\{ResourceName}Resource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class View{ModelName} extends XotBaseViewRecord
{
    protected static string $resource = {ResourceName}Resource::class;
    
    /**
     * Implementazione del metodo astratto dalla classe base.
     * Questo metodo deve esistere in ogni pagina di visualizzazione.
     */
    protected function getInfolistSchema(): array
    {
        return $this->getResource()::getInfolistSchema();
    }
}
```

### Errori Comuni

1. **Mancata Implementazione di Metodi Astratti**

   ```php
   // ERRORE: Manca l'implementazione di getInfolistSchema()
   class ViewStudio extends XotBaseViewRecord
   {
       protected static string $resource = StudioResource::class;
   }
   ```

2. **Confusione tra Metodi Statici e Non Statici**

   ```php
   // ERRORE: Il metodo deve essere non statico
   public static function getInfolistSchema(): array
   {
       // ...
   }
   ```

3. **Implementazione Diretta invece del Reindirizzamento alla Risorsa**

   ```php
   // APPROCCIO SCONSIGLIATO: Duplicazione del codice
   protected function getInfolistSchema(): array
   {
       return [
           // Duplicazione dello schema dalla risorsa
       ];
   }
   ```

## Pattern per Risorse (Resource)

In ogni risorsa Filament, definiamo gli schemi per form, tabelle e infolist come metodi statici:

```php
class StudioResource extends XotBaseResource
{
    // Altri metodi...
    
    /**
     * Schema statico per l'infolist nella risorsa.
     * Questo viene poi riutilizzato dalla pagina di visualizzazione.
     */
    public static function getInfolistSchema(): array
    {
        return [
            // Schema dell'infolist
        ];
    }
}
```

## Soluzione Pattern ViewRecord

Il pattern corretto da seguire è:

1. **Nella Risorsa**: Definire `getInfolistSchema()` come metodo statico
2. **Nella Pagina ViewRecord**: Implementare `getInfolistSchema()` come metodo d'istanza che reindirizza alla risorsa

Questo approccio:

- Evita la duplicazione del codice
- Mantiene la separazione delle responsabilità
- Segue il principio DRY (Don't Repeat Yourself)
- Rispetta i contratti di interfaccia

## Riferimenti

- [XotBaseViewRecord](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseViewRecord.php)
- [StudioResource](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Filament/Resources/StudioResource.php)
- [Modules\SaluteOra\docs\metodi-void-in-modelli.md](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/metodi-void-in-modelli.md)
- [Filament Documentation](https://filamentphp.com/docs/3.x/panels/resources/viewing-records)
