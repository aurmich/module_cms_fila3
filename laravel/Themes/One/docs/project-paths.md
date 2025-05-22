# Struttura dei Percorsi nel Progetto il progetto

## Panoramica
Questo documento descrive la struttura corretta dei percorsi nel progetto il progetto, con particolare attenzione alla posizione dei temi e alle convenzioni di naming. Seguire queste linee guida è fondamentale per garantire la coerenza e il corretto funzionamento dell'applicazione.

## Struttura di Base

```
/var/www/html/base_saluteora/         # Root del progetto
├── bashscripts/                      # Script bash di utility
├── docs/                             # Documentazione generale del progetto
└── laravel/                          # Applicazione Laravel
    ├── app/                          # Codice Laravel principale
    ├── bootstrap/                    # File di bootstrap Laravel
    ├── config/                       # Configurazioni Laravel
    ├── database/                     # Migrazioni, seeder, factories
    ├── Modules/                      # Moduli dell'applicazione
    │   ├── Chart/                    # Modulo Chart
    │   ├── Cms/                      # Modulo Cms
    │   ├── ...                       # Altri moduli
    │   └── Xot/                      # Modulo base Xot
    ├── public/                       # File pubblici
    ├── resources/                    # Risorse (non specifiche dei temi)
    ├── routes/                       # Definizioni delle rotte
    ├── storage/                      # Storage Laravel
    ├── tests/                        # Test
    └── Themes/                       # Temi dell'applicazione
        ├── One/                      # Tema principale
        └── Two/                      # Tema secondario
```

## ⚠️ Importante: Posizione dei Temi

I temi si trovano nella directory `laravel/Themes/` e **NON** direttamente nella root del progetto. Questo è un aspetto fondamentale della struttura del progetto il progetto.

### Percorsi Corretti vs. Percorsi Errati

✅ **Percorso Corretto**:
```
/var/www/html/base_saluteora/laravel/Themes/One/resources/views/pages/auth/register.blade.php
```

❌ **Percorso Errato**:
```
/var/www/html/base_saluteora/Themes/One/resources/views/pages/auth/register.blade.php
```

## Struttura Interna dei Temi

Ogni tema segue una struttura standard:

```
Themes/One/
├── app/                      # Codice PHP specifico del tema
│   ├── Http/                 # Controller e middleware
│   └── Providers/            # Service provider del tema
├── config/                   # Configurazioni del tema
├── docs/                     # Documentazione del tema
├── public/                   # Asset pubblici
├── resources/                # Risorse del tema
│   ├── css/                  # File CSS
│   ├── js/                   # File JavaScript
│   └── views/                # Viste Blade
│       ├── components/       # Componenti Blade
│       ├── layouts/          # Layout Blade
│       └── pages/            # Pagine Folio
│           ├── auth/         # Pagine di autenticazione
│           ├── dashboard/    # Pagine dashboard
│           └── ...           # Altre pagine
└── routes/                   # Rotte specifiche del tema
```

## Convenzioni di Naming

1. **Case Sensitivity**: Rispettare rigorosamente la case sensitivity nelle directory
   - `resources/` è CORRETTO, `Resources/` è ERRATO
   - `views/` è CORRETTO, `Views/` è ERRATO

2. **Percorsi Assoluti**: Quando si fa riferimento a file in modo assoluto, includere sempre il segmento `laravel/` quando applicabile

## Errori Comuni e Come Evitarli

### 1. Omissione del segmento `laravel/`

**Problema**: Omettere il segmento `laravel/` nel percorso porta a riferirsi a file inesistenti.

**Soluzione**: Verificare sempre che i percorsi assoluti inizino con `/var/www/html/base_saluteora/laravel/` quando ci si riferisce a file all'interno dell'applicazione Laravel.

### 2. Confusione tra Moduli e Temi

**Problema**: Confondere la posizione dei moduli e dei temi.

**Soluzione**: Ricordare che:
- I moduli si trovano in `/var/www/html/base_saluteora/laravel/Modules/`
- I temi si trovano in `/var/www/html/base_saluteora/laravel/Themes/`

## Collegamenti Bidirezionali

- [README del Tema](./README.md) - Panoramica del tema One
- [Struttura del Progetto](../../Modules/Xot/docs/architecture/struttura-progetto.md) - Documentazione generale sulla struttura del progetto
- [Convenzioni di Naming](../../Modules/Xot/docs/namespace-conventions.md) - Convenzioni di naming nel progetto
- [File Naming Conventions](../../../../docs/standards/file_naming_conventions.md) - Standard per la nomenclatura dei file
