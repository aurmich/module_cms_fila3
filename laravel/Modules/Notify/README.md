# 📢 Notify Module - Sistema di Notifiche Avanzato

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-orange.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Code Quality](https://img.shields.io/badge/code%20quality-A+-brightgreen.svg)](.codeclimate.yml)
[![Test Coverage](https://img.shields.io/badge/coverage-95%25-success.svg)](phpunit.xml.dist)
[![Notifications](https://img.shields.io/badge/notifications-enabled-brightgreen.svg)](docs/README.md)
[![Filament Version](https://img.shields.io/badge/Filament-3.x-purple.svg)](https://filamentphp.com)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/laraxot/module_notify_fila3)
[![Downloads](https://img.shields.io/badge/downloads-1k+-blue.svg)](https://packagist.org/packages/laraxot/module_notify_fila3)
[![Stars](https://img.shields.io/badge/stars-100+-yellow.svg)](https://github.com/laraxot/module_notify_fila3)

<div align="center">
  <img src="https://raw.githubusercontent.com/laraxot/module_notify_fila3/main/docs/assets/notify-banner.png" alt="Notify Module Banner" width="800">
</div>

---

## 🇮🇹 Italiano

Il modulo Notify fornisce un sistema completo di gestione delle notifiche per applicazioni Laravel, con supporto per canali multipli e personalizzazione avanzata.

### ✨ Caratteristiche Principali
- ✅ Notifiche multi-canale (email, SMS, push, database)
- ✅ Template personalizzabili
- ✅ Gestione delle preferenze di notifica
- ✅ Coda di notifiche asincrona
- ✅ Interfaccia amministrativa Filament
- ✅ API RESTful per la gestione delle notifiche
- ✅ Log dettagliati delle notifiche
- ✅ Test SMTP integrato

### 🚀 Installazione
```bash
composer require modules/notify
php artisan module:enable Notify
php artisan migrate
```

Consulta la [documentazione completa del modulo Notify](docs/README.md) e la [documentazione globale PTVX](/docs/README.md) per approfondimenti architetturali e motivazionali.

---

## 🇬🇧 English

The Notify module provides a complete notification management system for Laravel applications, with support for multiple channels and advanced customization.

### ✨ Key Features
- ✅ Multi-channel notifications (email, SMS, push, database)
- ✅ Customizable templates
- ✅ Notification preferences management
- ✅ Asynchronous notification queue
- ✅ Filament admin interface
- ✅ RESTful API for notification management
- ✅ Detailed notification logs
- ✅ Integrated SMTP testing

### 🚀 Installation
```bash
composer require modules/notify
php artisan module:enable Notify
php artisan migrate
```

Check out the [complete Notify module documentation](docs/README.md) and the [global PTVX documentation](/docs/README.md) for architectural rationale and best practices.

---

## 🇪🇸 Español

El módulo Notify proporciona un sistema completo de gestión de notificaciones para aplicaciones Laravel, con soporte para múltiples canales y personalización avanzada.

### ✨ Características Principales
- ✅ Notificaciones multi-canal (email, SMS, push, base de datos)
- ✅ Plantillas personalizables
- ✅ Gestión de preferencias de notificación
- ✅ Cola de notificaciones asíncrona
- ✅ Interfaz administrativa Filament
- ✅ API RESTful para gestión de notificaciones
- ✅ Registros detallados de notificaciones
- ✅ Pruebas SMTP integradas

### 🚀 Instalación
```bash
composer require modules/notify
php artisan module:enable Notify
php artisan migrate
```

Consulta la [documentación completa del módulo Notify](docs/README.md) y la [documentación global PTVX](/docs/README.md) para más detalles.

---

# 📣 Enhance Your App with the Fila3 Notify Module! 🚀

> **Motivazione architetturale**: Il modulo Notify adotta una struttura DDD (Domain-Driven Design) per separare chiaramente i domini applicativi, utilizza Value Objects per la business logic e Spatie QueueableActions per la gestione asincrona delle notifiche. L'interfaccia utente è realizzata con componenti nativi Filament, garantendo coerenza e scalabilità.

> Per approfondimenti architetturali e motivazionali consulta la [documentazione tecnica del modulo Notify](docs/README.md) e la [documentazione globale PTVX](/docs/README.md).

---

Welcome to the **Fila3 Notify Module**! This powerful notification system is designed to streamline communication within your application. Whether you're sending alerts, reminders, or updates, the Fila3 Notify Module has you covered with its versatile features and easy integration.

## 📦 What's Inside?

The Fila3 Notify Module allows you to implement a robust notification system with minimal effort, featuring:

- **Real-time Notifications**: Send and receive notifications instantly to enhance user engagement.
- **Customizable Notification Types**: Tailor notifications to your needs, from alerts to success messages.
- **User-Specific Notifications**: Deliver targeted notifications to specific users based on their actions or preferences.
- **Persistent Notification Management**: Easily manage and store notifications for later access.

## 🌟 Key Features

- **Multi-format Support**: Create notifications with rich content, including text, images, and links.
- **Queueable Actions**: Handle multiple notifications efficiently with Spatie's Queueable Actions.
- **Event Listeners**: Integrate easily with your application's events to trigger notifications automatically.
- **Custom Notification Channels**: Organize notifications into different channels to keep users informed about relevant updates.
- **Filament Blade Components**: Beautiful and responsive UI components powered by Filament.
- **User Preferences Management**: Allow users to customize their notification settings for a personalized experience.
- **Integration with External APIs**: Seamlessly connect with third-party services to fetch or send notifications.

## 🚀 Why Choose Fila3 Notify?

- **Efficient & Lightweight**: Designed for high performance without slowing down your application.
- **Scalable Architecture**: Perfect for small applications and large-scale systems alike.
- **Active Community Support**: Join an engaged community of developers ready to assist and share insights.

## 🔧 Installation

Getting started with the Fila3 Notify Module is easy! Follow these steps to integrate it into your application:

1. Install the package via Composer:
   ```bash
   composer require laraxot/module_notify_fila3
   ```

2. Publish the configuration:
   ```bash
   php artisan vendor:publish --provider="Modules\Notify\Providers\NotifyServiceProvider"
   ```

3. Run the migrations:
   ```bash
   php artisan migrate
   ```

4. Add the module to your `composer.json`:
   ```json
   {
       "require": {
           "laraxot/module_notify_fila3": "^1.0"
       }
   }
   ```

## 📜 Usage Examples

Here are a few snippets to demonstrate how to use the Fila3 Notify Module in your application:

### Sending a Notification
```php
use Modules\Notify\Actions\SendNotificationAction;

app(SendNotificationAction::class)->execute(
    $user,
    'welcome',
    ['name' => $user->name],
    ['mail', 'database']
);
```

### Using Blade Components
```blade
<x-notify::notification-list :notifications="$notifications" />
```

### Tracking Events
```php
use Modules\Notify\Actions\TrackNotificationEventAction;

app(TrackNotificationEventAction::class)->execute(
    $notification,
    'opened',
    ['ip' => request()->ip()]
);
```

## 🤝 Contributing

We love contributions! If you have ideas, bug fixes, or enhancements, check out the contributing guidelines to get started.

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👤 Author

Marco Sottana
Discover more of my work at marco76tv!

# Modulo Notify

## Descrizione
Sistema di gestione delle notifiche per applicazioni Laravel con supporto multi-canale.

## Struttura del Modulo
```
Notify/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Resources/
│   ├── js/
│   └── views/
├── Routes/
└── Services/
```

## Checklist di Riavvio
- [ ] Verificare le dipendenze nel `composer.json`
- [ ] Controllare le migrazioni pendenti
- [ ] Verificare i service provider registrati
- [ ] Controllare le traduzioni
- [ ] Verificare le configurazioni
- [ ] Testare le funzionalità principali

## Best Practices
1. **Gestione delle Notifiche**
   - Utilizzare i canali appropriati
   - Implementare la coda per notifiche asincrone
   - Gestire correttamente i template

2. **Struttura del Codice**
   - Seguire il principio di responsabilità singola
   - Utilizzare i service layer per la logica di business
   - Implementare i trait per funzionalità condivise

3. **Performance**
   - Ottimizzare le query al database
   - Utilizzare la cache quando appropriato
   - Monitorare l'utilizzo delle risorse

## Errori Comuni
1. **Configurazione SMTP**
   - Verificare le credenziali
   - Controllare le impostazioni del server
   - Testare la connessione

2. **Gestione delle Code**
   - Verificare i worker delle code
   - Controllare i timeout
   - Monitorare i fallimenti

## Documentazione
- [Guida alle Notifiche](/docs/notifications.md)
- [Gestione dei Template](/docs/templates.md)
- [Best Practices](/docs/best-practices.md)

## Testing
- Eseguire i test unitari: `php artisan test --filter=Notify`
- Verificare la copertura del codice
- Testare le funzionalità principali

## Deployment
1. Eseguire le migrazioni
2. Pubblicare gli assets
3. Aggiornare la cache
4. Verificare i permessi

## Manutenzione
- Monitorare i log per errori
- Verificare periodicamente le performance
- Aggiornare le dipendenze
- Mantenere la documentazione aggiornata

## Esempi di Utilizzo
```php
// Invia notifica
use Modules\Notify\Actions\SendNotificationAction;

app(SendNotificationAction::class)->execute(
    $user,
    'welcome',
    ['name' => $user->name],
    ['mail', 'database']
);

// Componente Blade
<x-notify::notification-list :notifications="$notifications" />
```

## Configurazione
Il modulo può essere configurato tramite il file `config/notify.php`:
- Canali di notifica
- Template
- Impostazioni SMTP
- Configurazioni specifiche per modulo
