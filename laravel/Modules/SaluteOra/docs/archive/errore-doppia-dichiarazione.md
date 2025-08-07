# Errore di Doppia Dichiarazione dei Metodi nei Modelli

## Problema

L'errore "syntax error, unexpected token 'public', expecting ';' or '{'" si verifica quando c'è una dichiarazione duplicata di un metodo in una classe, con firme diverse o con definizioni parziali.

## Cause Specifiche

In questo caso, nel modello `Studio` è stata riscontrata una doppia dichiarazione del metodo `addresses()` con due possibili cause:

1. **Dichiarazione duplicata con tipi di ritorno differenti**:
   ```php
   // Prima dichiarazione con tipo di ritorno specifico
   public function addresses(): MorphMany
   
   // Seconda dichiarazione senza tipo di ritorno specifico
   public function addresses()
   ```

2. **Errore di merge o refactoring**:
   Potrebbe essere stato il risultato di un merge errato tra branch diversi o di un refactoring incompleto.

## Soluzione

La soluzione consiste nel mantenere una sola dichiarazione del metodo con la firma corretta:

```php
/**
 * Ottiene gli indirizzi associati allo studio.
 * 
 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
 */
public function addresses(): MorphMany
{
    return $this->morphMany(\Modules\Geo\Models\Address::class, 'model');
}
```

## Prevenzione

Per evitare errori simili in futuro:

1. **Controllo dell'IDE**: Utilizzare strumenti di analisi statica che possono identificare metodi duplicati
2. **Code Review**: Implementare revisioni di codice più rigorose prima del merge
3. **Test automatici**: Eseguire test di compilazione/linting prima del deploy
4. **Documentazione esaustiva**: Documentare accuratamente lo scopo e l'utilizzo di ogni relazione

## Impatto dell'Errore

Questo tipo di errore è particolarmente critico perché:

1. Causa un crash dell'applicazione con errore 500
2. Impedisce il caricamento dell'interfaccia di amministrazione
3. Blocca l'accesso a funzionalità critiche del sistema

## Riferimenti

- [PHP Manual: Methods](https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.methods)
- [Laravel Eloquent: Relationships](https://laravel.com/docs/10.x/eloquent-relationships)
- [Modules\SaluteOra\Models\Studio](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Models/Studio.php)
- [Modules\Geo\Models\Address](/var/www/html/_bases/base_saluteora/laravel/Modules/Geo/app/Models/Address.php)
