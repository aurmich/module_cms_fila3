# Standard per helper_text nelle Traduzioni SaluteOra

## Regola Critica: Gestione helper_text

### Principio Fondamentale
Quando `helper_text` è uguale alla chiave dell'array, **DEVE** essere impostato a stringa vuota (`''`).

### Motivazione
- **Evitare duplicazione**: Non mostrare lo stesso testo due volte
- **Coerenza UX**: Mantenere interfacce pulite e professionali
- **Best Practice**: Seguire standard di design moderni

## Pattern di Implementazione

### ✅ CORRETTO
```php
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci il tuo indirizzo',
    'help' => 'Indica l\'indirizzo di residenza o domicilio',
    'description' => 'Indirizzo completo dell\'utente',
    'helper_text' => '', // Vuoto perché diverso da 'address'
],
'phone' => [
    'label' => 'Telefono',
    'placeholder' => 'Inserisci il numero di telefono',
    'help' => 'Numero di telefono per contatti',
    'description' => 'Numero di telefono principale',
    'helper_text' => '', // Vuoto perché diverso da 'phone'
],
```

### ❌ ERRATO
```php
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci il tuo indirizzo',
    'helper_text' => 'address', // ERRORE: uguale alla chiave
],
'phone' => [
    'label' => 'Telefono',
    'helper_text' => 'phone', // ERRORE: uguale alla chiave
],
```

## Regole di Applicazione

### 1. Controllo Obbligatorio
- **SE** `helper_text` = chiave dell'array → impostare `helper_text = ''`
- **SE** ci sono `label` e `placeholder` → **DEVE** esserci `helper_text`

### 2. Coerenza Multilingua
- Applicare la stessa logica in tutte le lingue (it, en, de)
- Mantenere struttura identica tra le versioni

### 3. Struttura Completa
Ogni campo deve avere:
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder',
    'help' => 'Testo di aiuto',
    'description' => 'Descrizione',
    'helper_text' => '', // Vuoto se uguale alla chiave
],
```

## Checklist di Validazione

Prima di considerare completo un file di traduzione:

- [ ] Nessun `helper_text` uguale alla chiave dell'array
- [ ] Tutti i campi con `label` e `placeholder` hanno `helper_text`
- [ ] Struttura coerente tra tutte le lingue
- [ ] `helper_text` vuoto (`''`) quando appropriato
- [ ] Testi di aiuto significativi e diversi da label/placeholder

## Esempi di Correzione

### Prima (Errato)
```php
'email' => [
    'description' => 'email',
],
'last_name' => [
    'description' => 'last_name',
    'helper_text' => 'last_name',
    'placeholder' => 'last_name',
    'label' => 'last_name',
],
```

### Dopo (Corretto)
```php
'email' => [
    'label' => 'Email',
    'placeholder' => 'Inserisci l\'indirizzo email',
    'help' => 'L\'email verrà utilizzata per comunicazioni e accesso',
    'description' => 'Indirizzo email associato al profilo',
    'helper_text' => '',
],
'last_name' => [
    'label' => 'Cognome',
    'placeholder' => 'Inserisci il cognome',
    'help' => 'Il tuo cognome anagrafico',
    'description' => 'Cognome dell\'utente',
    'helper_text' => '',
],
```

## Applicazione Globale

Questa regola si applica a:
- `Modules/*/lang/*/` - Tutti i moduli
- `Themes/*/lang/*/` - Tutti i temi
- Qualsiasi file di traduzione del progetto SaluteOra

## Collegamenti

- [Regole Generali Traduzioni](translation_standards_links.md)
- [Documentazione Modulo Lang](../../laravel/Modules/Lang/docs/)
- [Best Practices Filament](../../laravel/Modules/Xot/docs/filament/)

*Ultimo aggiornamento: 2025-01-06* 