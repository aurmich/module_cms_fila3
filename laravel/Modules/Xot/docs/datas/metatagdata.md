# MetatagData

## Filosofia dei Getter

La classe `MetatagData` segue una filosofia di design basata su principi semantici piuttosto che implementativi. Questo significa che i metodi getter riflettono lo scopo semantico del dato che stanno recuperando, non i dettagli di implementazione.

### Principi Chiave

1. **Semantica vs. Implementazione**
   - I metodi riflettono il loro scopo semantico
   - I nomi sono basati sul dominio del business
   - I dettagli di implementazione sono nascosti

2. **Coerenza con il Dominio**
   - Uso di termini del dominio (es. "brand" invece di "header")
   - Evitare termini tecnici non necessari
   - Mantenere la coerenza con il linguaggio del business

3. **Incapsulamento**
   - Nascondere i dettagli di implementazione
   - Fornire un'interfaccia pulita e semantica
   - Permettere modifiche future all'implementazione

## Metodi Principali

### Brand Identity

```php
// Recupera il logo del brand
$metatag->getBrandLogo()

// Recupera il logo del brand per la modalità scura
$metatag->getDarkBrandLogo()

// Recupera il nome del brand
$metatag->getBrandName()

// Recupera la descrizione del brand
$metatag->getBrandDescription()
```

### Theme e Stile

```php
// Recupera i colori del tema
$metatag->getThemeColors()

// Recupera le dimensioni del brand
$metatag->getBrandDimensions()

// Recupera le impostazioni del brand
$metatag->getBrandSettings()
```

### Social Media

```php
// Recupera i link social del brand
$metatag->getBrandSocialLinks()
```

## Metodi Deprecati

I seguenti metodi sono stati deprecati in favore di alternative più semantiche:

- `getLogoHeader()` → `getBrandLogo()`
- `getLogoHeaderDark()` → `getDarkBrandLogo()`
- `getColors()` → `getThemeColors()`
- `getTitle()` → `getBrandName()`
- `getDescription()` → `getBrandDescription()`
- `getSocialCards()` → `getBrandSocialLinks()`
- `getDimensions()` → `getBrandDimensions()`
- `getSettings()` → `getBrandSettings()`

## Esempi di Utilizzo

### Recupero del Logo

```php
// ❌ Vecchio approccio (basato sull'implementazione)
$logo = $metatag->getLogoHeader();

// ✅ Nuovo approccio (basato sulla semantica)
$logo = $metatag->getBrandLogo();
```

### Recupero dei Colori

```php
// ❌ Vecchio approccio (esposizione della struttura)
$colors = $metatag->getColors();

// ✅ Nuovo approccio (focus sul tema)
$colors = $metatag->getThemeColors();
```

## Best Practices

1. **Sempre usare i metodi semantici**
   - Preferire i metodi che iniziano con "getBrand"
   - Evitare i metodi deprecati
   - Seguire la convenzione di naming

2. **Documentazione**
   - Ogni metodo ha una documentazione chiara
   - Gli esempi mostrano l'uso corretto
   - I metodi deprecati sono chiaramente marcati

3. **Mantenimento**
   - Aggiornare il codice per usare i nuovi metodi
   - Rimuovere gradualmente l'uso dei metodi deprecati
   - Mantenere la retrocompatibilità

## Collegamenti

- [Filosofia dei Getter](../getter_philosophy.md)
- [Convenzioni di Naming](../naming-conventions.md)
- [Linee Guida Filament](../filament-best-practices.md)

## Descrizione
La classe `MetatagData` gestisce i meta tag e le configurazioni visive dell'applicazione, inclusi colori, loghi e favicon.

## Pattern dei Getter
La classe segue un pattern specifico per l'accesso alle proprietà:

