# ApplyMetatagToPanelAction

## Descrizione
L'azione `ApplyMetatagToPanelAction` è responsabile di applicare i metatag al panel Filament, configurando l'aspetto visivo dell'interfaccia amministrativa.

## Funzionalità
- Applica i colori del tema al panel
- Configura il logo del brand utilizzando i metodi semantici
- Imposta il nome del brand
- Configura il logo per la modalità scura
- Imposta l'altezza del logo
- Configura il favicon

## Utilizzo
```php
use Modules\Xot\Actions\Panel\ApplyMetatagToPanelAction;

$panel = new Panel();
$action = new ApplyMetatagToPanelAction();
$panel = $action->execute($panel);
```

## Metodi

### execute(Panel $panel): Panel
Applica i metatag al panel Filament.

#### Parametri
- `$panel`: Il panel Filament da configurare

#### Return
- `Panel`: Il panel configurato con i metatag

## Esempio di Configurazione
```php
$panel
    ->brandName($metatag->getBrandName())           // Metodo semantico per il nome del brand
    ->brandLogo($metatag->getBrandLogo())           // Metodo semantico per il logo
    ->darkModeBrandLogo($metatag->getDarkModeBrandLogo()) // Metodo semantico per il logo dark
    ->brandLogoHeight($metatag->getBrandLogoHeight()) // Metodo semantico per l'altezza
    ->favicon($metatag->getFavicon());              // Metodo già semantico
```

## Gestione Errori
In caso di errore durante l'applicazione dei metatag:
- L'errore viene registrato nel log
- Il panel originale viene restituito senza modifiche
- L'applicazione continua a funzionare

## Best Practices

1. **Utilizzo dei Metodi**:
   - Utilizzare sempre i metodi semantici (getBrand*)
   - Evitare l'accesso diretto alle proprietà
   - Verificare sempre la presenza dei loghi dark

2. **Configurazione**:
   - Mantenere coerenza tra logo chiaro e scuro
   - Verificare le dimensioni del logo
   - Testare il contrasto dei colori

3. **Manutenzione**:
   - Aggiornare regolarmente i metatag
   - Verificare la validità dei percorsi
   - Mantenere backup delle configurazioni

## Collegamenti
- [MetatagData](../datas/MetatagData.md)
- [Filament Panel Documentation](https://filamentphp.com/docs/panels)
- [Logo Resolution](../logo_resolution.md)
- [Color Management](../colors.md)
- [Semantic Methods](../philosophy/semantic_methods.md)

## Note
- Questa azione utilizza il trait `QueueableAction` di Spatie
- Tutti i metodi sono fortemente tipizzati per PHPStan livello 10
- La documentazione è mantenuta aggiornata nella cartella docs

## Collegamenti tra versioni di ApplyMetatagToPanelAction.md
* [ApplyMetatagToPanelAction.md](../../../Xot/docs/actions/ApplyMetatagToPanelAction.md)
* [ApplyMetatagToPanelAction.md](../../../Xot/docs/actions/panel/ApplyMetatagToPanelAction.md)


## Collegamenti tra versioni di applymetatagtopanelaction.md
* [applymetatagtopanelaction.md](panel/applymetatagtopanelaction.md)

