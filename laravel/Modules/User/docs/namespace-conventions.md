# Convenzioni di Namespace per Filament nel Modulo User

> **Regola fondamentale:** Il namespace dei componenti Filament è sempre `Modules\User\Filament`, anche se i file si trovano fisicamente in `app/Filament`. **Non va mai aggiunto `App` nel namespace.**

## Struttura Corretta

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Resources;
// oppure
namespace Modules\User\Filament\Widgets;
```

## Struttura Errata

```php
// ❌ ERRATO
namespace Modules\User\App\Filament\Resources;
// oppure
namespace Modules\User\App\Filament\Widgets;
```

## Motivazione

Questa convenzione garantisce coerenza tra tutti i moduli e semplifica l'autoloading e la risoluzione delle classi. Anche se i file sono fisicamente collocati in `app/Filament`, il namespace deve sempre essere `Modules\User\Filament` per mantenere la coerenza con l'architettura modulare.

## Esempi Pratici

### Widget di Autenticazione

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets\Auth;

class LoginWidget extends Widget
{
    // ...
}
```

### Resource Utente

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Resources;

class UserResource extends Resource
{
    // ...
}
```

## Collegamenti Bidirezionali

- [Convenzioni Namespace Filament](../../Cms/docs/convenzioni-namespace-filament.md) - Regole generali per i namespace Filament
- [Regole Generali Xot](../../Xot/docs/README.md) - Best practice e linee guida generali

---

### Nota Importante
Quando crei nuovi componenti Filament, assicurati sempre di:
1. Utilizzare il namespace corretto `Modules\User\Filament`
2. NON includere `App` nel namespace
3. Seguire le convenzioni di naming e struttura del modulo

## Collegamenti tra versioni di namespace-conventions.md
* [namespace-conventions.md](../../../Xot/docs/namespace-conventions.md)
* [namespace-conventions.md](../../../User/docs/namespace-conventions.md)
* [namespace-conventions.md](../../../Cms/docs/best-practices/namespace-conventions.md)

