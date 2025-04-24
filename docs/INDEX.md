# Documentazione Modulo CMS

## Perché questo modulo
Il modulo CMS è responsabile della gestione dei contenuti, dei temi e della presentazione del sito. È un componente fondamentale che gestisce l'interfaccia utente e l'esperienza di navigazione.

## Struttura della Documentazione

### Gestione Temi
- [Errori Vite e Risoluzione](themes/VITE_ERRORS.md)
  - Gestione errori di compilazione
  - Processo di build dei temi
  - Troubleshooting comune

### Analisi Statica
- [Analisi PHPStan](phpstan/ANALISI_PHPSTAN.md)
  - Problematiche rilevate
  - Piano di correzione
  - Monitoraggio continuo

## Collegamenti Esterni
- [Documentazione Generale](/docs/INDEX.md)
- [Gestione Errori](/docs/errors/README.md)
- [Processo di Deploy](/docs/deployment/README.md)

## Best Practices
- Mantenere i temi aggiornati e compilati
- Seguire le convenzioni di naming
- Documentare ogni modifica significativa
- Utilizzare il versionamento per i file di configurazione

## Note di Sviluppo
- Utilizzare Spatie Laravel Data per la gestione dei dati
- Preferire Spatie QueableActions ai servizi
- Seguire le linee guida Laravel e Laraxot 