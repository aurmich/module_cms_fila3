<<<<<<< HEAD
# Gestione della Homepage

## Struttura e Modifica Corretta

La homepage del portale è gestita attraverso un file JSON che definisce i blocchi di contenuto visualizzati. Per modificare la homepage è necessario intervenire sul seguente file:

```
/laravel/config/local/database/content/pages/1.json
```

### Struttura del file JSON

Il file JSON della homepage ha la seguente struttura:
=======
# Gestione della Homepage in il progetto

Questo documento fornisce una panoramica generale della gestione della homepage in il progetto. Per i dettagli tecnici dell'implementazione, consultare la [documentazione tecnica nel modulo CMS](../laravel/Modules/Cms/docs/homepage.md).

## Panoramica

La homepage di il progetto è il punto di ingresso principale per gli utenti del portale. È progettata per:

1. Fornire informazioni chiare sui servizi offerti
2. Facilitare l'accesso ai servizi per le pazienti vulnerabili in stato di gravidanza
3. Presentare statistiche e informazioni sul progetto

## Struttura dei File

La homepage di il progetto è gestita attraverso due componenti principali:

1. **File di Configurazione JSON**:
   ```
   /var/www/html/saluteora/laravel/config/local/saluteora/database/content/pages/1.json
   ```
   Questo file contiene la definizione completa dei contenuti della homepage.

2. **Template Blade**:
   ```
   /laravel/Themes/One/resources/views/pages/index.blade.php
   ```
   Questo file gestisce il rendering dei contenuti.

## Configurazione dei Contenuti

Il file `1.json` contiene la struttura completa della homepage:
>>>>>>> f492947 (.)

```json
{
    "id": "1",
    "title": {
<<<<<<< HEAD
        "it": "Promozione della salute orale per le gestanti"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            // Qui sono definiti i blocchi di contenuto
            // Ogni blocco ha un "type" e dei "data" specifici
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": null
}
```

### Tipi di blocchi disponibili

I blocchi attualmente implementati includono:

1. **hero** - Banner principale con titolo, sottotitolo e immagine
2. **feature_sections** - Sezioni con caratteristiche del servizio
3. **stats** - Statistiche del progetto
4. **cta** - Call to action

### Come modificare la homepage

Per modificare la homepage, è necessario:

1. Identificare il blocco che si desidera modificare nel file JSON
2. Aggiornare i valori nei campi "data" del blocco
3. Aggiungere nuovi blocchi se necessario, seguendo la struttura esistente

### Esempio di modifica per aggiornare il testo principale

Per aggiornare il testo principale della homepage:

```json
{
    "type": "text_block",
    "data": {
        "view": "ui::components.blocks.text.v1",
        "content": "Benvenuta nel portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito.\n\nSe sei una donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore, e vuoi partecipare a questa iniziativa clicca il pulsante qui sotto:",
        "alignment": "left",
        "background_color": "bg-white",
        "text_color": "text-gray-900"
=======
        "it": "il progetto - Promozione della salute orale per le gestanti"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
            // Blocchi di contenuto
        ]
>>>>>>> f492947 (.)
    }
}
```

<<<<<<< HEAD
### Esempio di modifica per aggiungere un pulsante "INIZIA ORA"

