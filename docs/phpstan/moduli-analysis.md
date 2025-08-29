# Analisi PHPStan dei Moduli

## Stato Generale dell'Analisi

| Modulo | Livello Attuale | Target | Stato | Errori Critici |
|--------|----------------|--------|--------|----------------|
| Theme  | 8 | 9 | 🟡 In Corso | 0 |
| Predict | - | 8 | ⚪ Da Iniziare | - |
| Core | - | 8 | ⚪ Da Iniziare | - |
| Chart | - | 8 | ⚪ Da Iniziare | - |
| Xot | - | 8 | ⚪ Da Iniziare | - |
| User | - | 8 | ⚪ Da Iniziare | - |
| UI | - | 8 | ⚪ Da Iniziare | - |
| Tenant | - | 8 | ⚪ Da Iniziare | - |
| Setting | - | 8 | ⚪ Da Iniziare | - |
| Seo | - | 8 | ⚪ Da Iniziare | - |
| Rating | - | 8 | ⚪ Da Iniziare | - |
| Media | - | 8 | ⚪ Da Iniziare | - |
| Lang | - | 8 | ⚪ Da Iniziare | - |
| Geo | - | 8 | ⚪ Da Iniziare | - |
| Job | - | 8 | ⚪ Da Iniziare | - |
| Comment | - | 8 | ⚪ Da Iniziare | - |
| Gdpr | - | 8 | ⚪ Da Iniziare | - |
| Cms | - | 8 | ⚪ Da Iniziare | - |
| Blog | - | 8 | ⚪ Da Iniziare | - |
| Activity | - | 8 | ⚪ Da Iniziare | - |
| AI | - | 8 | ⚪ Da Iniziare | - |
| Notify | - | 8 | ⚪ Da Iniziare | - |

Legenda Stato:
- 🟢 Completato
- 🟡 In Corso
- 🔴 Problemi Critici
- ⚪ Da Iniziare

## Piano di Analisi e Correzione

### Priorità Alta
1. **Core** - Modulo fondamentale
2. **Xot** - Base per altri moduli
3. **User** - Gestione utenti
4. **Theme** - Gestione temi (in corso)

### Priorità Media
1. **Cms**
2. **Blog**
3. **Media**
4. **UI**

### Priorità Bassa
Rimanenti moduli

## Processo di Analisi

Per ogni modulo, seguire questo processo:

1. **Analisi Iniziale**
```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=0
```

2. **Generazione Baseline**
```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --generate-baseline
```

3. **Incremento Graduale**
- Partire dal livello 0
- Risolvere tutti gli errori
- Incrementare al livello successivo
- Ripetere fino al livello target

4. **Documentazione**
- Creare file `phpstan-analysis.md` nella cartella docs del modulo
- Documentare errori ricorrenti e soluzioni
- Aggiornare questo file con lo stato

## Errori Comuni e Soluzioni

### 1. Type Hints Mancanti
```php
// Prima
public function getUser($id)

// Dopo
public function getUser(int $id): ?User
```

### 2. Proprietà Non Inizializzate
```php
// Prima
class Example {
    private string $property;
}

// Dopo
class Example {
    private string $property = '';
    // oppure
    public function __construct(
        private string $property = ''
    ) {}
}
```

### 3. Return Type Declarations
```php
// Prima
public function process()

// Dopo
public function process(): void
```

## Template Documentazione Modulo

Per ogni modulo, creare un file `docs/phpstan-analysis.md` con questa struttura:

```markdown
# Analisi PHPStan - Modulo [Nome]

## Stato Attuale
- Livello: X
- Errori: N
- Baseline: Si/No

## Errori Principali
1. [Descrizione Errore]
   - File: path/to/file.php
   - Soluzione: [Descrizione]

## Problemi Risolti
1. [Problema]
   - Come: [Soluzione]
   - Quando: [Data]

## Note Tecniche
- Dipendenze
- Configurazioni speciali
- Ignore patterns necessari
```

## Automazione

### Script di Analisi
```bash
#!/bin/bash
MODULE=$1
LEVEL=$2

echo "Analisi PHPStan del modulo $MODULE a livello $LEVEL"
./vendor/bin/phpstan analyse Modules/$MODULE --level=$LEVEL
```

### Continuous Integration
```yaml
phpstan:
  script:
    - for module in Modules/*; do
        if [ -d "$module" ]; then
          ./vendor/bin/phpstan analyse "$module" --level=8
        fi
      done
```

## Prossimi Passi

1. Iniziare l'analisi dei moduli prioritari
2. Creare documentazione specifica per ogni modulo
3. Implementare CI/CD per PHPStan
4. Aggiornare regolarmente questo documento

## Note Importanti

1. **Backup**
   - Fare backup prima di correzioni massive
   - Testare le correzioni in ambiente di sviluppo

2. **Performance**
   - Monitorare impatto delle correzioni
   - Ottimizzare configurazione PHPStan

3. **Team**
   - Condividere best practices
   - Review delle correzioni
   - Aggiornare documentazione 