# Regole di Sviluppo - Progetto SaluteOra

## 🎯 **Regole Fondamentali**

### **1. Traduzioni e Localizzazione**
- **Sempre usare `declare(strict_types=1);`** all'inizio di tutti i file PHP di traduzione
- **Sintassi PHP moderna**: Usare `[]` invece di `array()` in tutti i file di traduzione
- **Namespace corretto**: Usare `saluteora::` non `salutemo::` per le traduzioni del modulo SaluteOra
- **Struttura completa**: Ogni traduzione deve avere tutte le proprietà necessarie (label, description, icon, color, help)
- **Consistenza**: Mantenere la stessa struttura tra IT, EN, DE per tutti i file di traduzione

### **2. Struttura File di Traduzione**
```php
<?php

declare(strict_types=1);

return [
    'section' => [
        'key' => [
            'label' => 'Traduzione',
            'description' => 'Descrizione completa',
            'icon' => 'heroicon-o-icon-name',
            'color' => 'success|warning|danger|info|primary',
            'help' => 'Testo di aiuto',
            'tooltip' => 'Tooltip informativo',
            'placeholder' => 'Testo placeholder',
            'helper_text' => 'Testo di supporto',
            'validation' => [
                'required' => 'Messaggio errore',
                'min' => 'Messaggio errore',
                'max' => 'Messaggio errore',
            ],
        ],
    ],
];
```

### **3. Stati e Widget**
- **Stati paziente/dottore**: Sempre presenti in `laravel/Modules/SaluteOra/lang/*/states.php`
- **Widget**: Traduzioni in `laravel/Modules/SaluteOra/lang/*/widgets.php`
- **Stati completi**: Includere sempre `active`, `integration_requested`, `integration_completed`
- **Widget comuni**: `user_type_registrations_chart`, `states_chart`, `creation_chart`, `trend_chart`

### **4. Documentazione**
- **Sempre aggiornare** `laravel/Modules/SaluteOra/docs/translations.md` dopo ogni modifica
- **Non toccare** la cartella `docs` della root del progetto (solo quella del modulo)
- **Documentare ogni correzione** con dettagli, diff e spiegazioni
- **Mantenere cronologia** delle modifiche aggiornata

## 🔧 **Problemi Comuni e Soluzioni**

### **1. Filtri Widget Filament**
- **Problema**: `$this->filters` è null nel widget
- **Causa**: Widget non ha metodo `mount()` per gestire parametri
- **Soluzione**: Aggiungere metodo `mount(array $parameters = [])` nel widget
- **Esempio**:
```php
public function mount(array $parameters = []): void
{
    parent::mount();
    
    if (isset($parameters['model'])) {
        $this->model = $parameters['model'];
    }
}
```

### **2. Traduzioni Mancanti**
- **Verificare sempre** cache: `php artisan cache:clear`
- **Controllare namespace**: `saluteora::` non `salutemo::`
- **Verificare caricamento** file di traduzione nel ServiceProvider

### **3. Sintassi PHP**
- **Sempre usare** sintassi breve `[]` invece di `array()`
- **Sempre includere** `declare(strict_types=1);`
- **Mantenere** indentazione consistente (4 spazi)

## 📁 **Struttura Progetto**

### **Moduli Principali**
- `laravel/Modules/SaluteOra/` - Modulo principale SaluteOra
- `laravel/Modules/Xot/` - Modulo base con funzionalità comuni
- `laravel/Modules/User/` - Gestione utenti
- `laravel/Modules/SaluteMo/` - Dashboard e widget

### **Temi**
- `laravel/Themes/One/` - Tema One
- `laravel/Themes/Two/` - Tema Two
- **Ogni tema ha** le proprie traduzioni in `lang/`

### **File di Traduzione Importanti**
- `laravel/Modules/SaluteOra/lang/*/states.php` - Stati paziente/dottore/appuntamento
- `laravel/Modules/SaluteOra/lang/*/widgets.php` - Traduzioni widget
- `laravel/Modules/SaluteOra/lang/*/patient.php` - Traduzioni paziente
- `laravel/Modules/SaluteOra/lang/*/doctor.php` - Traduzioni dottore
- `laravel/Modules/SaluteOra/lang/*/appointment.php` - Traduzioni appuntamento

## 🎨 **Convenzioni UI/UX**

### **Colori Stati**
- `success` - Verde (attivo, completato)
- `warning` - Giallo (in attesa, sospeso)
- `danger` - Rosso (rifiutato, inattivo)
- `info` - Blu (informazioni, integrazione richiesta)
- `primary` - Blu scuro (dati personali)

### **Icone Heroicon**
- `heroicon-o-check-circle` - Completato/Attivo
- `heroicon-o-clock` - In attesa
- `heroicon-o-x-circle` - Rifiutato/Inattivo
- `heroicon-o-document-plus` - Integrazione richiesta
- `heroicon-o-document-check` - Integrazione completata
- `heroicon-o-pause` - Sospeso
- `heroicon-o-identification` - Dati personali
- `heroicon-o-phone` - Contatti
- `heroicon-o-document-text` - Documenti
- `heroicon-o-clipboard-document-list` - Pre-visita
- `heroicon-o-heart` - Salute
- `heroicon-o-shield-check` - Privacy

## 🚀 **Workflow di Sviluppo**

### **1. Analisi**
- Studiare sempre la documentazione esistente
- Controllare file di traduzione esistenti
- Verificare struttura e convenzioni

### **2. Implementazione**
- Seguire le convenzioni stabilite
- Usare sintassi PHP moderna
- Mantenere consistenza tra lingue

### **3. Verifica**
- Controllare tutte le lingue (IT, EN, DE)
- Verificare sintassi PHP
- Testare funzionalità

### **4. Documentazione**
- Aggiornare `translations.md`
- Documentare modifiche e correzioni
- Mantenere cronologia aggiornata

## ⚠️ **Errori da Evitare**

1. **Non usare** `array()` invece di `[]`
2. **Non dimenticare** `declare(strict_types=1);`
3. **Non mescolare** lingue nei file di traduzione
4. **Non modificare** la cartella `docs` della root
5. **Non dimenticare** di aggiornare la documentazione
6. **Non usare** namespace sbagliati (`salutemo::` invece di `saluteora::`)

## 🔍 **Comandi Utili**

```bash

# Pulire cache traduzioni
php artisan cache:clear

# Verificare sintassi PHP
php -l file.php

# Cercare traduzioni
grep -r "saluteora::" laravel/Modules/SaluteOra/

# Verificare file di traduzione
find laravel/Modules/SaluteOra/lang -name "*.php" -exec php -l {} \;
```

## 📚 **Riferimenti**

- **Documentazione traduzioni**: `laravel/Modules/SaluteOra/docs/translations.md`
- **Best practices Filament**: `laravel/Modules/Xot/docs/filament_best_practices.md`
