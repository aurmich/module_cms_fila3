# Documentazione del Modulo CMS

## Struttura della Documentazione

```
docs/
├── README.md                    # Questo file
├── architecture.md             # Architettura generale del modulo
├── best-practices/            # Best practices e linee guida
│   └── page-rendering.md     # Best practices per il rendering delle pagine
├── migrations/               # Guide per le migrazioni e aggiornamenti
│   └── 01_theme_to_components.md  # Migrazione da ThemeComposer a Componenti
├── content-storage.md        # Gestione e storage dei contenuti
├── homepage_architecture.md  # Architettura della homepage
└── page-resource.md         # Documentazione PageResource
```

## Indice dei Documenti

### Guide Principali

1. [Architettura](architecture.md)
   - Panoramica dell'architettura del modulo CMS
   - Componenti principali e loro interazioni
   - Flusso dei dati e delle richieste

2. [Best Practices](best-practices/page-rendering.md)
   - Linee guida per il rendering delle pagine
   - Utilizzo dei componenti Blade
   - Pattern raccomandati

3. [Guide di Migrazione](migrations/01_theme_to_components.md)
   - Processo di migrazione da ThemeComposer a Componenti Blade
   - Istruzioni passo-passo
   - Piano di rollback

### Documentazione Tecnica

4. [Content Storage](content-storage.md)
   - Sistema di storage dei contenuti
   - Struttura dei file JSON
   - Gestione delle traduzioni

5. [Homepage Architecture](homepage_architecture.md)
   - Struttura della homepage
   - Gestione dei blocchi di contenuto
   - Rendering e caching

6. [Page Resource](page-resource.md)
   - Documentazione del PageResource
   - Integrazione con Filament
   - Gestione dei blocchi di contenuto

## Collegamenti alla Documentazione Generale

La documentazione in questa cartella è collegata alla documentazione generale del progetto in `/docs`. I file principali hanno riferimenti bidirezionali per facilitare la navigazione.

### Collegamenti Principali

- [Documentazione Generale CMS](/docs/cms/README.md)
- [Documentazione dei Temi](/docs/themes/README.md)
- [Documentazione API](/docs/api/README.md)

## Convenzioni di Documentazione

1. **Struttura dei File**
   - Utilizzare nomi file in kebab-case
   - Aggiungere il suffisso `.md` a tutti i file
   - Mantenere una struttura gerarchica logica

2. **Contenuto**
   - Iniziare ogni file con un titolo principale
   - Includere una breve descrizione del contenuto
   - Utilizzare sezioni e sottosezioni con titoli appropriati
   - Aggiungere esempi di codice quando necessario

3. **Collegamenti**
   - Utilizzare percorsi relativi per i collegamenti interni
   - Aggiungere tag `@see` per i riferimenti ai file di codice
   - Mantenere i collegamenti bidirezionali aggiornati

4. **Esempi di Codice**
   - Utilizzare blocchi di codice con sintassi evidenziata
   - Specificare il linguaggio del codice
   - Includere commenti esplicativi

## Manutenzione

La documentazione dovrebbe essere aggiornata ogni volta che:

1. Vengono implementate nuove funzionalità
2. Vengono modificati comportamenti esistenti
3. Vengono deprecate o rimosse funzionalità
4. Vengono identificati errori o imprecisioni

## Contribuire

Per contribuire alla documentazione:

1. Creare un nuovo branch
2. Aggiungere o modificare la documentazione
3. Assicurarsi che i collegamenti siano corretti
4. Aprire una pull request

---
@see /docs/README.md
@see /docs/cms/README.md
