# Icone disponibili nel modulo SaluteOra

## Elenco delle icone

| Nome Icona | File SVG | Esempio di utilizzo |
|------------|----------|---------------------|
| saluteora-calendar | calendar.svg | `icon="saluteora-calendar"` |
| saluteora-clock | clock.svg | `icon="saluteora-clock"` |
| saluteora-consent | consent.svg | `icon="saluteora-consent"` |
| saluteora-patient | patient.svg | `icon="saluteora-patient"` |
| saluteora-phone | phone.svg | `icon="saluteora-phone"` |
| saluteora-shield-check | shield-check.svg | `icon="saluteora-shield-check"` |
| saluteora-users | users.svg | `icon="saluteora-users"` |

## Come aggiungere una nuova icona

1. Aggiungi il file SVG nella cartella `resources/svg/`
2. Registra l'icona nel `ServiceProvider` del modulo
3. Aggiorna questo documento con la nuova icona

## Convenzioni

- Tutti i nomi dei file devono essere in minuscolo con trattini
- Usare `currentColor` per il colore dell'icona
- Mantenere la viewBox a 24x24 pixel
- Rimuovere metadati non necessari dagli SVG
