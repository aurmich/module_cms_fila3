# REGOLA CRITICA ASSOLUTA: NON MODIFICARE PHPSTAN.NEON

## ⚠️ REGOLA INVIOLABILE ⚠️

**IL FILE `phpstan.neon` NON DEVE MAI ESSERE MODIFICATO**

### Percorso del file
```
/var/www/html/_bases/base_saluteora/laravel/phpstan.neon
```

### Motivazione
- È una configurazione critica del progetto SaluteOra
- Rappresenta il livello di qualità del codice che DEVE essere mantenuto
- Modificarlo significa abbassare gli standard di qualità
- La filosofia del progetto è: **migliorare il codice per superare i controlli, NON abbassare i controlli**

### Cosa fare invece
1. **Migliorare il codice** per superare i controlli PHPStan
2. **Aggiungere type hints** espliciti e specifici
3. **Utilizzare union types** quando necessario
4. **Implementare generics** per le collection
5. **Evitare `mixed`** quando possibile
6. **Scrivere PHPDoc completi** con tipi corretti

### Filosofia del progetto
- **Qualità del codice**: Il codice deve essere scritto per superare il massimo livello di controllo statico
- **Type safety**: Utilizzare sempre tipi espliciti e specifici
- **Manutenibilità**: Codice ben tipizzato è più facile da mantenere
- **Prevenzione bug**: PHPStan rileva errori prima che arrivino in produzione

### Esempi di miglioramento codice
```php
// ❌ ERRATO - Abbassare PHPStan
// Modificare phpstan.neon per ignorare errori

// ✅ CORRETTO - Migliorare il codice
/**
 * @return Collection<int, User>
 */
public function getActiveUsers(): Collection
{
    return User::where('active', true)->get();
}
```

### Conseguenze della violazione
- Perdita di qualità del codice
- Introduzione di bug potenziali
- Inconsistenza con la filosofia del progetto
- Difficoltà nella manutenzione futura

### Eccezioni
**NON CI SONO ECCEZIONI** - Questa regola è assoluta e inviolabile.

---

**Ultima revisione**: Gennaio 2025  
**Stato**: REGOLA CRITICA ATTIVA  
**Applicabilità**: TUTTI gli sviluppatori del progetto SaluteOra

