# Implementazione delle Risorse Filament nel Modulo Patient

## Panoramica

Questo documento descrive come implementare correttamente le risorse Filament nel modulo Patient, seguendo le best practice e le regole del progetto.

## Regole Fondamentali

Tutte le risorse Filament nel modulo Patient **DEVONO** seguire queste regole:

1. **Estendere XotBaseResource**: Utilizzare sempre `Modules\Xot\Filament\Resources\XotBaseResource` come classe base.
2. **Evitare Proprietà di Navigazione**: Non dichiarare proprietà come `$navigationIcon`, `$navigationGroup`, `$navigationSort` o `$translationPrefix`.
3. **Utilizzare il Sistema di Traduzione**: Non utilizzare il metodo `->label()` nei componenti Filament.
4. **Namespace di Traduzione Diretto**: Utilizzare direttamente `__('patient::resource-name.field_name')` invece di variabili come `$prefix`.

## Esempio: DoctorResource

### ❌ Problemi Identificati in DoctorResource

Nel file `DoctorResource.php` sono stati identificati i seguenti problemi:

1. **Uso di `$translationPrefix`**:
   ```php
   // Problema: Uso di una variabile $translationPrefix
   $prefix = static::$translationPrefix;
   ```

2. **Riferimenti a `$prefix` nelle traduzioni**:
   ```php
   // Problema: Uso di $prefix nelle traduzioni
   __("{$prefix}.field_name")
   ```

### ✅ Implementazione Corretta

Ecco come dovrebbe essere implementato correttamente:

```php
// Rimuovere la dichiarazione di $translationPrefix
// Rimuovere l'assegnazione di $prefix

// Utilizzare direttamente il namespace di traduzione
__('patient::doctor-resource.field_name')
```

## Struttura dei Form

Per i form complessi come quello di `DoctorResource`, è consigliabile organizzare il codice in metodi separati per ogni step del wizard:

```php
protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
{
    // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione
    
    return Forms\Components\Wizard\Step::make('personal_info')
        ->icon('heroicon-o-user')
        ->schema([
            'personal_section' => Forms\Components\Section::make()
                ->schema([
                    'first_name' => Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255)
                        ->autocomplete('given-name')
                        ->placeholder(__('patient::doctor-resource.first_name')),
                        
                    'last_name' => Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255)
                        ->autocomplete('family-name')
                        ->placeholder(__('patient::doctor-resource.last_name')),
                        
                    'email' => Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->autocomplete('email')
                        ->placeholder(__('patient::doctor-resource.email')),
                        
                    // Altri campi...
                ]),
        ]);
}
```

## Traduzioni

Le traduzioni per le risorse Filament nel modulo Patient devono essere definite nei file di traduzione appropriati:

```php
// /laravel/Modules/Patient/lang/it/doctor-resource.php
return [
    'first_name' => 'Nome',
    'last_name' => 'Cognome',
    'email' => 'Email',
    // Altri campi...
];
```

## Verifica dell'Implementazione

Prima di considerare completa l'implementazione di una risorsa Filament, verificare:

1. **Nessuna Proprietà di Navigazione**: Assicurarsi che non ci siano proprietà come `$navigationIcon`.
2. **Nessun Uso di `$translationPrefix`**: Rimuovere tutte le occorrenze di questa variabile.
3. **Nessun Uso di `->label()`**: Assicurarsi che non ci siano chiamate al metodo `label()`.
4. **Namespace di Traduzione Diretto**: Utilizzare sempre `__('patient::resource-name.field_name')`.

## Errori Comuni nel Modulo Patient

1. **Dichiarazione di Proprietà di Navigazione**: Errore comune nelle risorse del modulo Patient.
2. **Uso di `$translationPrefix`**: Presente in molte risorse esistenti, deve essere rimosso.
3. **Metodi di Tabella Ridondanti**: Dichiarazione non necessaria di metodi come `getListTableColumns()`.
4. **Uso di `->label()`**: Specialmente negli enum e nei componenti select.

## Documentazione Correlata

- [Regole Generali per le Risorse Filament](/docs/filament-resources-guidelines.md)
- [Regole Dettagliate nel Modulo Xot](/laravel/Modules/Xot/docs/FILAMENT_RESOURCE_RULES.md)
- [Gestione delle Traduzioni nel Modulo Patient](/laravel/Modules/Patient/docs/TRANSLATIONS.md)
- [Implementazione del DoctorResource](/laravel/Modules/Patient/docs/DOCTOR_REGISTRATION_PROCESS.md)
- [FILAMENT_BEST_PRACTICES.md](./FILAMENT_BEST_PRACTICES.md)
- [XOTBASE_RESOURCE_GUIDELINES.md](./XOTBASE_RESOURCE_GUIDELINES.md)
- [USER_MODERATION_MODEL.md](./USER_MODERATION_MODEL.md)
- [USER_MODERATION_MODEL_ANALYSIS.md](./USER_MODERATION_MODEL_ANALYSIS.md)
