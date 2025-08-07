# Convenzioni dei Namespace in SaluteOra

## Struttura Base

In SaluteOra, seguiamo una struttura di namespace coerente e standardizzata. La struttura base è:

```
Modules\{Modulo}\{Categoria}\{Sottocategoria}
```

## Regole Principali

1. **NON utilizzare mai `App` nel namespace**
   - ❌ `Modules\SaluteOra\App\Actions`
   - ✅ `Modules\SaluteOra\Actions`

2. **Struttura delle Cartelle**
   - La cartella `app` è solo per il contenuto fisico dei file
   - Il namespace NON deve riflettere la presenza della cartella `app`

## Esempi Corretti

```php
// Actions
namespace Modules\SaluteOra\Actions\Patient\Calendar;

// Models
namespace Modules\SaluteOra\Models;

// Enums
namespace Modules\SaluteOra\Enums;

// Services
namespace Modules\SaluteOra\Services;
```

## Struttura delle Cartelle vs Namespace

```
Modules/SaluteOra/
├── app/                    # Contenuto fisico dei file
│   ├── Actions/           # Namespace: Modules\SaluteOra\Actions
│   ├── Models/            # Namespace: Modules\SaluteOra\Models
│   └── Services/          # Namespace: Modules\SaluteOra\Services
└── ...
```

## Checklist per i Namespace

- [ ] Il namespace inizia con `Modules\{Modulo}`
- [ ] NON include `App` nel namespace
- [ ] Riflette la struttura logica, non quella fisica delle cartelle
- [ ] Usa PascalCase per i segmenti del namespace
- [ ] È coerente con il resto del modulo

## Errori Comuni

1. **Errore**: Includere `App` nel namespace
   ```php
   // ERRATO
   namespace Modules\SaluteOra\App\Actions;
   
   // CORRETTO
   namespace Modules\SaluteOra\Actions;
   ```

2. **Errore**: Riflettere la struttura fisica delle cartelle
   ```php
   // ERRATO
   namespace Modules\SaluteOra\App\Models;
   
   // CORRETTO
   namespace Modules\SaluteOra\Models;
   ```

## Best Practices

1. **Coerenza**: Mantenere la stessa struttura di namespace in tutti i moduli
2. **Semplicità**: Evitare namespace troppo profondi
3. **Chiarezza**: Usare nomi descrittivi per i segmenti del namespace
4. **Documentazione**: Documentare eventuali eccezioni alla regola

## Riferimenti

- [Laravel Module Documentation](https://nwidart.com/laravel-modules/v6/introduction)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/) 
