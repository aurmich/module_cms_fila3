# Code Quality Standards - UI Module

## Regola Fondamentale: MAI Commenti Ovvi

**I commenti ovvi vanno arrotolati e ficcati nel culo. MAI scrivere commenti che ripetono quello che il codice già dice chiaramente.**

### ❌ ERRATO - Commenti Ovvi
```php
// Incrementa il contatore
$counter++;

// Salva l'utente nel database
$user->save();

/**
 * Classe per gestire gli utenti
 * Estende il modello base
 * Implementa le funzionalità CRUD
 */
class UserController extends Controller
{
    // Metodo per creare un nuovo utente
    public function create() {
        // Crea un nuovo utente
        $user = new User();
        // Salva l'utente
        $user->save();
    }
}
```

### ✅ CORRETTO - Solo Commenti Utili
```php
$counter++;

$user->save();

/**
 * @property ComponentContainer $emailForm
 */
class S3Test extends XotBasePage
{
    public function sendEmail(): void
    {
        // Validazione e invio email con gestione errori
        $data = $this->form->getState();
        $email_data = EmailData::from($data);
        
        Mail::to($data['to'])->send(new EmailDataEmail($email_data));
    }
}
```

## Cosa NON Commentare

1. **Nomi di variabili/methodi autoesplicativi**
2. **Logica semplice e chiara**
3. **Cicli e controlli standard**
4. **Proprietà e attributi ovvi**
5. **Implementazioni standard di framework**

## Cosa Commentare (Solo se Utile)

1. **Logica di business complessa**
2. **Algoritmi non standard**
3. **Workaround temporanei**
4. **Decisioni architetturali importanti**
5. **PHPDoc per proprietà e metodi pubblici**
6. **Motivazioni per scelte non ovvie**

## Regola di Vita
**Se il commento dice esattamente quello che il codice fa, è inutile. Il codice deve parlare da solo.**

## Regola Fondamentale: MAI ->label(), ->placeholder(), ->helperText()

**MAI usare `->label()`, `->placeholder()` e `->helperText()` nei form components Filament. Le traduzioni sono gestite automaticamente dal LangServiceProvider.**

### ❌ ERRATO - MAI Fare Questo
```php
Forms\Components\TextInput::make('email')
    ->label('Email')
    ->placeholder('Inserisci la tua email')
    ->helperText('Email per contatti')
```

### ✅ CORRETTO - Solo Chiavi Campo
```php
Forms\Components\TextInput::make('email')
    ->email()
    ->required(),
```

**Se vedi `->label()`, `->placeholder()` o `->helperText()` in un form component, è ERRORE GRAVE. Le traduzioni vanno nei file di lingua, non nel codice.**

## Collegamenti

- [Filament Pages Refactoring](./filament_pages_refactoring.md)
- [No Obvious Comments Rule](../../../.cursor/rules/no-obvious-comments.mdc)

*Ultimo aggiornamento: giugno 2025* 