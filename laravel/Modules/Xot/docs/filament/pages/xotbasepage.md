# XotBasePage - Classe Base per le Pagine Filament

## Descrizione

La classe `XotBasePage` rappresenta un componente fondamentale nell'architettura di SaluteOra, fungendo da intermediario tra le pagine Filament e le implementazioni specifiche dell'applicazione. Questa classe astratta segue il pattern architetturale di non estendere mai direttamente le classi di Filament, ma utilizzare sempre classi wrapper con prefisso `XotBase`.

## Percorso del File

```
/var/www/html/base_saluteora/laravel/Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php
```

## Gerarchia di Ereditarietà

```
Filament\Pages\Page
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBasePage
        ↑
        └── Modulo specifico\Filament\Pages\YourCustomPage
```

## Trait e Interfacce

- Implementa `HasForms` per la gestione dei moduli
- Utilizza `InteractsWithForms` per l'interazione con i form
- Utilizza `NavigationLabelTrait` per la gestione delle etichette di navigazione
- Utilizza `TransTrait` per le funzionalità di traduzione

## Funzionalità Principali

### Gestione Automatica delle Traduzioni

```php
public static function getNavigationLabel(): string
{
    return static::transFunc(__FUNCTION__);
}

public function getTitle(): string 
{
    return static::transTitle();
}
```

### Form Standardizzato

```php
public function form(Form $form): Form
{
    return $form
        ->schema($this->getFormSchema())
        ->statePath('data');
}
```

### Proprietà Principali

| Proprietà | Tipo | Descrizione |
|-----------|------|-------------|
| `$model` | `?string` | Classe del modello associato alla pagina |
| `$data` | `?array` | Dati del form |
| `$navigationIcon` | `?string` | Icona di navigazione predefinita |

## Utilizzo Corretto

### Estensione Corretta

```php
namespace Modules\SaluteOra\Filament\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class MyCustomPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-document';
    
    protected function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

### Estensione Errata da Evitare

```php
// ❌ ERRORE: Non estendere mai direttamente Page
namespace Modules\SaluteOra\Filament\Pages;

use Filament\Pages\Page;

class MyCustomPage extends Page // ⚠️ ERRATO!
{
    // ...
}
```

## Vantaggi dell'Utilizzo

1. **Uniformità del Codice**: Comportamento coerente in tutti i moduli
2. **Traduzione Automatica**: Gestione centralizzata delle traduzioni
3. **Gestione Form Semplificata**: Pattern standardizzato per i form
4. **Separazione delle Responsabilità**: Layer di astrazione tra l'applicazione e il framework

## Best Practices

1. **Non Ridichiarare Interfacce**: Non ridichiarare `HasForms` o altri trait già presenti in XotBasePage
2. **Implementare getFormSchema()**: Sempre fornire un'implementazione di questo metodo
3. **Rispettare il Namespace**: Utilizzare `Modules\<nome modulo>\Filament\Pages` per le classi che estendono XotBasePage
4. **Utilizzare le Traduzioni**: Sfruttare il sistema di traduzione automatico invece di hardcodare le etichette

## Compatibilità con Filament

La classe è progettata per essere compatibile con Filament v3+ e garantisce il corretto funzionamento di tutte le funzionalità native di Filament\Pages\Page.

## Collegamenti

- [Documentazione di Filament](https://filamentphp.com/docs/3.x/panels/pages)
- [Pattern di Estensione](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/filament_best_practices.md)
- [Principi di Ereditarietà](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/class_inheritance_principles.md)
- [Architettura Filament-Xot](/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament_xot_architecture.md)
