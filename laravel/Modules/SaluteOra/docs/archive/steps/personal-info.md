# Step Informazioni Personali

## Descrizione
Questo è il primo step del form di registrazione medico, come documentato in `/docs/images/13.md`. Lo step raccoglie le informazioni personali di base del medico.

## Struttura Originale (da /docs/images/13.md)

```html
<form class="space-y-6">
    <!-- Name Input -->
    <div>
        <input 
            type="text" 
            placeholder="Nome e Cognome" 
            class="w-full px-6 py-4 rounded-full bg-white shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>
    
    <!-- Upload Certificate Button -->
    <div>
        <button 
            type="button" 
            class="w-full px-6 py-4 rounded-full bg-gray-300 text-[#003b71] font-medium text-lg shadow-md hover:bg-gray-200 transition-colors"
        >
            Carica certificazione iscrizione Ordine
        </button>
    </div>
</form>
```

## Implementazione Corretta in Filament

```php
protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('personal_info')
        ->schema([
            'personal_section' => Forms\Components\Section::make()
                ->schema([
                    'full_name' => Forms\Components\TextInput::make('full_name')
                        ->label('Nome e Cognome')
                        ->placeholder('Inserisci nome e cognome')
                        ->required()
                        ->maxLength(255)
                        ->autocomplete('name'),

                    'certification' => Forms\Components\FileUpload::make('certification')
                        ->label('Certificazione iscrizione Ordine')
                        ->helperText('Carica la certificazione di iscrizione all\'Ordine (PDF)')
                        ->required()
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->directory('certifications')
                ]),
        ]);
}
```

## Differenze e Motivazioni

1. **Nome del Campo**:
   - Originale: Input generico per "Nome e Cognome"
   - Implementazione: Campo `full_name` specifico
   - Motivazione: Segue le convenzioni di naming standard per campi che contengono nome completo

2. **Caricamento Certificato**:
   - Originale: Pulsante semplice
   - Implementazione: Componente `FileUpload` con validazioni
   - Motivazione: Gestione completa del caricamento file con validazioni e feedback

3. **Validazioni**:
   - Originale: Nessuna validazione esplicita
   - Implementazione: Validazioni per lunghezza, tipo file e dimensione
   - Motivazione: Garantire la qualità e sicurezza dei dati

## Note Importanti

1. Usare `full_name` quando il campo contiene sia nome che cognome
2. Non usare mai metodi non supportati come `buttonLabel()` o `icon()` per FileUpload
3. Seguire sempre la documentazione ufficiale di Filament per i metodi supportati
4. Utilizzare il sistema di traduzione per tutti i testi

## Collegamenti Correlati

- [Documentazione Immagine 13](/docs/images/13.md)
- [Convenzioni di Naming](../../../Modules/UI/docs/convenzioni-naming-campi.md)
- [Filament Form Components](../../../Modules/UI/docs/filament-components)
- [Best Practices Forms](../../../Modules/UI/docs/forms/best-practices.md) 