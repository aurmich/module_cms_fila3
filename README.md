<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
# creazione ambiente di produzione

# common
```bash
apt update
apt install -y tzdata
dpkg-reconfigure tzdata
apt install ntpdate unzip
echo -e '#!/bin/bash\n/usr/sbin/ntpdate it.pool.ntp.org >> /tmp/ntpdate.log 2>&1' > /etc/cron.hourly/adjntpdate
chmod +x /etc/cron.hourly/adjntpdate
```
# mysql
```bash
apt install mysql-server-8.0
```
```bash
mysql
```

> ```bash
> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
> exit
> ```

```bash
mysql_secure_installation
```

> ```bash
> impedito accesso da remoto con utente root
> eliminati database di test
> rimossi utenti anonimi
> cambiata la password di root
> ```

```bash
mysql
```

> ```bash
> CREATE DATABASE saluteora_data;
> CREATE DATABASE saluteora_user;
> CREATE USER 'saluteorale'@'localhost' IDENTIFIED BY '*****************';
> GRANT ALL PRIVILEGES ON saluteora_data.* TO 'saluteorale'@'localhost';
> GRANT ALL PRIVILEGES ON saluteora_user.* TO 'saluteorale'@'localhost';
> FLUSH PRIVILEGES;
> exit
> ```

# apache
```bash
apt install apache2
a2enmod rewrite
a2dissite 000-default
```

```bash
vim /etc/apache2/sites-available/saluteorale.conf
```

> ```bash
> <VirtualHost *:80>
> 	ServerName saluteoraleingravidanza.it
> 
> 	ServerAdmin sysadmin@exabytesrl.it
> 	DocumentRoot /var/www/saluteorale/public_html
> 
> 	LogLevel info
> 	ErrorLog ${APACHE_LOG_DIR}/error.log
> 	CustomLog ${APACHE_LOG_DIR}/access.log combined
> 
> 	#rewrite rule per redirigere il traffico http su https
> 	#RewriteEngine On
> 	#RewriteCond %{HTTPS} off
> 	#RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI}
> 
> 	<Directory /var/www/saluteorale/public_html>
> 		AllowOverride None
> 		Order Allow,Deny
> 		Allow from All
> 
> 		FallbackResource /index.php
> 	</Directory>
> 
> 	BrowserMatch "MSIE [2-6]" \
> 		nokeepalive ssl-unclean-shutdown \
> 		downgrade-1.0 force-response-1.0
> 
> 	# Intercept Microsoft Office Protocol Discovery
> 	# (https://stackoverflow.com/questions/8073908/what-are-microsoft-office-protocol-discovery-and-officeliveconnector-and-why)
> 	RewriteEngine On
> 	RewriteCond %{REQUEST_METHOD} ^(OPTIONS|PROPFIND)$ [NC]
> 	RewriteCond %{HTTP_USER_AGENT} ^Microsoft\ Office\ Protocol\ Discovery [OR]
> 	RewriteCond %{HTTP_USER_AGENT} ^Microsoft\ Office\ Existence\ Discovery [OR]
> 	RewriteCond %{HTTP_USER_AGENT} ^Microsoft\-WebDAV\-MiniRedir.*$
> 	RewriteRule .* - [R=501,L]
> </VirtualHost>
> ```

```bash
vim /etc/apache2/apache2.conf
```

> ```bash
> LogFormat "%h %{X-Forwarded-For}i %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\" %D" combined
> 
> # KeepAliveTimeout 5
> KeepAliveTimeout 65 
> ```

# php
```bash
apt install php8.3 libapache2-mod-php8.3
apt install php8.3-{bcmath,bz2,intl,gd,mbstring,mysql,zip,curl,xml,imap,pdo-sqlite,sqlite3,dom,redis,memcache,memcached,tokenizer}
apt install php-json
```

```bash
vim /etc/php/8.3/apache2/php.ini
```

> ```bash
> date.timezone = "Europe/Rome"
> 
> ; max_execution_time = 30
> max_execution_time = 300
> 
> ; post_max_size = 8M
> post_max_size = 50M
> 
> ; max_input_vars = 1000
> max_input_vars = 10000
> 
> ; memory_limit = 128M
> memory_limit = 2048M
> 
> ; upload_max_filesize = 2M
> upload_max_filesize = 200M
> ```

