# Errore build Vite: require() of ES Module

## Descrizione
Durante il comando `npm run build` viene restituito il seguente errore:

```
Error [ERR_REQUIRE_ESM]: require() of ES Module .../laravel-vite-plugin/dist/index.js from .../vite.config.js not supported.
Instead change the require of index.js in .../vite.config.js to a dynamic import() which is available in all CommonJS modules.
```

## Analisi Tecnica
- **Motivo:** La versione aggiornata di `laravel-vite-plugin` (>=v1.x) è un ES Module e non può più essere importata tramite `require()` o in config CJS.
- **Conseguenza:** Il file `vite.config.js` deve essere convertito in ESM (cioè rinominato in `vite.config.mjs` e usare `import` anziché `require`).
- **Contesto:** L'errore è dovuto all'aggiornamento delle dipendenze (vedi package.json) che ora richiedono ESM per Vite e i suoi plugin.

## Soluzione
1. Rinominare `vite.config.js` in `vite.config.mjs`.
2. Aggiornare la sintassi degli import da `require` a `import`.
3. Verificare che tutti i plugin siano compatibili con ESM.

## Fonti
- https://vitejs.dev/guide/troubleshooting.html#vite-cjs-node-api-deprecated
- https://github.com/laravel/vite-plugin/issues/219

## Regole di progetto
- Ogni volta che si aggiorna una dipendenza Vite, verificare la compatibilità ESM delle config.
- Documentare sempre la causa degli errori di build in questa cartella.
