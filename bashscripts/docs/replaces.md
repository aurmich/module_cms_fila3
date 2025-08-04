<<<<<<< HEAD
---
# 📄 Refactoring Regex Laravel Filament

> **Revisione manuale:** Questo file è stato rivisto per eliminare conflitti, duplicazioni e marker. Le regex sono pensate per il refactoring automatico di risorse Filament, in particolare per la conversione tra metodi `form`, `table` e `getFormSchema` in ottica PHPStan livello 10.

> **Backlink:** [README globale](./README.md) · [Risoluzione conflitti PHP](./git_conflicts_resolution.md)

---

## Obiettivo

Fornire regex e spiegazioni per automatizzare il refactoring delle risorse Filament, sostituendo metodi legacy con versioni più tipizzate e compatibili con PHPStan.

## Regex principali

### Da:
```php
public static function form(Form $form): Form {
    return $form->schema([
        ...
    ]);
}
```
### A:
```php
public static function getFormSchema(): array {
    return [
        ...
    ];
}
```
**Regex sostitutiva:**
```regex
public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}
```
→
```php
public static function getFormSchema(): array {
    return [
        $1
    ];
}
```

---

## Altri pattern utili

- Conversione analoga per il metodo `table`:
```regex
public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}
```

## Note architetturali
- Tutti i refactoring devono garantire tipizzazione completa e compatibilità con PHPStan livello 10.
- Queste regex sono pensate per essere usate in batch su risorse Filament legacy.

## Collegamenti
- [README globale](./README.md)
- [Risoluzione conflitti PHP](./git_conflicts_resolution.md)
- [scripts_conflict_resolution.md](./scripts_conflict_resolution.md)

---

> Ogni modifica va sempre verificata manualmente e testata con PHPStan livello 10. Segnalare eventuali casi limite in [git_conflicts_resolution.md](./git_conflicts_resolution.md).
=======


public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}



public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}



public static function getFormSchema(): array
>>>>>>> 22b41c7f (.)
    {
        return [
            $1
        ]; 
    }

---------------------------------------------


public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}
<<<<<<< HEAD
### Versione HEAD


### Versione Incoming
=======

 0440c57 (.)

public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}



 43df3e0 (.)
public static function getFormSchema(): array
    {
        return [
            $1
        ]; 
    }

---------------------------------------------


public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}


public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}

[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco HEAD (16 linee vs 1)[0m

 cb513be (.)
public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}



public static function getFormSchema(): array
    {
        return [
            $1
        ]; 
    }

---------------------------------------------


public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}
>>>>>>> 22b41c7f (.)


[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco incoming (1 linee vs 1)[0m

<<<<<<< HEAD
---

=======

 cb513be (.)
 43df3e0 (.)


 cb513be (.)
 0440c57 (.)
>>>>>>> 22b41c7f (.)
