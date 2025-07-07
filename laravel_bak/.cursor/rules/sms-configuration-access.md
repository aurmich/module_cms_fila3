# Pattern di Accesso alla Configurazione SMS

## Regola Fondamentale

**Le azioni SMS devono SEMPRE recuperare la configurazione dal file `config/sms.php` e MAI da `config('services')`.**

## Pattern Corretto

### Configurazioni specifiche per provider

```php
// ✅ CORRETTO
$token = config('sms.drivers.netfun.token');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// ❌ ERRATO
$token = config('services.netfun.token');
```

### Configurazioni globali

```php
// ✅ CORRETTO
$defaultSender = config('sms.from');
$debug = (bool) config('sms.debug', false);
$timeout = (int) config('sms.timeout', 30);
```

## Motivazione

1. **Coerenza**: Tutte le configurazioni relative agli SMS devono provenire dal file `config/sms.php`
2. **Modularità**: Ogni modulo gestisce le proprie configurazioni
3. **Manutenibilità**: Facilita la manutenzione avendo un'unica fonte di verità per le configurazioni
4. **Standardizzazione**: Segue la struttura standardizzata documentata

## Errori Comuni da Evitare

1. Utilizzare `config('services.*')` per configurazioni SMS
2. Hardcodare valori che dovrebbero essere configurabili
3. Mescolare configurazioni da diverse fonti
4. Non fornire valori predefiniti per parametri opzionali

## Documentazione di Riferimento

- `/Modules/Notify/docs/SMS_CONFIGURATION_ACCESS_PATTERN.md`
- `/Modules/Notify/docs/SMS_CONFIG_STRUCTURE.md`
- `/Modules/Notify/docs/NETFUN_CONFIG_REQUIREMENTS.md`
