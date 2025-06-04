# Best Practice: module.json per Moduli Laraxot

## Obiettivi
- Allineare la struttura e i contenuti di `module.json` tra tutti i moduli.
- Garantire che i metadati, provider, keywords e priorità siano coerenti e utili per l’automazione e la discovery.

## Checklist
- [x] `name` e `alias` coerenti con il modulo
- [x] `description` chiara e significativa
- [x] `keywords` utili per la ricerca e la categorizzazione
- [x] `priority` e `order` impostati secondo la rilevanza del modulo
- [x] `active` (1 o 0) per abilitare/disabilitare il modulo
- [x] Provider corretti in `providers`
- [x] Sezione `aliases` e `files` pronte per estensioni future

## Esempio (ispirato a SaluteOra)

```json
{
    "name": "SaluteMo",
    "alias": "salutemo",
    "description": "Gestione delle prestazioni ambulatoriali e monitoraggio salute",
    "keywords": ["prestazioni", "monitoraggio", "salute", "ambulatorio"],
    "priority": 10,
    "active": 1,
    "order": 10,
    "providers": [
        "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
        "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
    ],
    "aliases": {},
    "files": []
}
```

## Note
- Aggiorna la `description` per riflettere lo scopo reale del modulo.
- Usa keywords che aiutino la ricerca e la categorizzazione.
- Imposta `priority` e `order` in modo coerente con gli altri moduli (es. 10 per moduli principali).
- Aggiungi tutti i provider effettivamente usati dal modulo.
- Mantieni la struttura sempre allineata ai moduli principali (es. SaluteOra).

## Collegamenti
- [module.json di SaluteOra](../SaluteOra/module.json)
- [Regole ServiceProvider](../../Xot/docs/SERVICE_PROVIDER.md)