1. **Getter Base**: Per ogni proprietà pubblica, esiste un getter base che restituisce il valore raw della proprietà (es: `getColors()` per `$colors`)
2. **Getter Specializzati**: Per proprietà che richiedono formattazione speciale o logica aggiuntiva, esistono getter specifici (es: `getFilamentColors()`, `getAllColors()`)

### Gerarchia dei Getter per i Colori
- `getColors()`: Getter base che restituisce l'array raw dei colori
- `getFilamentColors()`: Getter specializzato che formatta i colori per Filament
- `getAllColors()`: Getter specializzato che restituisce una versione semplificata dei colori

## Motivazione per getColors()
Il metodo `getColors()` è necessario per:
1. Seguire il pattern consistente di getter base per tutte le proprietà
2. Permettere l'accesso ai dati raw quando necessario
3. Mantenere la coerenza con il principio di incapsulamento
4. Facilitare future modifiche alla struttura interna dei dati

## Utilizzo Corretto
```php
// Accesso raw ai colori
$rawColors = $metatag->getColors();

// Colori formattati per Filament
$filamentColors = $metatag->getFilamentColors();

// Versione semplificata dei colori
$simpleColors = $metatag->getAllColors();
```

## Metodi Disponibili

### getFilamentColors()
Restituisce i colori formattati per l'utilizzo con Filament.

### getAllColors()
Restituisce tutti i colori configurati nel formato chiave-valore.

### getLogoHeader()
**@deprecated** Usa `getBrandLogo()` per operazioni di branding.
Resituisce il percorso del logo dell'header (metodo deprecato).

### getLogoHeaderDark()
Resituisce il percorso del logo dell'header per la modalità scura.

### getBrandLogo(): string
Restituisce l'URL del logo principale per il brand, pensato per l’uso in Filament Panel.
```php
$panel->brandLogo($metatag->getBrandLogo());
```

### getFavicon()
Restituisce il percorso del favicon.

### getLogoHeight()
Restituisce l'altezza configurata per il logo.

### getBrandName(): string
Restituisce il nome del brand, che corrisponde al titolo della pagina.

## Utilizzo con Filament Panel

Per applicare i colori al panel Filament, utilizzare il metodo `getFilamentColors()` invece di accedere direttamente alla proprietà `colors`:

```php
$panel->colors($metatag->getFilamentColors())
```

## Note Importanti
- Non utilizzare direttamente la proprietà `colors`
- Utilizzare sempre i metodi getter appropriati
- I colori devono essere configurati nel formato corretto per Filament

## Collegamenti
- [Filament Theming Documentation](docs/filament/theming.md)
- [Color Management Best Practices](docs/design/colors.md)

## Proprietà
- `title`: string - Titolo della pagina
- `sitename`: string - Nome del sito
- `colors`: array - Array associativo dei colori del tema
- ... (altre proprietà)

## Metodi
### getColors(): array
Restituisce l'array raw dei colori senza alcuna trasformazione.

### getFilamentColors(): array
Restituisce i colori formattati per l'uso con Filament Panel.

### getAllColors(): array
Restituisce una versione semplificata dei colori.

### getLogoHeader(): string
**@deprecated** Usa `getBrandLogo()` per operazioni di branding.
Resituisce il percorso del logo dell'header (metodo deprecato).

### getLogoHeaderDark(): string
Resituisce il percorso del logo dell'header per il tema scuro.

### getFavicon(): string
Resituisce il percorso del favicon.

## Errori PHPStan Comuni
1. Chiamata al metodo inesistente `getColors()`
   - **Problema**: Il metodo `getColors()` non esiste
   - **Soluzione**: Utilizzare `getFilamentColors()` per i colori formattati per Filament o `getAllColors()` per i colori non formattati

## Collegamenti
- [Filament Best Practices](../FILAMENT-BEST-PRACTICES.md)
- [PHPStan Common Exceptions](../PHPSTAN-COMMON-EXCEPTIONS.md)
- [Data Queableactions](../DATA-QUEABLEACTIONS.md) 
