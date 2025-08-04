# Quick Reference - SaluteOra

## 🚀 **Comandi Rapidi**

```bash
# Pulire cache traduzioni
php artisan cache:clear

# Verificare sintassi file PHP
php -l file.php

# Cercare traduzioni
grep -r "saluteora::" laravel/Modules/SaluteOra/

# Verificare tutti i file di traduzione
find laravel/Modules/SaluteOra/lang -name "*.php" -exec php -l {} \;
```

## 📁 **File Importanti**

### **Traduzioni Principali**
- `laravel/Modules/SaluteOra/lang/*/states.php` - Stati paziente/dottore/appuntamento
- `laravel/Modules/SaluteOra/lang/*/widgets.php` - Traduzioni widget
- `laravel/Modules/SaluteOra/lang/*/patient.php` - Traduzioni paziente
- `laravel/Modules/SaluteOra/lang/*/doctor.php` - Traduzioni dottore
- `laravel/Modules/SaluteOra/lang/*/appointment.php` - Traduzioni appuntamento

### **Temi**
- `laravel/Themes/One/lang/*/patient_states.php` - Stati paziente Tema One
- `laravel/Themes/One/lang/*/doctor_states.php` - Stati dottore Tema One
- `laravel/Themes/Two/lang/*/patient_states.php` - Stati paziente Tema Two
- `laravel/Themes/Two/lang/*/doctor_states.php` - Stati dottore Tema Two

### **Documentazione**
- `laravel/Modules/SaluteOra/docs/translations.md` - Cronologia traduzioni
- `laravel/Modules/SaluteOra/docs/development-rules.md` - Regole sviluppo
- `laravel/Modules/SaluteOra/docs/project-memories.md` - Memorie progetto

## 🎯 **Namespace Corretti**

- **SaluteOra**: `saluteora::`
- **Xot**: `xot::`
- **User**: `user::`

## 🔧 **Template File Traduzione**

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

## 🎨 **Colori e Icone**

### **Colori Stati**
- `success` - Verde (attivo, completato)
- `warning` - Giallo (in attesa, sospeso)
- `danger` - Rosso (rifiutato, inattivo)
- `info` - Blu (informazioni, integrazione richiesta)
- `primary` - Blu scuro (dati personali)

### **Icone Comuni**
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

## 🚨 **Problemi Comuni**

### **Traduzioni non si aggiornano**
```bash
php artisan cache:clear
```

### **Filtri widget null**
```php
public function mount(array $parameters = []): void
{
    parent::mount();
    
    if (isset($parameters['model'])) {
        $this->model = $parameters['model'];
    }
}
```

### **Namespace sbagliato**
- Usare `saluteora::` non `salutemo::`

### **Sintassi PHP obsoleta**
- Usare `[]` invece di `array()`
- Includere `declare(strict_types=1);`

## 📋 **Checklist Rapida**

### **Prima di Modificare**
- [ ] Controllare documentazione esistente
- [ ] Verificare namespace corretto
- [ ] Controllare sintassi PHP

### **Dopo Modifiche**
- [ ] Verificare tutte le lingue (IT, EN, DE)
- [ ] Aggiornare documentazione
- [ ] Pulire cache se necessario

## 🔍 **Ricerca Rapida**

### **Cercare Traduzioni**
```bash
grep -r "nome_traduzione" laravel/Modules/SaluteOra/lang/
```

### **Cercare File**
```bash
find laravel/Modules/SaluteOra/ -name "*patient*" -type f
```

### **Verificare Sintassi**
```bash
find laravel/Modules/SaluteOra/lang -name "*.php" -exec php -l {} \;
```

## 📚 **Riferimenti**

- **Regole complete**: `laravel/Modules/SaluteOra/docs/development-rules.md`
- **Memorie progetto**: `laravel/Modules/SaluteOra/docs/project-memories.md`
- **Cronologia traduzioni**: `laravel/Modules/SaluteOra/docs/translations.md` 