```json
{
    "type": "cta",
    "data": {
        "view": "ui::components.blocks.cta.v1",
        "title": "",
        "description": "",
        "button_text": "INIZIA ORA",
        "button_link": "/register",
        "background_color": "bg-white",
        "text_color": "text-gray-900",
        "button_color": "bg-indigo-600 hover:bg-indigo-700"
=======
### Struttura dei Blocchi

Ogni blocco ha una struttura standard:
```json
{
    "type": "tipo_blocco",
    "data": {
        "view": "percorso_componente_blade",
        // Altri dati specifici del blocco
>>>>>>> f492947 (.)
    }
}
```

<<<<<<< HEAD
## Analisi dell'Errore Commesso

### Errore identificato

Nell'approccio precedente, ho commesso un errore fondamentale: ho proposto modifiche concettuali all'interfaccia utente senza considerare l'architettura tecnica del sistema. Ho ignorato completamente che:

1. I contenuti sono gestiti tramite file JSON strutturati
2. Esiste un percorso specifico per questi file (`/laravel/config/local/database/content/`)
3. La modifica deve avvenire rispettando la struttura dei blocchi esistenti

### Cause dell'errore

1. **Mancata analisi dell'architettura**: Non ho esaminato come i contenuti vengono effettivamente gestiti nel sistema
2. **Approccio superficiale**: Ho proposto modifiche generiche senza considerare l'implementazione tecnica
3. **Ignoranza del pattern di gestione dei contenuti**: Non ho considerato che il sistema utilizza un sistema di gestione dei contenuti basato su JSON

### Come evitare questo errore in futuro

1. **Analizzare sempre la struttura dei dati**: Prima di proporre modifiche, esaminare come i contenuti sono strutturati e gestiti
2. **Verificare i file di configurazione**: Controllare i file JSON nella directory `/laravel/config/local/database/content/`
3. **Rispettare la struttura dei blocchi**: Utilizzare i tipi di blocchi esistenti o crearne di nuovi seguendo lo stesso pattern
4. **Testare le modifiche**: Dopo aver modificato i file JSON, verificare che le modifiche siano visualizzate correttamente

## Regola Fondamentale

> **IMPORTANTE**: I contenuti delle pagine sono gestiti tramite file JSON nella directory `/laravel/config/local/database/content/`. Qualsiasi modifica ai contenuti deve essere effettuata modificando questi file, rispettando la struttura dei blocchi esistenti. Non proporre mai modifiche concettuali senza considerare l'implementazione tecnica sottostante.

# Gestione Homepage

## Struttura della Homepage

La homepage del progetto è gestita attraverso un sistema di temi che permette una gestione flessibile e dinamica del contenuto.

### File Principali

- `laravel/Themes/One/resources/views/home.blade.php`: Template principale della homepage
- `laravel/Themes/One/resources/views/welcome.blade.php`: Template di benvenuto
- `public_html/index.php`: Punto di ingresso dell'applicazione

### Sistema di Temi

La homepage utilizza un sistema di temi che permette di:
- Caricare contenuti dinamicamente
- Personalizzare l'aspetto in base al tema selezionato
- Gestire diversi layout per diverse sezioni

Il contenuto principale viene caricato attraverso:
```php
{{ $_theme->showPageContent('home') }}
```

### Componenti della Homepage

La homepage include:
1. Header con logo e menu di navigazione
2. Sezione principale con contenuto dinamico
3. Footer con informazioni di sistema

### Personalizzazione

Per personalizzare la homepage:
1. Modificare il template nel tema corrente
2. Aggiornare i contenuti attraverso il sistema di gestione
3. Configurare il tema desiderato nel pannello di amministrazione

## Best Practices

- Mantenere il codice pulito e ben organizzato
- Utilizzare componenti riutilizzabili
- Seguire le convenzioni di naming
- Documentare tutte le modifiche
- Testare su diversi dispositivi e browser
=======
## Tipi di Blocchi Disponibili

1. **Hero** (`type: "hero"`):
   - Sezione principale con immagine di sfondo
   - Titolo e sottotitolo
   - Call-to-action personalizzabile

2. **Paragraph** (`type: "paragraph"`):
   - Blocchi di testo semplice
   - Supporto per contenuti formattati

3. **Feature Sections** (`type: "feature_sections"`):
   - Sezioni con icone
   - Titoli e descrizioni
   - Layout personalizzabile

4. **Stats** (`type: "stats"`):
   - Visualizzazione di statistiche
   - Numeri e label personalizzabili

5. **CTA** (`type: "cta"`):
   - Call-to-action standalone
   - Pulsanti e link personalizzabili

## Personalizzazione

### Modificare i Contenuti

Per modificare i contenuti della homepage:

1. Aprire il file `1.json`
2. Modificare i blocchi esistenti o aggiungerne di nuovi
3. Rispettare la struttura JSON e i tipi di blocchi supportati

### Aggiungere Nuovi Tipi di Blocchi

Per aggiungere un nuovo tipo di blocco:

1. Creare il componente Blade corrispondente
2. Aggiungere la logica di rendering nel ThemeComposer
3. Aggiungere il nuovo blocco nel file JSON

## Gestione dei Contenuti

I contenuti della homepage sono gestiti attraverso un sistema basato su JSON che permette:
- Aggiornamenti facili e veloci
- Supporto multilingua
- Flessibilità nella struttura

Per i dettagli tecnici sulla gestione dei contenuti, consultare:
- [Documentazione Tecnica CMS](../laravel/Modules/Cms/docs/homepage.md)
- [Gestione dei Blocchi](../laravel/Modules/Cms/docs/content-blocks.md)
- [Sistema dei Temi](../laravel/Modules/Cms/docs/themes.md)

## Collegamenti alla Documentazione

- [Architettura del Frontoffice](./architettura_frontoffice.md)
- [Linee Guida per la Documentazione](./linee-guida-documentazione.md)
- [Standard di Codice](./standard-codice.md)
>>>>>>> f492947 (.)
