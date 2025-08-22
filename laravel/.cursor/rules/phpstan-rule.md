# REGOLA CRITICA CURSOR: NON MODIFICARE PHPSTAN.NEON

## ⚠️ REGOLA ASSOLUTA - MEMORIZZA PERMANENTEMENTE ⚠️

**File**: `/var/www/html/_bases/base_saluteora/laravel/phpstan.neon`  
**Stato**: **INTOCCABILE - NON MODIFICARE MAI**

## Istruzioni per Cursor AI

Quando incontri errori PHPStan:

1. ✅ **SEMPRE**: Migliorare il codice per superare i controlli
2. ❌ **MAI**: Modificare, commentare o ignorare regole in phpstan.neon
3. ✅ **SEMPRE**: Aggiungere type hints espliciti
4. ✅ **SEMPRE**: Utilizzare generics per Collection
5. ✅ **SEMPRE**: Evitare `mixed` quando possibile

## Pattern di Correzione

### Type Hints Mancanti
```php
// ❌ Errore PHPStan: Missing return type
public function getUser()
{
    return User::find(1);
}

// ✅ Correzione: Aggiungere type hint
public function getUser(): ?User
{
    return User::find(1);
}
```

### Collection Non Tipizzate
```php
// ❌ Errore PHPStan: Generic type missing
/** @var Collection $users */
$users = User::all();

// ✅ Correzione: Aggiungere generic
/** @var Collection<int, User> $users */
$users = User::all();
```

### Relazioni Eloquent
```php
// ❌ Errore PHPStan: Missing relationship type
public function posts()
{
    return $this->hasMany(Post::class);
}

// ✅ Correzione: Aggiungere type hint completo
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post>
 */
public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(Post::class);
}
```

## Filosofia del Progetto

- **Quality First**: La qualità del codice è prioritaria
- **Type Safety**: Sempre utilizzare tipi espliciti
- **No Shortcuts**: Non prendere scorciatoie che compromettono la qualità
- **Continuous Improvement**: Ogni errore PHPStan è un'opportunità di miglioramento

## Memoria Permanente

Questa regola deve essere ricordata in ogni sessione di Cursor:
- Non suggerire MAI modifiche a phpstan.neon
- Sempre proporre miglioramenti al codice invece di modifiche alla configurazione
- Utilizzare questa regola come guida per tutte le correzioni PHPStan

## Collegamenti Interni

- [Documentazione completa](../docs/phpstan-critical-rule.md)
- [Linee guida AI](.ai/guidelines/phpstan-configuration-rule.md)
- [Regole Windsurf](../.windsurf/rules/phpstan-rule.mdc)

---

**IMPORTANTE**: Questa regola è CRITICA per il progetto SaluteOra. Deve essere rispettata SEMPRE.

*Memorizzato permanentemente: Gennaio 2025*

