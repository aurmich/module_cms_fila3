# RegistrationWidget: Widget generico per la registrazione utente

## Scopo e filosofia

Il widget `RegistrationWidget` è progettato per essere **completamente generico e riutilizzabile** in qualsiasi progetto che utilizza il modulo User. Non contiene logica di dominio specifica (es. Doctor, Patient, ecc.), ma si limita a:
- raccogliere i dati dal form,
- determinare dinamicamente la risorsa, il modello e l'action da eseguire,
- delegare la logica di salvataggio e gestione dello stato a una Action specifica del modulo che implementa il tipo di utente.

## Pattern di delega

- Il widget riceve il tipo di utente (`$type`) e determina la resource, il modello e l'action tramite convenzioni di namespace.
- La proprietà `$action` viene costruita sostituendo `\Models\` con `\Actions\` e aggiungendo `\RegisterAction`.
- L'action viene invocata tramite `app($this->action)->execute($data)`.
- **Non va mai inserita logica di business o riferimenti a tipi di utente specifici nel widget.**

## Esempio di estensione nei moduli

Ogni modulo che implementa un tipo di utente deve fornire la propria Action di registrazione, ad esempio:
- `Modules\Patient\Actions\Doctor\RegisterAction`
- `Modules\Patient\Actions\Patient\RegisterAction`

Queste Action devono occuparsi di:
- Validare i dati ricevuti
- Creare il modello corretto (Doctor, Patient, ...)
- Impostare lo stato iniziale tramite Enum/Spatie Model States
- Gestire eventuali workflow o notifiche

## Best Practice
1. **Non inserire logica di business nel widget**: tutta la logica di salvataggio e gestione stato va delegata alle Action specifiche.
2. **Implementare una RegisterAction per ogni tipo di utente**: seguendo la convenzione dei namespace.
3. **Utilizzare Enum centralizzate per lo stato**: definite nel modulo corretto.
4. **Documentare i punti di estensione**: ogni progetto può aggiungere nuove Action per nuovi tipi di utente.
5. **Non citare mai tipi di utente o logiche di dominio nel modulo User**: mantenere la massima riusabilità.

## Collegamenti
- [RegistrationWidget.php](../../app/Filament/Widgets/RegistrationWidget.php)
- [Documentazione Xot sulla proprietà $data](../../../Xot/docs/filament/widgets/data-property.md)
- [Esempio di Action di registrazione Doctor](../../../../Patient/app/Actions/Doctor/RegisterAction.php)
- [Esempio di Action di registrazione Patient](../../../../Patient/app/Actions/Patient/RegisterAction.php)
- [Documentazione generale: Registrazione Odontoiatra](../../../../../docs/doctor-registration.md)

---

**Nota:**
Se vuoi estendere la logica di registrazione per un nuovo tipo di utente, crea una nuova Action seguendo la convenzione e aggiorna la documentazione del modulo specifico. La documentazione generale delle regole e delle convenzioni si trova nel modulo Xot e va sempre collegata da qui.

## Overview

Il widget `RegistrationWidget` è un componente Filament che gestisce la registrazione degli utenti nel sistema. È un esempio fondamentale di come i form Livewire interagiscono con la proprietà `$data` definita in `XotBaseWidget`.

## Struttura

```php
namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
// Altri import...

class RegistrationWidget extends XotBaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    protected static string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserTypeResourceClass($type);
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }
}
```

## Utilizzo della proprietà `$data`

Il `RegistrationWidget` utilizza implicitamente la proprietà `$data` ereditata da `XotBaseWidget` per gestire i dati del form. Questa proprietà è fondamentale perché:

1. I campi nel form Blade usano `wire:model="data.*"` per il binding dei dati
2. Quando il form viene inviato, i dati sono disponibili tramite `$this->data`
3. La proprietà è già dichiarata in `XotBaseWidget` come `public ?array $data = []`

## Template Blade

Nel file `registration.blade.php`, il form utilizza la direttiva `wire:submit.prevent="register"` per inviare i dati:

```blade
<form wire:submit.prevent="register" class="space-y-6">
    {{ $this->form }}
