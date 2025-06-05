# MCP Server Consigliati per il Modulo Chart

## Scopo del Modulo
Gestione e visualizzazione di grafici e dashboard dinamiche.

## Server MCP Consigliati
- `fetch`: Per recuperare dati da API o fonti esterne per i grafici.
- `memory`: Per caching temporaneo dei dati dei grafici.
- `filesystem`: Per esportazione/importazione di grafici e dati.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] }
  }
}
```

## Note
- Personalizza in base al tipo di dashboard e fonti dati.
