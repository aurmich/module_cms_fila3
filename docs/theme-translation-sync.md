# Sincronizzazione Traduzioni Temi

## Panoramica

Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto SaluteOra.

## Struttura dei Temi

### Tema One
- **Percorso**: `/laravel/Themes/One/lang/`
- **Lingue supportate**: `it/`, `en/`, `de/`
- **File di traduzione**: 9 file per lingua (aggiornato)

### Tema Two
- **Percorso**: `/laravel/Themes/Two/lang/`
- **Lingue supportate**: `it/`, `en/`, `de/`
- **File di traduzione**: 9 file per lingua (aggiornato)

## File di Traduzione

Entrambi i temi contengono i seguenti file di traduzione:

1. `auth.php` - Autenticazione e registrazione
2. `password-reset.php` - Reset password
3. `appointment.php` - Gestione appuntamenti
4. `patient_states.php` - Stati del paziente
5. `doctor_states.php` - Stati del dottore
6. `txt.php` - Testi generici
7. `wizard.php` - Componenti wizard
8. `theme.php` - Traduzioni specifiche del tema
9. `widgets.php` - Traduzioni per i widget Filament (NUOVO)

## Traduzioni Widget

### Struttura del File widgets.php
```php
<?php

declare(strict_types=1);

return [
    'doctor' => [
        'profile' => [
            'title' => 'I miei dati', // Italiano
            // 'title' => 'My Data', // Inglese
            // 'title' => 'Meine Daten', // Tedesco
        ],
    ],
];
```

### Utilizzo nelle View
```blade
{{-- Sostituisce testo hardcoded con traduzione multilingua --}}
<h2>{{ __('pub_theme::widgets.doctor.profile.title') }}</h2>
```

### Caso Studio: Profilo Dottore
- **File**: `/laravel/Themes/One/resources/views/filament/widgets/doctor/profile.blade.php`
- **Problema**: Testo hardcoded "I miei dati" non supportava multilingua
- **Soluzione**: Creazione file `widgets.php` e utilizzo `__('pub_theme::widgets.doctor.profile.title')`
- **Risultato**: Supporto completo per italiano, inglese e tedesco

## Script di Sincronizzazione

### File: `bashscripts/translations/sync_theme_translations.php`

Lo script `ThemeTranslationSynchronizer` gestisce la sincronizzazione automatica delle traduzioni:

#### Funzionalità
- **Scansione automatica**: Trova tutti i file di traduzione italiani
- **Creazione cartelle**: Crea automaticamente le cartelle `en/` e `de/` se non esistono
- **Merge intelligente**: Unisce le traduzioni mantenendo quelle esistenti
- **Conteggio statistiche**: Fornisce statistiche dettagliate delle operazioni

#### Utilizzo
```bash
cd /var/www/html/_bases/base_saluteora
php bashscripts/translations/sync_theme_translations.php
```

#### Output di Esempio
```
🚀 Iniziando sincronizzazione traduzioni temi...

📁 Tema: One
   📄 File di traduzione italiani trovati: 9
   ✅ en: 31 chiavi sincronizzate in 9 file
   📁 Creata cartella de per il tema One
   ✅ de: 62 chiavi sincronizzate in 9 file
   📊 Totale tema One: 93 chiavi sincronizzate in 18 file

📁 Tema: Two
   📄 File di traduzione italiani trovati: 9
   ✅ en: 31 chiavi sincronizzate in 9 file
   📁 Creata cartella de per il tema Two
   ✅ de: 62 chiavi sincronizzate in 9 file
   📊 Totale tema Two: 93 chiavi sincronizzate in 18 file

✅ Sincronizzazione traduzioni temi completata!
```

## Risultati della Sincronizzazione

### Statistiche Finali (Aggiornate)
- **Tema One**: 93 chiavi sincronizzate in 18 file
- **Tema Two**: 93 chiavi sincronizzate in 18 file
- **Totale**: 186 chiavi sincronizzate in 36 file

### Lingue Supportate
- **Italiano (it)**: Lingua sorgente
- **Inglese (en)**: Lingua target
- **Tedesco (de)**: Lingua target

## Caratteristiche Tecniche

### Struttura dei File
Ogni file di traduzione segue la struttura standard Laravel:

```php
<?php

declare(strict_types=1);

return [
    'chiave' => 'valore',
    'gruppo' => [
        'sottogruppo' => [
            'chiave' => 'valore',
        ],
    ],
];
```

### Namespace del Tema
Le traduzioni del tema utilizzano il namespace `pub_theme::`:
- `pub_theme::widgets.doctor.profile.title`
- `pub_theme::auth.login.title`
- `pub_theme::theme.footer.copyright`

### Algoritmo di Merge
Lo script utilizza un algoritmo ricorsivo per unire le traduzioni:

1. **Preserva esistenti**: Le traduzioni target esistenti non vengono sovrascritte
2. **Aggiunge mancanti**: Le nuove chiavi italiane vengono aggiunte
3. **Gestisce array**: Supporta strutture nidificate di qualsiasi profondità
4. **Mantiene ordine**: Preserva l'ordine delle chiavi esistenti

### Gestione Errori
- **File mancanti**: Gestisce gracefully i file di traduzione mancanti
- **Sintassi PHP**: Valida la sintassi dei file di traduzione
- **Permessi**: Crea automaticamente le cartelle con i permessi corretti

## Manutenzione

### Aggiornamento Traduzioni
Per aggiornare le traduzioni dopo modifiche:

1. Aggiorna i file italiani in `/lang/it/`
2. Esegui lo script di sincronizzazione
3. Verifica che le nuove chiavi siano state aggiunte
4. Traduci manualmente i valori nelle lingue target

### Backup
Prima di eseguire la sincronizzazione, è consigliabile:
- Fare backup delle traduzioni esistenti
- Testare lo script in ambiente di sviluppo
- Verificare che non ci siano conflitti

### Monitoraggio
- Controlla regolarmente la coerenza delle traduzioni
- Verifica che tutte le chiavi siano presenti in tutte le lingue
- Monitora l'uso delle traduzioni nell'applicazione

## Best Practices

### Naming Convention
- Usa chiavi descrittive e gerarchiche
- Mantieni coerenza nella struttura tra file
- Evita chiavi duplicate o ambigue

### Organizzazione
- Raggruppa le traduzioni per funzionalità
- Usa sottogruppi per organizzare le chiavi
- Mantieni un ordine logico delle chiavi

### Qualità
- Verifica la grammatica e la sintassi
- Assicurati che le traduzioni siano appropriate per il contesto
- Testa le traduzioni nell'interfaccia utente

### Widget Filament
- Crea sempre file `widgets.php` per le traduzioni dei widget
- Usa il namespace `pub_theme::widgets` per le traduzioni del tema
- Evita testo hardcoded nelle view Blade

## Collegamenti

- [Sincronizzazione Moduli](../docs/translation-sync.md)
- [Standard Traduzioni](../docs/translation-standards.md)
- [Best Practice Traduzioni](../docs/translation-best-practices.md)

---

*Ultimo aggiornamento: Dicembre 2024*
*Versione: 1.1* 