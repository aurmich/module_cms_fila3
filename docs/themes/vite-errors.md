# Gestione Errori Vite nei Temi

## Panoramica

Questo documento descrive gli errori comuni relativi a Vite nella gestione dei temi del CMS e come risolverli.

## Errori Comuni

### 1. Unable to locate file in Vite manifest

#### Descrizione
L'errore si verifica quando il sistema non riesce a trovare i file di asset (CSS, JS) nel manifest di Vite.

#### Sintomo
```
Internal Server Error
Illuminate\Foundation\ViteException
Unable to locate file in Vite manifest: resources/css/app.css
```

#### Cause
- Tema non pubblicato correttamente
- Manifest non generato
- Percorsi non corretti
- Cache non aggiornata

#### Soluzione
1. Pubblicare il tema:
```bash
cd /var/www/html/_bases/base_predict_fila3_mono/laravel/Themes/TwentyOne
npm run copy
```

2. Verificare la struttura:
```bash
ls -la public/themes/TwentyOne/dist/
```

3. Pulire la cache:
```bash
php artisan cache:clear
php artisan view:clear
```

#### Documentazione Correlata
- [Documentazione Vite nel Tema](../Themes/TwentyOne/docs/vite-error.md)
- [Processo di Pubblicazione](../Themes/TwentyOne/docs/publishing.md)
- [Configurazione Vite](../Themes/TwentyOne/vite.config.js)

### 2. Manifest non trovato

#### Descrizione
Il file manifest.json non viene trovato nella cartella di destinazione.

#### Cause
- Compilazione non completata
- Percorsi errati
- Permessi non corretti

#### Soluzione
1. Verificare la configurazione Vite
2. Controllare i permessi delle cartelle
3. Ricompilare gli asset

### 3. Asset non aggiornati

#### Descrizione
Gli asset non vengono aggiornati dopo la pubblicazione.

#### Cause
- Cache del browser
- Timestamp non aggiornati
- File non copiati correttamente

#### Soluzione
1. Forzare la ricompilazione
2. Pulire la cache del browser
3. Verificare i timestamp

## Best Practices

1. **Automazione**
   - Utilizzare script di pubblicazione
   - Implementare controlli pre-deployment
   - Automatizzare il processo di build

2. **Monitoraggio**
   - Controllare i log di Vite
   - Verificare i manifest generati
   - Monitorare le performance

3. **Manutenzione**
   - Mantenere aggiornate le dipendenze
   - Documentare le modifiche
   - Eseguire backup regolari

## Collegamenti

### Documentazione del Tema
- [Vite Error Documentation](../../Themes/TwentyOne/docs/vite-error.md)
- [Publishing Process](../../Themes/TwentyOne/docs/publishing.md)
- [Vite Configuration](../../Themes/TwentyOne/vite.config.js)

### Documentazione Root
- [Tema Management](../../../docs/themes/management.md)
- [Asset Compilation](../../../docs/build/asset-compilation.md)
- [Cache Management](../../../docs/cache/management.md)

## Note Importanti

- Mantenere sincronizzati i percorsi tra codice e manifest
- Verificare la compatibilità con le versioni di Laravel
- Documentare ogni modifica alla configurazione 