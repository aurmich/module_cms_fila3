# Spatie Laravel Translatable

Questa documentazione descrive l'implementazione e l'utilizzo del pacchetto `spatie/laravel-translatable` nel progetto, un potente strumento per la gestione di contenuti multilingua nei modelli Eloquent.

## Indice

1. [Gestione delle traduzioni mancanti](./gestione-traduzioni-mancanti.md)
2. [Implementazione nel progetto](./implementazione-nel-progetto.md)
3. [API e utilizzo comune](#api-e-utilizzo-comune)
4. [Best Practices](#best-practices)

## Introduzione

Il pacchetto `spatie/laravel-translatable` consente di salvare traduzioni di attributi dei modelli Eloquent. Le traduzioni vengono archiviate come file JSON, rendendo semplice l'aggiunta o la rimozione di lingue.

## Installazione e Configurazione

Il pacchetto è già installato nel progetto. La configurazione principale si trova in:

- `Modules/Lang/app/Providers/TranslatableServiceProvider.php`

## API e utilizzo comune

### Dichiarazione di campi traducibili

```php
use Spatie\Translatable\HasTranslations;

class MailTemplate extends Model
{
    use HasTranslations;
    
    public $translatable = ['subject', 'html_template', 'text_template'];
}
```

### Accesso alle traduzioni

```php
// Imposta traduzioni
$model->setTranslation('field_name', 'it', 'Valore in italiano');
$model->setTranslation('field_name', 'en', 'English value');
$model->save();

// Imposta tutte le traduzioni contemporaneamente
$model->setTranslations('field_name', [
    'it' => 'Valore in italiano',
    'en' => 'English value',
]);

// Ottieni traduzione specifica
$model->getTranslation('field_name', 'it'); // 'Valore in italiano'

// Ottieni tutte le traduzioni
$model->getTranslations('field_name'); // ['it' => 'Valore in italiano', 'en' => 'English value']

// Ottieni traduzione nella lingua corrente
$model->field_name; // Restituisce nella lingua di app()->getLocale()
```

### Rimozione di traduzioni

```php
$model->forgetTranslation('field_name', 'en');
```

## Best Practices

1. **Traduzione di tutti i campi necessari**:
   - Assicurarsi di tradurre tutti i campi dichiarati in `$translatable` per tutte le lingue supportate

2. **Validazione delle traduzioni**:
   - Implementare regole di validazione specifiche per ciascuna lingua

3. **Gestione fallback coerente**:
   - Definire una strategia di fallback chiara e coerente in tutta l'applicazione

4. **Performance**:
   - Le traduzioni sono archiviate come JSON, quindi evitare campi troppo grandi o numerosi

5. **Integrazione con l'UI**:
   - Utilizzare componenti UI che supportano la modifica di contenuti multilingua

## Risorse

- [Documentazione ufficiale](https://spatie.be/docs/laravel-translatable)
- [Repository GitHub](https://github.com/spatie/laravel-translatable)
- [Issues e discussioni](https://github.com/spatie/laravel-translatable/issues)
