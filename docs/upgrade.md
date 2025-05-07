---
title: Aggiornamenti
description: Aggiornamenti
extends: _layouts.documentation
section: content
---

# Aggiornamenti {#aggiornamenti}

Cms onsiste in un pacchetto PHP.

Quindi per aggiornare basta dare il comando in console:

composer update laraxot/module_cms

Assicurarsi di cancellare la cache delle viste di Laravel dopo l'aggiornamento:

```console
php artisan view:clear
```

Infine, se si sono pubblicati il file di configurazione o i modelli Blade, assicurarsi che le personalizzazioni siano aggiornate con i valori predefiniti.

### Verifica dei pacchetti installati

È possibile utilizzare il comando Artisan incorporato per visualizzare le versioni installate dei pacchetti:

```console
php artisan module_cms:show-versions
<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)
```
## Collegamenti tra versioni di upgrade.md
* [upgrade.md](laravel/Modules/Lang/docs/upgrade.md)
* [upgrade.md](laravel/Modules/Cms/docs/upgrade.md)

<<<<<<< HEAD
=======
```
>>>>>>> feb96d7 (.)
=======

### Versione Alternativa

```

---

>>>>>>> f1c9277 (.)
