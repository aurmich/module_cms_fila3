# Struttura Directory Filament nei Moduli

## Struttura Corretta
```
laravel/Modules/Patient/
└── app/
    └── Filament/
        └── Resources/
            ├── DoctorResource.php
            └── DoctorResource/
                └── Pages/
                    ├── CreateDoctor.php
                    ├── EditDoctor.php
                    └── ListDoctors.php
```

## ❌ Struttura Errata (DA NON USARE)
```
laravel/Modules/Patient/
└── Filament/
    └── Resources/
        ├── DoctorResource.php
        └── DoctorResource/
            └── Pages/
```

## Spiegazione Dettagliata

### 1. Perché usare `app/Filament`?
- Mantiene coerenza con la struttura Laravel standard
- Segue le convenzioni dei moduli Laravel
- Facilita l'autoloading delle classi
- Rispetta la struttura PSR-4

### 2. Namespace
```php
// ✅ Namespace Corretto (anche se il file è in app/Filament)
namespace Modules\Patient\Filament\Resources;

// ❌ Namespace Errato
namespace Modules\Patient\App\Filament\Resources;
```

### 3. Percorsi File vs Namespace
- **Percorso File**: Deve essere in `app/Filament/Resources/`
- **Namespace**: Deve essere `Modules\Patient\Filament\Resources`
- Questa distinzione è fondamentale per il corretto funzionamento

### 4. Composer.json del Modulo
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\SaluteOra\\": "",
            "Modules\\SaluteOra\\Filament\\": "app/Filament/"
        }
    }
}
```

### 5. Regole da Seguire
1. Posizionare sempre i file Filament in `app/Filament/`
2. Mantenere il namespace `Modules\Patient\Filament\`
3. Non usare mai il namespace `App\` nei moduli
4. Non posizionare i file direttamente in `Filament/`

## Impatto dell'Errore
- Problemi di autoloading
- Conflitti di namespace
- Malfunzionamento dei Resources
- Difficoltà nella manutenzione

## Best Practices
1. Seguire sempre la struttura `app/Filament/`
2. Mantenere i namespace corretti
3. Verificare il composer.json del modulo
4. Testare l'autoloading

## Collegamenti Bidirezionali
- [README](README.md)
- [Filament Resources](filament-resources.md)
- [Convenzioni Namespace](conventions.md)

## Vedi Anche
- [Struttura Moduli](../../Xot/docs/module-structure.md)
- [Documentazione Filament](../../docs/filament/README.md)
- [PSR-4 Autoloading](../../docs/standards/psr4.md) 
