# Clean Code nei Wizard

## Regola fondamentale
Ogni step di un wizard deve essere implementato in una funzione separata, con responsabilità singola e nome chiaro. Questo garantisce:
- Maggiore leggibilità e manutenibilità
- Facilità di test e debug
- Riduzione della complessità
- Aderenza ai principi SOLID e Clean Code

## Applicazione
- Ogni funzione rappresenta uno step logico del wizard
- Evitare funzioni monolitiche che gestiscono più step
- Ogni funzione deve avere un nome descrittivo (es: `renderStep1`, `validateStep2`, ...)
- Documentare la logica di ogni step nella funzione e nella documentazione del modulo

## Cross-reference
- Questa regola è collegata a Xot/docs/clean-code.md e Xot/docs/wizard-best-practices.md

---
Ultimo aggiornamento: 2025-05-27
Responsabile: Cascade AI
