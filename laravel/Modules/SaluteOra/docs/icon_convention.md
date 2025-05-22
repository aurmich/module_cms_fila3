# Convenzione per le icone SVG

## Panoramica

Questo documento descrive la convenzione per l'utilizzo delle icone SVG all'interno del modulo SaluteOra.

## Convenzione di denominazione

1. **Nome dell'icona**:
   - Deve seguire il formato: `{nome-modulo}-{nome-icona}`
   - Esempio: `saluteora-patient`, `saluteora-doctor`
   - Usare solo lettere minuscole e trattini

2. **Posizione dei file SVG**:
   - I file SVG vanno posizionati in: `resources/svg/`
   - Il nome del file deve corrispondere al nome dell'icona senza il prefisso del modulo
   - Esempio: Per l'icona `saluteora-patient`, il file sarà `resources/svg/patient.svg`

## Registrazione delle icone

Le icone devono essere registrate nel `ServiceProvider` del modulo:

```php
// Nel metodo register() del ServiceProvider
FilamentIcon::register([
    'saluteora-patient' => asset('modules/SaluteOra/resources/svg/patient.svg'),
    'saluteora-doctor' => asset('modules/SaluteOra/resources/svg/doctor.svg'),
]);
```

## Utilizzo nelle viste e nei componenti

Per utilizzare un'icona registrata, utilizzare il nome dell'icona come riferimento:

```php
'icon' => 'saluteora-patient',
```

## Best practice

1. **Ottimizzazione SVG**:
   - Rimuovere metadati non necessari
   - Minimizzare il codice SVG
   - Utilizzare `currentColor` per il colore dell'icona

2. **Dimensioni**:
   - Le icone dovrebbero avere una viewBox di 24x24 pixel
   - Mantenere le proporzioni corrette

3. **Accessibilità**:
   - Aggiungere un titolo descrittivo all'interno del tag SVG
   - Fornire un'alternativa testuale quando appropriato

## Manutenzione

- Aggiornare questo documento quando si aggiungono nuove icone o si modifica la convenzione
- Mantenere un elenco aggiornato delle icone disponibili
- Documentare eventuali eccezioni alla convenzione
