# Convenzione di Naming per le Interfacce

## Regola Fondamentale

In SaluteOra, tutte le interfacce **DEVONO** utilizzare il suffisso `Contract` e **MAI** il suffisso `Interface`.

## Esempi Corretti e Incorretti

```php
// ✅ CORRETTO
interface SmsActionContract
interface WhatsAppProviderActionContract
interface TelegramProviderActionContract

// ❌ ERRATO
interface SmsActionInterface
interface WhatsAppProviderActionInterface
interface TelegramProviderActionInterface
```

## Motivazione

1. **Coerenza con Laravel**: Il framework Laravel utilizza il suffisso `Contract` per le sue interfacce.
2. **Chiarezza semantica**: Il termine "Contract" esprime meglio il concetto di un "contratto" che le classi implementatrici devono rispettare.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli SaluteOra.

## Verifica

Verifica sempre che le interfacce seguano questa convenzione prima di crearle o modificarle.
