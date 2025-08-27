# Regola del Boy Scout - Principio Fondamentale per lo Sviluppo

> **"Lascia sempre il campeggio più pulito di come l'hai trovato"**

## Definizione Ufficiale
La **Regola del Boy Scout** nella programmazione stabilisce che quando si lavora sul codice (sia che lo si scriva da zero, sia che si modifichi del codice esistente), si deve **sempre migliorarlo** in qualche modo, lasciandolo **più pulito, più leggibile e più manutenibile** di quanto non fosse prima.

## Applicazione Obbligatoria
Questa regola deve essere applicata **SEMPRE** in ogni intervento di sviluppo, ha **priorità assoluta** su ogni altro task e deve guidare ogni azione.

## Checklist Boy Scout (da applicare SEMPRE)

### 1. Pre-Analysis
- [ ] Studia la documentazione più vicina (cartelle docs del modulo)
- [ ] Analizza la struttura esistente e identifica aree di miglioramento
- [ ] Verifica standard di qualità e best practices

### 2. Code Improvement
- [ ] Rifattorizza e migliora il codice esistente
- [ ] Aggiungi/migliora tipizzazione e PHPDoc
- [ ] Rimuovi codice morto, commenti inutili, pattern obsoleti
- [ ] Applica principi SOLID e best practices Laravel/Filament
- [ ] Migliora gestione errori e logging

### 3. Documentation Update
- [ ] Aggiorna la documentazione del modulo specifico
- [ ] Aggiorna la documentazione root quando necessario
- [ ] Crea collegamenti bidirezionali tra documentazioni
- [ ] Verifica coerenza tra docs e implementazione

### 4. Rules & Memory Update
- [ ] Aggiorna `.cursor/rules` e `.windsurf/rules`
- [ ] Aggiorna le memorie personali con nuove informazioni
- [ ] Documenta pattern e anti-pattern identificati

### 5. Quality Assurance
- [ ] Applica standard di qualità (PHPStan livello 9+)
- [ ] Verifica naming conventions (docs in minuscolo)
- [ ] Controlla conformità alle regole Laraxot
- [ ] Esegui test appropriati

## Esempi di Applicazione

### Miglioramento Trait SushiToJson
```php
// PRIMA (Boy Scout Violation)
public function getSushiRows(): array
{
    $path = $this->getJsonFile();
    $data = json_decode(file_get_contents($path), true);
    if(!is_array($data)){
        throw new \Exception('Data is not array ['.$path.']');
    }
    // ... logica di normalizzazione poco chiara
    return $data;
}

// DOPO (Boy Scout Applied)
/**
 * Recupera i dati dal file JSON e li prepara per Sushi.
 * 
 * @return array<int, array<string, mixed>> Dati preparati per Sushi
 * @throws \InvalidArgumentException Se il file non contiene dati validi
 * @throws \RuntimeException Se il file non esiste o non è leggibile
 */
public function getSushiRows(): array
{
    $path = $this->getJsonFile();
    
    if (!File::exists($path)) {
        \Log::warning("SushiToJson: File JSON non trovato: {$path}");
        return [];
    }

    // ... gestione robusta con try/catch e logging appropriato
}
```

## Benefici
- **Debt Reduction**: Riduzione costante del debito tecnico
- **Quality Growth**: Miglioramento continuo della qualità del codice
- **Documentation**: Mantiene la documentazione sempre aggiornata
- **Knowledge Sharing**: Trasferisce conoscenza attraverso better practices
- **Sustainability**: Rende il progetto sostenibile nel lungo termine

## Anti-Patterns da Evitare
- ❌ Implementare solo la feature richiesta senza migliorare l'esistente
- ❌ Lasciare codice commentato o non utilizzato
- ❌ Non aggiornare la documentazione correlata
- ❌ Ignorare standard di qualità e best practices
- ❌ Non applicare refactoring quando evidentemente necessario

## Motto
> **"Ogni commit deve lasciare il progetto in uno stato superiore"**

## Link e Riferimenti
- [Clean Code - Robert C. Martin](https://www.oreilly.com/library/view/clean-code-a/9780136083238/)
- [Refactoring - Martin Fowler](https://refactoring.com/)
- [Boy Scout Rule - Clean Code](https://medium.com/@biratkirat/step-8-follow-the-boy-scout-rule-33a728401312)

---
*Aggiornato: 2025-01-07*
*Versione: 1.0*
*Stato: REGOLA FONDAMENTALE - SEMPRE APPLICABILE*
