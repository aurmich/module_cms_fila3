# Risoluzione Conflitti Merge

## Introduzione
Questo documento descrive i conflitti di merge risolti nel modulo Xot e le relative soluzioni adottate.

## Conflitti Risolti

### 1. ExportXlsByCollection
- **File**: `app/Actions/Export/ExportXlsByCollection.php`
- **Problema**: Conflitto nella documentazione del metodo `writeRows()`
- **Soluzione**: Mantenuta la versione più completa delle annotazioni PHPDoc
- **Impatto**: Migliorata la compatibilità con PHPStan livello 10
- **Documentazione**: [Dettagli](./actions/export/ExportXlsByCollection_conflict.md)

### 2. ExportXlsByView
- **File**: `app/Actions/Export/ExportXlsByView.php`
- **Problema**: Conflitto nella documentazione del metodo `execute()`
- **Soluzione**: Mantenuta la versione più completa delle annotazioni PHPDoc
- **Impatto**: Migliorata la compatibilità con PHPStan livello 10
- **Documentazione**: [Dettagli](./actions/export/ExportXlsByView_conflict.md)

### 3. GetViewByClassAction
- **File**: `app/Actions/View/GetViewByClassAction.php`
- **Problema**: Conflitto nella conversione del nome della classe in nome della vista
- **Soluzione**: Implementata la conversione esplicita con `strval()`
- **Impatto**: Migliorata la robustezza del codice
- **Documentazione**: [Dettagli](./actions/view/GetViewByClassAction_conflict.md)

## Best Practices per la Risoluzione dei Conflitti

1. **Documentazione**
   - Mantenere sempre la documentazione più completa e aggiornata
   - Assicurare la compatibilità con PHPStan livello 10
   - Documentare le decisioni prese nella risoluzione

2. **Codice**
   - Preferire le soluzioni più robuste e type-safe
   - Mantenere la coerenza con le convenzioni del progetto
   - Evitare duplicazioni di codice

3. **Testing**
   - Verificare che le modifiche non introducano regressioni
   - Assicurare la copertura dei test
   - Validare con PHPStan livello 10

## Collegamenti Correlati

- [PHPStan Level 10 Guide](./PHPSTAN_LIVELLO10_LINEE_GUIDA.md)
- [Best Practices](./BEST-PRACTICES.md)
- [Code Standards](./CODE-STANDARDS.md)
