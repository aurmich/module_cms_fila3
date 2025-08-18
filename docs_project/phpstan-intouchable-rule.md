# Regola Critica Progetto: PHPStan Configuration INTOCCABILE

## 🚨 REGOLA ASSOLUTA DEL PROGETTO 🚨

**Il file `/var/www/html/_bases/base_saluteora/laravel/phpstan.neon` è INTOCCABILE**

## Applicabilità

Questa regola si applica a:
- **Tutti gli sviluppatori** del progetto
- **Tutti gli AI assistant** (Cursor, Windsurf, etc.)
- **Tutti i tool automatici** di correzione codice
- **Qualsiasi modifica** al progetto

## Cosa È Vietato

❌ **MAI** modificare phpstan.neon per:
- Aggiungere nuove regole `ignoreErrors`
- Modificare il livello di analisi
- Escludere file o cartelle
- Cambiare configurazioni esistenti
- "Nascondere" errori PHPStan

## Cosa Fare Invece

✅ **SEMPRE** risolvere errori PHPStan modificando:
- Annotazioni PHPDoc nei modelli
- Tipi di ritorno dei metodi
- Tipizzazione dei parametri
- Logica del codice
- Struttura delle classi

## Motivazione

La configurazione PHPStan è stata ottimizzata per:
1. **Garantire qualità del codice** al massimo livello
2. **Prevenire errori** in produzione
3. **Mantenere standard** elevati nel progetto
4. **Evitare debito tecnico** nascosto

## Esempi di Correzioni Corrette

### Errori Relazioni Eloquent
```php
// ❌ SBAGLIATO: Aggiungere ignore in phpstan.neon
// ✅ CORRETTO: Usare 'self' nelle annotazioni
/**
 * @return BelongsTo<User, self>
 */
public function user(): BelongsTo
```

### Errori di Tipizzazione
```php
// ❌ SBAGLIATO: Ignorare l'errore
// ✅ CORRETTO: Aggiungere tipi espliciti
public function process(Collection $data): array
```

## Processo di Escalation

Se un errore PHPStan sembra irrisolvibile:

1. **Rianalizzare** approfonditamente il problema
2. **Consultare** documentazione Laravel/PHPStan
3. **Cercare** soluzioni alternative nel codice
4. **Documentare** nelle cartelle docs del modulo
5. **Chiedere supporto** al team
6. **MAI** modificare phpstan.neon

## Conseguenze della Violazione

Modificare phpstan.neon comporta:
- 🚫 **Degradazione qualità codice**
- 🚫 **Mascheramento errori reali**
- 🚫 **Debito tecnico nascosto**
- 🚫 **Inconsistenza progetto**
- 🚫 **Problemi in produzione**

## Monitoraggio

Questa regola è monitorata tramite:
- Git hooks pre-commit
- Review del codice obbligatorie
- CI/CD pipeline checks
- Documentazione aggiornata

## Collegamenti Documentazione

- [Xot - PHPStan Critical Rules](laravel/Modules/Xot/docs/phpstan-critical-rules.md)
- [SaluteOra - PHPStan Fixes](laravel/Modules/SaluteOra/docs/phpstan-relationship-covariance-fix.md)
- [Best Practices Relazioni](laravel/Modules/Xot/docs/phpstan-relationship-best-practices.md)

---

**Priorità**: 🚨 MASSIMA  
**Violazioni**: 🚫 ZERO TOLLERANZA  
**Stato**: ✅ REGOLA ATTIVA  
**Validità**: ♾️ PERMANENTE
