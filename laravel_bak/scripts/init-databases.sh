#!/bin/bash

# Script per inizializzare tutti i database necessari per SaluteOra

echo "Inizializzazione dei database per SaluteOra"

# Variabili di configurazione - modificare se necessario
MYSQL_HOST="127.0.0.1"
MYSQL_PORT="3306"
MYSQL_USER="root"
MYSQL_PASS=""

# Elenco dei database da creare
DATABASES=("saluteora_data" "patient" "setting")

# Crea i database
for db in "${DATABASES[@]}"; do
    echo "Creazione database: $db"
    mysql -h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER -p$MYSQL_PASS -e "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    if [ $? -eq 0 ]; then
        echo "Database $db creato con successo"
    else
        echo "Errore nella creazione del database $db"
    fi
done

echo "Inizializzazione completata!"

echo "Ora puoi aggiornare il file .env con le credenziali corrette e eseguire le migrazioni."
