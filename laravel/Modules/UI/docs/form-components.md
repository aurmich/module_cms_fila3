# Componenti Form

## Introduzione
I componenti form forniscono elementi di input e validazione per la creazione di form complessi e interattivi.

## Componenti Disponibili

### Input
```blade
<x-ui::input 
    name="email" 
    type="email" 
    label="Email" 
    placeholder="Inserisci la tua email"
    :required="true"
    :disabled="false"
    :readonly="false"
    :autofocus="false"
    :autocomplete="true"
    :error="$errors->first('email')"
/>
```

### Select
```blade
<x-ui::select 
    name="role" 
    label="Ruolo"
    :options="[
        'admin' => 'Amministratore',
        'user' => 'Utente',
        'guest' => 'Ospite'
    ]"
    :required="true"
    :multiple="false"
    :searchable="true"
    :clearable="true"
    :error="$errors->first('role')"
/>
```

### Checkbox
```blade
<x-ui::checkbox 
    name="terms" 
    label="Accetto i termini e condizioni"
    :required="true"
    :checked="false"
    :disabled="false"
    :error="$errors->first('terms')"
/>
```

### Radio
```blade
<x-ui::radio 
    name="gender" 
    label="Genere"
    :options="[
        'male' => 'Maschio',
        'female' => 'Femmina',
        'other' => 'Altro'
    ]"
    :required="true"
    :error="$errors->first('gender')"
/>
```

### Textarea
```blade
<x-ui::textarea 
    name="message" 
    label="Messaggio"
    placeholder="Inserisci il tuo messaggio"
    :rows="4"
    :required="true"
    :disabled="false"
    :readonly="false"
    :error="$errors->first('message')"
/>
```

## Validazione

### Regole
- Required
- Min/Max length
- Pattern
- Custom rules

### Messaggi
- Personalizzazione messaggi errore
- Localizzazione
- Tooltip di aiuto

## Integrazione

### Livewire
```php
use Livewire\Component;

class UserForm extends Component
{
    public $name;
    public $email;
    
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
    ];
    
    public function save()
    {
        $this->validate();
        // Salva i dati
    }
}
```

### JavaScript
```javascript
// Validazione lato client
const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
    if (!form.checkValidity()) {
        e.preventDefault();
        // Mostra errori
    }
});
```

## Best Practices

### Utilizzo
- Validazione lato server e client
- Feedback immediato
- Accessibilità
- UX ottimizzata

### Performance
- Lazy loading
- Debounce input
- Cache validazione
- Ottimizzazione risorse

## Collegamenti
- [Componenti Base](./base-components.md)
- [Componenti Table](./table-components.md)
- [Componenti Chart](./chart-components.md)
- [Componenti Layout](./layout-components.md)
- [Documentazione Frontend](../Cms/docs/frontend-architecture.md) 
## Collegamenti tra versioni di form-components.md
* [form-components.md](../../../UI/docs/form-components.md)
* [form-components.md](../../../UI/docs/roadmap/form-components.md)

