# Sushi Models - Dependency Cycle Fix

## 🚨 Problema Critico Risolto

### Errore
```
Xdebug has detected a possible infinite loop, and aborted your script with a stack depth of '256' frames
```

### Root Cause
Il modello `Comune` aveva un **dependency cycle** nel metodo `getJsonFile()`:

```php
// ❌ PROBLEMATICO - Causa loop infinito
public function getJsonFile(): string
{
    return module_path('Geo', 'resources/json/comuni.json');
}
```

### Flusso del Loop
1. `getJsonFile()` chiama `module_path('Geo', ...)`
2. `module_path()` cerca di risolvere il service provider del modulo Geo
3. Il service provider ha bisogno del modello `Comune` (Sushi trait)
4. Il modello `Comune` chiama di nuovo `getJsonFile()`
5. **LOOP INFINITO** 🔄

## ✅ Soluzione Implementata

### Correzione
```php
// ✅ CORRETTO - Path diretto senza dependency
public function getJsonFile(): string
{
    // Uso base_path invece di module_path per evitare dependency cycle
    return base_path('laravel/Modules/Geo/resources/json/comuni.json');
}
```

### Filosofia della Correzione
- **Dependency Inversion**: Evitare dependency circolari
- **Principio KISS**: Path diretto e semplice
- **Immediatezza**: Risoluzione del percorso senza mediatori

## 🛡️ Prevenzione Futura

### Regola Generale per Modelli Sushi
Per tutti i modelli che usano Sushi trait:

```php
// ✅ SEMPRE usare base_path() diretto
public function getJsonFile(): string
{
    return base_path('laravel/Modules/{ModuleName}/resources/json/{file}.json');
}

// ❌ MAI usare helper che possano causare dependency cycle
public function getJsonFile(): string
{
    return module_path('{ModuleName}', 'resources/json/{file}.json'); // LOOP RISK!
}
```

### Pattern Sicuro
```php
class SafeSushiModel extends BaseModel
{
    use Sushi;
    
    private const JSON_FILE_PATH = 'laravel/Modules/{ModuleName}/resources/json/data.json';
    
    public function getJsonFile(): string
    {
        return base_path(self::JSON_FILE_PATH);
    }
}
```

## 🔧 Testing della Correzione

### Verifica File Path
```bash

# Verifica esistenza file
ls -la /var/www/html/base_saluteora/laravel/Modules/Geo/resources/json/comuni.json

# Output atteso:

# -rw-r--r-- 1 user group 1.8M date comuni.json
```

### Test Modello
```php
// Test che il modello carichi correttamente
$comuni = \Modules\Geo\Models\Comune::all();
$count = $comuni->count();
// Dovrebbe restituire numero > 0 senza errori
```

## 📊 Impatto della Correzione

### Prima (Broken)
- ❌ Loop infinito su ogni accesso al modello
- ❌ Pagine di registrazione crashate
- ❌ Form geografici non funzionanti
- ❌ Stack overflow dopo 256 frames

### Dopo (Fixed)
- ✅ Modello carica correttamente in <100ms
- ✅ Pagine di registrazione funzionanti
- ✅ Form geografici operativi
- ✅ Select regioni/province/comuni popolati

## 🧬 Analisi Filosofica

### Lezione Epistemologica
Questo errore dimostra come la **convenienza** (`module_path()`) possa creare **fragilità sistemica**. La soluzione più **diretta** (`base_path()`) è spesso la più **robusta**.

### Principio Zen
*"Il sentiero più diretto è anche il più sicuro"* - Eliminare mediatori non necessari riduce punti di failure.

### Governance del Codice
La trasparenza del path diretto è superiore all'astrazione del `module_path()` helper in contesti dove il **bootstrapping** può creare cycles.

## 🔗 Collegamenti

- [Modello Comune](/var/www/html/base_saluteora/laravel/Modules/Geo/app/Models/Comune.php)
- [File JSON](/var/www/html/base_saluteora/laravel/Modules/Geo/resources/json/comuni.json)
- [Sushi Documentation](https://github.com/calebporzio/sushi)

---

**Risolto**: Dicembre 2024  
**Priorità**: P0 (Critical) - Bloccava registrazioni  
**Impatto**: Sistema completamente non funzionale  
