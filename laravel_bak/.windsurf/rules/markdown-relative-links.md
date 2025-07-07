# Regola per i Collegamenti Relativi nei File Markdown

## Regola Fondamentale

In SaluteOra, **tutti i collegamenti nei file Markdown devono utilizzare percorsi relativi** e non percorsi assoluti.

## Esempi Corretti e Incorretti

### ❌ ERRATO: Percorsi Assoluti

```markdown
[Convenzioni di Naming](/var/www/html/saluteora/laravel/Modules/Notify/docs/NAMING_CONVENTIONS.md)
```

### ✅ CORRETTO: Percorsi Relativi

```markdown
[Convenzioni di Naming](./NAMING_CONVENTIONS.md)
```

Per collegamenti a documenti in altre directory:

```markdown
[Regole Generali](../../Lang/docs/RULES.md)
```

## Motivazione

1. **Portabilità**: I percorsi relativi funzionano indipendentemente dalla posizione di installazione
2. **Compatibilità**: I percorsi assoluti potrebbero non funzionare in ambienti diversi
3. **Manutenibilità**: I percorsi relativi sono più facili da mantenere quando la struttura cambia
4. **Standard del progetto**: SaluteOra richiede percorsi relativi in tutti i documenti Markdown

## Regole per i Collegamenti Relativi

1. **File nella stessa directory**: `./nome-file.md`
2. **File in una sottodirectory**: `./sottodirectory/nome-file.md`
3. **File in una directory superiore**: `../nome-file.md`
4. **File in una directory parallela**: `../directory-parallela/nome-file.md`
