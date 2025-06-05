# Gestione degli Assets del Tema One

## Pacchetto NPM

Il tema One è pubblicato come `laraxot/theme_one_fila3` ed è un tema riutilizzabile per progetti Laravel + Filament 3.

## Script "copy" - FONDAMENTALE

Lo script `"copy": "cp -r ./public* ../../../public_html/themes/One"` nel `package.json` è **ASSOLUTAMENTE INDISPENSABILE** per il corretto funzionamento del tema. Ecco perché:

### Importanza Critica

1. **Sincronizzazione Assets**
   - Copia tutti gli assets compilati nella directory pubblica del progetto
   - Mantiene allineati gli assets tra il tema e la directory pubblica
   - Garantisce che il frontend possa accedere agli assets compilati

2. **Struttura del Progetto**
   - Il tema è un pacchetto npm indipendente (`laraxot/theme_one_fila3`)
   - Gli assets compilati devono essere accessibili dal web server
   - Il percorso di destinazione è configurabile per ogni progetto

3. **Processo di Build**
   - Vite compila gli assets in `./public*`
   - Lo script `copy` li sposta nella posizione corretta
   - Il percorso di destinazione può essere personalizzato per ogni installazione

### Configurazione per Altri Progetti

Lo script `copy` deve essere adattato al progetto specifico:
```json
{
    "scripts": {
        "copy": "cp -r ./public* PATH_TO_YOUR_PUBLIC_THEME_DIRECTORY"
    }
}
```

### Conseguenze della Rimozione

La rimozione dello script `copy` causa:
- Assets non disponibili in produzione
- Errori 404 per file CSS/JS
- Malfunzionamento del tema
- Problemi di rendering
- Errori di caricamento risorse

### Utilizzo Corretto

1. Durante lo sviluppo:
```bash
npm run dev
npm run copy
```

2. In produzione:
```bash
npm run build
npm run copy
```

### Verifica degli Assets

Dopo l'esecuzione dello script, verificare:
1. La presenza degli assets nella directory pubblica configurata
2. I permessi dei file copiati
3. L'accessibilità via web degli assets
4. Il corretto caricamento nel browser

## Collegamenti

- [Riutilizzabilità del Tema](theme-reusability.md)
- [Processo di Build](build-process.md)
- [Gestione Assets](ASSETS.md)
- [Struttura del Tema](theme-structure.md)
- [Documentazione CMS](../../Modules/Cms/docs/themes/assets.md)
- [Root Documentation](../../../docs/themes/assets.md) 