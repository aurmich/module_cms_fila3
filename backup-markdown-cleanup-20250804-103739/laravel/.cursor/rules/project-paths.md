# Regole fondamentali per i percorsi nel progetto SaluteOra

## ⚠️ REGOLA ASSOLUTA PER I PERCORSI

Tutti i percorsi assoluti nel progetto SaluteOra **DEVONO** includere il segmento `laravel/` dopo `base_saluteora/`.

### Percorsi corretti
✅ `/var/www/html/base_saluteora/laravel/app/...`
✅ `/var/www/html/base_saluteora/laravel/Modules/...`
✅ `/var/www/html/base_saluteora/laravel/Themes/...`
✅ `/var/www/html/base_saluteora/laravel/resources/...`

### Percorsi errati
❌ `/var/www/html/base_saluteora/app/...` (manca `laravel/`)
❌ `/var/www/html/base_saluteora/Modules/...` (manca `laravel/`)
❌ `/var/www/html/base_saluteora/Themes/...` (manca `laravel/`)
❌ `/var/www/html/base_saluteora/resources/...` (manca `laravel/`)

## Struttura corretta del progetto

```
/var/www/html/base_saluteora/            # Root del progetto
├── laravel/                             # Applicazione Laravel
│   ├── app/                             # Core dell'applicazione
│   ├── Modules/                         # Moduli del progetto
│   │   ├── Patient/                     # Modulo Patient
│   │   ├── User/                        # Modulo User
│   │   └── ...                          # Altri moduli
│   ├── Themes/                          # Temi dell'applicazione
│   │   └── One/                         # Tema principale
│   └── ...                              # Altri file e directory
└── ...                                  # Altri file nella root
```

## Comandi di verifica

Prima di inviare codice, verificare sempre i percorsi con:

```bash
# Verifica che non ci siano reference a percorsi errati (senza laravel/)
grep -r "/var/www/html/base_saluteora/app" --include="*.php" .
grep -r "/var/www/html/base_saluteora/Modules" --include="*.php" .
grep -r "/var/www/html/base_saluteora/Themes" --include="*.php" .
```

## Motivazione

Questa struttura garantisce:
1. Separazione chiara tra l'applicazione Laravel e altri componenti
2. Evita conflitti di path nelle operazioni di deploy
3. Migliora la manutenibilità e la chiarezza del codice
4. Consente futuri aggiornamenti mantenendo la compatibilità