</form>
```

I campi generati dal form Filament saranno automaticamente collegati utilizzando `wire:model="data.*"`.

## Errori comuni

### 1. Errore di proprietà non esistente

```
Livewire: [wire:model="data.first_name"] property does not exist on component: [modules.user.filament.widgets.registration-widget]
```

Questo errore si verificherebbe se:
- La proprietà `$data` non fosse dichiarata in `XotBaseWidget`
- Ci fosse un tentativo di ridichiarare `$data` nel widget, causando conflitti

### 2. Accesso errato ai dati

```php
// ERRATO ❌
public function register()
{
    $firstName = $this->first_name; // La proprietà non esiste
}

// CORRETTO ✅
public function register()
{
    $firstName = $this->data['first_name'];
}
```

## Best Practices

1. **Non ridichiarare la proprietà `$data`** - È già fornita da `XotBaseWidget`
2. **Accedere ai campi tramite `$this->data['campo']`** - Non come proprietà dirette
3. **Validare i dati prima dell'uso** - Utilizzare i metodi di validazione di Livewire
4. **Utilizzare `$this->form->fill()`** nel metodo `mount()` per inizializzare il form
5. **Evitare binding diretti** come `wire:model="first_name"` che non usano la struttura `data.*`

## Collegamenti

- [Documentazione sulla proprietà `$data` in XotBaseWidget](../../../Xot/docs/filament/widgets/data-property.md)
- [Filament Forms Documentation](https://filamentphp.com/docs/3.x/forms/installation)
- [Livewire Data Binding](https://livewire.laravel.com/docs/properties)

## Gestione dinamica del salvataggio e delle azioni

Il `RegistrationWidget` è progettato per essere generico e riusabile in qualsiasi progetto che utilizza il modulo User. La logica di salvataggio e la gestione dello stato dell'utente non sono hardcodate, ma vengono risolte dinamicamente in base al tipo di utente (`$type`).

### Scelte progettuali
- Il widget determina dinamicamente la resource, il modello e l'action da eseguire tramite `$type` e la struttura delle classi.
- La proprietà `$action` viene costruita sostituendo `\Models\` con `\Actions\` e aggiungendo `\RegisterAction` al namespace del modello.
- Questo permette di delegare la logica di registrazione a una Action specifica per ogni tipo di utente (es. `Modules\Patient\Actions\Doctor\RegisterAction`, `Modules\Patient\Actions\Patient\RegisterAction`).
- Il widget non contiene logica di business specifica, ma si limita a raccogliere i dati e a invocare l'action corretta.

### Pattern consigliato
- Ogni modulo che definisce un tipo di utente deve implementare la propria Action di registrazione (es. `Doctor\RegisterAction`, `Patient\RegisterAction`).
- L'action deve occuparsi di validare, creare il modello, impostare lo stato iniziale e gestire eventuali notifiche o workflow.
- Il widget rimane generico e riusabile in qualsiasi contesto.

### Best Practice
1. **Non inserire logica di business nel widget**: tutta la logica di salvataggio e gestione stato va delegata alle Action specifiche.
2. **Implementare una RegisterAction per ogni tipo di utente**: seguendo la convenzione dei namespace.
3. **Utilizzare Enum centralizzate per lo stato**: definite nel modulo corretto.
4. **Documentare i punti di estensione**: ogni progetto può aggiungere nuove Action per nuovi tipi di utente.
5. **Non citare mai tipi di utente o logiche di dominio nel modulo User**: mantenere la massima riusabilità.

### Azioni da implementare (esempio per il modulo Patient)
- `Modules\Patient\Actions\Doctor\RegisterAction`
- `Modules\Patient\Actions\Patient\RegisterAction`

Queste Action devono occuparsi di:
- Validare i dati ricevuti
- Creare il modello corretto (Doctor, Patient, ...)
- Impostare lo stato iniziale tramite Enum
- Gestire eventuali workflow o notifiche

### Collegamenti
- [RegistrationWidget.php](../../app/Filament/Widgets/RegistrationWidget.php)
- [Documentazione Xot sulla proprietà $data](../../../Xot/docs/filament/widgets/data-property.md)
- [Esempio di Action di registrazione (da creare)](../../../../Patient/app/Actions/Doctor/RegisterAction.php)
