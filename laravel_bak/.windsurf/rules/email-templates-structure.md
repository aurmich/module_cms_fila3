# Regole per i Template Email in SaluteOra

## Struttura Corretta per Spatie/Laravel-Database-Mail-Templates

### Regole Fondamentali

1. **Mail Layouts**: La directory `/Modules/Notify/resources/mail-layouts/` deve contenere SOLO:
   - File HTML con placeholder `{{{ body }}}` (MAI file .blade.php)
   - Layout base strutturali, MAI template di contenuto completi

2. **Contenuto dei Template**: Il contenuto specifico dei template deve essere:
   - Memorizzato nel database (tabella `mail_templates`)
   - Inserito attraverso l'interfaccia amministrativa
   - MAI salvato come file nel filesystem

3. **Convenzioni di Naming**:
   - Layout: `base.html`, `base/default.html`, `themes/light.html`, etc.
   - Mai utilizzare nomi come `confirmation-template.html` o `password-reset-template.html`

### Errori Comuni da Evitare

- ❌ MAI creare template completi nella directory `/resources/mail-layouts/`
- ❌ MAI utilizzare file `.blade.php` nella directory `/resources/mail-layouts/`
- ❌ MAI includere logica o variabili Blade nei layout (eccetto `{{ $subject }}`)

### Procedure Corrette

✅ Creare solo layout base in `/resources/mail-layouts/` con placeholder `{{{ body }}}`
✅ Memorizzare i contenuti specifici nel database
✅ Utilizzare template responsive con supporto per dark mode
✅ Preferire SVG inline per le icone piuttosto che immagini esterne

### Documenti di Riferimento
- [EMAIL_LAYOUTS_BEST_PRACTICES.md](/var/www/html/saluteora/laravel/Modules/Notify/docs/mail-templates/EMAIL_LAYOUTS_BEST_PRACTICES.md)
- [SPATIE_MAIL_TEMPLATES_STRUCTURE.md](/var/www/html/saluteora/laravel/Modules/Notify/docs/mail-templates/SPATIE_MAIL_TEMPLATES_STRUCTURE.md)
