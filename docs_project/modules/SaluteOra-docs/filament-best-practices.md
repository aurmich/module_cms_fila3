# Filament Best Practices (Moduli Riutilizzabili)

## Descrizione
Best practice generiche per l'utilizzo di Filament in moduli Laravel riutilizzabili. Nessun riferimento a nomi di progetto o brand.

## Regole principali
- NON estendere mai direttamente le classi di Filament: creare sempre wrapper personalizzati
- Utilizzare traits per funzionalità riutilizzabili
- Seguire il pattern di composizione invece dell'ereditarietà
- Mantenere la compatibilità con gli aggiornamenti di Filament
- Centralizzare le configurazioni comuni nelle classi base
- Non inserire proprietà statiche custom nei resource (es. $navigationIcon, $navigationGroup, $translationPrefix)
- Non usare ->label() direttamente nei form: usare sempre i file di traduzione

## Esempi
```php
// ❌ Anti-pattern
class MyResource extends \Filament\Resources\Resource {}

// ✅ Best practice
class MyResource extends \Modules\Xot\Filament\Resources\XotBaseResource {}
```

## Troubleshooting
- Se compare un errore di override di proprietà statiche, rimuovere la proprietà dal resource e centralizzare nella base
- Se le traduzioni non vengono applicate, controllare la struttura dei file lang e l'assenza di ->label() hardcoded

## Collegamenti
- [Filament Docs](https://filamentphp.com/docs)
- [Best practices moduli riutilizzabili](../module-documentation-neutrality.md)
- [Ereditarietà modelli](../model-inheritance-best-practices.md) 