```bash
systemctl reload apache2
```

# redis
```bash
apt install redis-server
```

```bash
vim /etc/redis/redis.conf
```

> ```bash
> bind 127.0.0.1 -::1
> port 6379
> daemonize yes
> ```

```bash
systemctl enable redis-server.service
systemctl start redis
```

```bash
redis-cli
```

> ```bash
> ping
> exit
> ```
=======
=======
>>>>>>> b48ea51 (.)
=======
>>>>>>> bc33217 (.)
# 🌐 Cms - Il SISTEMA di GESTIONE CONTENUTI più AVANZATO! 📝

<!-- Dynamic validation badges -->
[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN%20%7C%20DE-green.svg)](https://laravel.com/docs/localization)
[![Folio Routes](https://img.shields.io/badge/Folio-File%20Routes-purple.svg)](https://laravel.com/docs/folio)
[![Volt Components](https://img.shields.io/badge/Volt-Single%20File%20Components-orange.svg)](https://laravel.com/docs/volt)
[![Pest Tests](https://img.shields.io/badge/Pest%20Tests-✅%20Passing-brightgreen.svg)](tests/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
<<<<<<< HEAD
<<<<<<< HEAD
=======
# Modulo CMS
>>>>>>> f492947 (.)
=======
>>>>>>> b48ea51 (.)
=======
>>>>>>> bc33217 (.)

Un modulo CMS modulare, estensibile e riutilizzabile per Laravel, con supporto per Filament, Volt e Folio.

## Caratteristiche

- Gestione pagine e contenuti
- Blocchi di contenuto personalizzabili
- Menu e navigazione
- Gestione media
- Layout e temi
- API RESTful e GraphQL
- Pannello amministrativo con Filament
- Componenti reattivi con Volt
- Routing basato su file con Folio

## Requisiti

- PHP 8.2+
- Laravel 11.x
- Filament 3.x
- Laravel Volt
- Laravel Folio
- Composer

## Installazione

```bash
composer require modules/cms
```

Pubblicare le risorse:

```bash
php artisan vendor:publish --provider="Modules\Cms\Providers\CmsServiceProvider"
```

Eseguire le migrazioni:

```bash
php artisan module:migrate cms
```

## Configurazione

Il modulo può essere configurato tramite il file `config/cms.php`:

```php
return [
    'prefix' => 'cms',
    'middleware' => ['web', 'auth'],
    'cache' => [
        'enabled' => true,
        'ttl' => 3600
    ],
    'media' => [
        'disk' => 'public',
        'path' => 'media'
    ]
];
```

## Utilizzo

### Creazione Pagina

```php
use Modules\Cms\Actions\CreatePageAction;

$page = app(CreatePageAction::class)->execute([
    'title' => 'La mia pagina',
    'slug' => 'la-mia-pagina',
    'content' => 'Contenuto della pagina'
]);
```

### Aggiunta Blocco

```php
use Modules\Cms\Actions\AddBlockAction;

$block = app(AddBlockAction::class)->execute($page, [
    'type' => 'text',
    'content' => 'Contenuto del blocco'
]);
```

### Componente Volt

```php
use Livewire\Volt\Component;

class PageEditor extends Component
{
    public Page $page;
    
    public function save(): void
    {
        $this->page->save();
    }
}
```

### Pagina Folio

```php
use Illuminate\View\View;

class Show
{
    public function __invoke(Page $page): View
    {
        return view('cms::pages.show', [
            'page' => $page
        ]);
    }
}
```

## Documentazione

- [Architettura](docs/architecture.md)
- [Tecnologie](docs/technologies.md)
- [Frontend](docs/frontoffice/README.md)
- [API](docs/api/README.md)
- [Sviluppo](docs/developer/README.md)
- [Utente](docs/user/README.md)

## Testing

```bash
composer test
```

## Contribuire

Le pull request sono benvenute. Per modifiche importanti, aprire prima una issue per discutere la modifica proposta.

## Licenza

MIT
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> fd753da3 (.)
=======
>>>>>>> f492947 (.)
=======
>>>>>>> bc33217 (.)
