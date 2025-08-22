# Factory PHPStan Fixes Summary

## Panoramica

Risoluzione completa degli errori PHPStan nelle factory dei moduli SaluteOra e Geo, con implementazione di type safety e best practices per Laravel Factories.

## Problemi Risolti

### 1. NotificationFactory (SaluteOra)
- **Problema**: Modello `Modules\SaluteOra\Models\Notification` non esistente
- **Soluzione**: Riferimento corretto a `Modules\Notify\Models\Notification`
- **Status**: ✅ Risolto (file poi eliminato dall'utente)

### 2. Factory Geo Module
- **Problema**: Errori "Cannot access offset on mixed" 
- **Soluzione**: Tipizzazione esplicita con PHPDoc array shapes
- **Status**: ✅ Risolto completamente

### 3. Metodi factory() Mancanti
- **Problema**: `Region::factory()` e `Province::factory()` non disponibili
- **Soluzione**: Aggiunto trait `HasFactory` e creato `RegionFactory`
- **Status**: ✅ Implementato

## Tecniche di Risoluzione

### Tipizzazione Array con PHPDoc
```php
/** @var array{nome: string, regione: string, provincia: string, cap: string, lat: float, lng: float} $comuneData */
$comuneData = $this->faker->randomElement($comuniReali);
```

### Factory Pattern Completo
- Creazione di factory per tutti i modelli geografici
- Implementazione di stati specifici (northern, central, southern)
- Metodi helper per casi d'uso comuni

### Trait HasFactory
Aggiunto a tutti i modelli per supporto factory completo:
- `Region` 
- `Province`
- `Comune`

## Benefici Ottenuti

1. **Type Safety**: Eliminati tutti gli errori di accesso offset su mixed
2. **Testing**: Factory complete per testing e seeding realistici
3. **Manutenibilità**: Codice più robusto e facilmente estendibile
4. **PHPStan Compliance**: Livello 10 compatibile

## File Interessati

### Modulo Geo
- ✅ `ComuneFactory.php` - Ricreato con tipizzazione
- ✅ `ProvinceFactory.php` - Ricreato con tipizzazione  
- ✅ `RegionFactory.php` - Nuovo
- ✅ Modelli con trait `HasFactory`

### Modulo SaluteOra  
- ✅ `NotificationFactory.php` - Corretto (poi eliminato)

## Collegamenti Documentazione

- [Factory PHPStan Fixes - SaluteOra](../laravel/Modules/SaluteOra/docs/factory-phpstan-fixes.md)
- [Factory PHPStan Fixes - Geo](../laravel/Modules/Geo/docs/factory-phpstan-fixes.md)
- [PHPStan Best Practices](./phpstan-best-practices.md)
- [Laravel Factory Guidelines](./laravel-factory-guidelines.md)

## Raccomandazioni Future

1. Utilizzare sempre tipizzazione esplicita negli array delle factory
2. Implementare trait `HasFactory` per tutti i nuovi modelli
3. Creare stati specifici nelle factory per casi d'uso comuni
4. Mantenere dati realistici nelle factory per testing significativi

*Ultimo aggiornamento: 2025-01-06*
