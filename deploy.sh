#!/usr/bin/env bash

# abilito l'uscita immediata in caso di errore
set -e

echo "Inizio deploy..." 

# mi sposto nella working dir
echo "Cambio directory..." 
cd /var/www/saluteorale

# evito l'errore "fatal: detected dubious ownership in repository" 
echo "Configurazione safe.directory..." 
sudo git config --global --add safe.directory /var/www/saluteorale

# eseguo pull
echo "Esecuzione git pull..." 
sudo git pull

# aggiornamento applicazione
cd laravel
echo "Aggiorno composer..." 
sudo php -d memory_limit=-1 composer.phar selfupdate
sudo rm -rf ./app/View/Components/vendor/
sudo rm -rf ./resources/views/vendor/
echo "Aggiorno librerie..." 
sudo php -d memory_limit=-1 composer.phar update -W
echo "Pubblico variabili e configurazioni..." 
sudo php artisan vendor:publish --all
sudo rm -rf database/migrations/*
sudo rm -rf ./app/View/Components/vendor/
echo "Eseguo migrazioni..." 
sudo php artisan migrate
echo "Aggiorno Filament..." 
sudo php artisan filament:upgrade
echo "Ottimizzo Filament..." 
sudo php artisan filament:optimize
echo "Ottimizzo applicazione..." 
sudo php artisan optimize
echo "Pulizia route..." 
sudo php artisan route:clear

# riaggiorno i permessi
echo "Aggiornamento permessi..." 
sudo chown -R www-data:www-data /var/www/saluteorale/
sudo chmod -R g+w /var/www/saluteorale/

echo "Deploy completato con successo!" 

echo "DEPLOY_SUCCESS" 