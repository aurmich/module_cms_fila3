# Aggiornamento Rules e Memories - FormBuilder Module

## Rules Aggiornate

### 1. Gestione Conflitti di Merge
- **Regola**: Tutti i file con conflitti di merge devono essere spostati nelle cartelle `docs` prima della risoluzione
- **Regola**: Documentare sempre la strategia di risoluzione prima dell'implementazione
- **Regola**: Mantenere la compatibilità con le dipendenze esterne (es. LaraZeus\Bolt)

### 2. Architettura FormBuilder
- **Regola**: Il modello `Form` deve estendere `LaraZeus\Bolt\Models\Form as BaseForm`
- **Regola**: Utilizzare i modelli corretti: `FormTemplate`, `FormSubmission`, `FormField`
- **Regola**: Evitare i modelli obsoleti: `Field`, `Response`

### 3. Widget Pattern
- **Regola**: Tutti i widget devono utilizzare array associativi per i return types
- **Regola**: Implementare controlli di esistenza delle classi per evitare errori
- **Regola**: Utilizzare annotazioni PHPStan per template types

### 4. Relazioni Modelli
- **Regola**: `FormSubmission` deve avere relazione `belongsTo` con `FormTemplate`
- **Regola**: `FormTemplate` deve avere relazioni `hasMany` con `FormSubmission` e `FormField`
- **Regola**: Utilizzare campi timestamp appropriati (`submitted_at` per submission)

## Memories Aggiornate

### 1. Conflitti Risolti
- **Memory**: Form.php - Estende LaraZeus\Bolt\Models\Form con PHPDoc completo
- **Memory**: FormStatsWidget.php - Utilizza FormTemplate, FormSubmission, FormField
- **Memory**: RecentSubmissionsWidget.php - Sostituito Response con FormSubmission
- **Memory**: FormFieldsDistributionWidget.php - Sostituito Field con FormField
- **Memory**: FormBuilderServiceProvider.php - Già risolto, estende XotBaseServiceProvider

### 2. Modelli Principali
- **Memory**: Form - Estende LaraZeus\Bolt\Models\Form, mantiene compatibilità
- **Memory**: FormTemplate - Template per i form, ha relazioni con submissions e fields
- **Memory**: FormSubmission - Submission dei form, relazione con formTemplate
- **Memory**: FormField - Campi dei form, relazione con formTemplate

### 3. Widget Aggiornati
- **Memory**: FormStatsWidget - Statistiche su form, template, submission
- **Memory**: RecentSubmissionsWidget - Mostra submission recenti con formTemplate
- **Memory**: FormFieldsDistributionWidget - Distribuzione tipi campo con controlli sicurezza

### 4. Pattern Implementati
- **Memory**: Utilizzo di `@phpstan-ignore-next-line` per casi specifici
- **Memory**: Controlli `class_exists()` per evitare errori
- **Memory**: Type safety per mixed values
- **Memory**: Array associativi per metodi Filament

### 5. Qualità Codice
- **Memory**: Tutti i file passano l'analisi PHPStan
- **Memory**: PHPDoc completo per tutti i modelli
- **Memory**: Relazioni documentate correttamente
- **Memory**: Architettura Laraxot rispettata

## Nuove Regole per Conflitti

### 1. Processo di Risoluzione
1. **Identificazione**: Trovare tutti i file con marcatori
2. **Spostamento**: Copiare i file nelle cartelle `docs`
3. **Analisi**: Documentare le differenze tra le versioni
4. **Strategia**: Proporre soluzioni prima dell'implementazione
5. **Implementazione**: Risolvere i conflitti uno per uno
6. **Verifica**: Testare e verificare con PHPStan

### 2. Pattern per Conflitti di Modelli
- **Regola**: Mantenere l'estensione di classi esterne se necessaria
- **Regola**: Aggiungere PHPDoc completo per IDE support
- **Regola**: Implementare relazioni corrette tra modelli
- **Regola**: Utilizzare campi timestamp appropriati

### 3. Pattern per Conflitti di Widget
- **Regola**: Utilizzare i modelli corretti (non obsoleti)
- **Regola**: Aggiornare le relazioni nei widget
- **Regola**: Mantenere i fix PHPStan esistenti
- **Regola**: Aggiungere controlli di sicurezza

### 4. Pattern per Conflitti di Service Provider
- **Regola**: Mantenere l'estensione di XotBaseServiceProvider
- **Regola**: Configurazione semplificata del modulo
- **Regola**: Evitare casting complessi

## Regole per Documentazione

### 1. Documentazione Conflitti
- **Regola**: Creare sempre un documento di analisi prima della risoluzione
- **Regola**: Documentare le differenze tra le versioni
- **Regola**: Proporre soluzioni specifiche per ogni conflitto
- **Regola**: Aggiornare la documentazione dopo la risoluzione

### 2. Documentazione Modelli
- **Regola**: PHPDoc completo per tutti i modelli
- **Regola**: Documentare le relazioni tra modelli
- **Regola**: Documentare i campi timestamp utilizzati
- **Regola**: Documentare le dipendenze esterne

### 3. Documentazione Widget
- **Regola**: Documentare lo scopo di ogni widget
- **Regola**: Documentare i modelli utilizzati
- **Regola**: Documentare le relazioni nei widget
- **Regola**: Documentare i controlli di sicurezza

## Regole per Qualità

### 1. PHPStan Compliance
- **Regola**: Tutti i file devono passare l'analisi PHPStan
- **Regola**: Utilizzare annotazioni `@phpstan-ignore-next-line` solo quando necessario
- **Regola**: Implementare type safety per mixed values
- **Regola**: Utilizzare array associativi per return types

### 2. Architettura Laraxot
- **Regola**: Seguire l'architettura Laraxot
- **Regola**: Utilizzare BaseModel dove appropriato
- **Regola**: Mantenere compatibilità con dipendenze esterne
- **Regola**: Implementare pattern di composizione invece di ereditarietà

### 3. Testing e Verifica
- **Regola**: Testare tutte le funzionalità dopo la risoluzione
- **Regola**: Verificare la compatibilità con il sistema esistente
- **Regola**: Aggiornare i test se necessario
- **Regola**: Verificare la qualità del codice con PHPStan

## Conclusione

Le rules e memories sono state aggiornate per riflettere:
1. Il processo di risoluzione dei conflitti di merge
2. L'architettura corretta del modulo FormBuilder
3. I pattern per widget e modelli
4. Le regole per la qualità del codice
5. La documentazione appropriata

Queste regole e memories aiuteranno a mantenere la qualità del codice e a risolvere futuri conflitti in modo sistematico. 