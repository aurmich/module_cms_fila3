# Convenzioni di Naming per Filament

## Regola Fondamentale per le Pagine

**TUTTE le classi nella cartella `app/Filament/Clusters/*/Pages` DEVONO terminare con il suffisso "Page".**

## Esempi Corretti

- `SendSmsPage`
- `SendWhatsAppPage`
- `SendTelegramPage`
- `SendEmailPage`
- `TestSmtpPage`

## Esempi ERRATI

- `SendSmsTest` ❌
- `SendWhatsApp` ❌
- `SendTelegram` ❌

## Motivazione

1. **Coerenza con Filament**: Filament utilizza il suffisso "Page" per tutte le sue pagine native
2. **Chiarezza semantica**: Il suffisso "Page" indica chiaramente che la classe rappresenta una pagina dell'interfaccia utente
3. **Distinzione dai test**: Evita confusione con le classi di test, che tipicamente contengono "Test" nel nome
4. **Conformità PSR**: Segue le convenzioni PSR per la nomenclatura delle classi

## Altre Convenzioni Filament

- Risorse: `{Nome}Resource`
- Widget: `{Nome}Widget`
- Componenti: `{Nome}Component`

## Verifica Prima del Commit

Prima di ogni commit, verificare che:
1. Tutte le classi nella cartella `app/Filament/Clusters/*/Pages` terminino con "Page"
2. Tutte le classi nella cartella `app/Filament/Resources` terminino con "Resource"
3. Tutte le classi nella cartella `app/Filament/Widgets` terminino con "Widget"
