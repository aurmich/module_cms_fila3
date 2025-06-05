<?php

/**
 * Script semplice per verificare il contenuto dell'homepage di il progetto
 *
 * Questo script utilizza cURL per accedere all'homepage e verificare che il contenuto
 * corrisponda alle specifiche ufficiali.
 *
 * Uso: php HomepageUrlCheck.php
 */

// Definisce l'URL dell'homepage
$url = 'http://saluteora.local/';

// Elementi da verificare
$expectedElements = [
    'Benvenuta su Salute Orale,',
    'il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza',
    'servizi odontoiatrici di prevenzione a titolo completamente gratuito',
    'Se sei una donna in stato di gravidanza residente in Italia',
    'ISEE pari a euro 20,000 o inferiore',
    'INIZIA ORA'
];

// Inizializza cURL
$curl = curl_init();

// Configura le opzioni cURL
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,  // Attenzione: in produzione questo dovrebbe essere true
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
]);

// Esegue la richiesta
$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Verifica se la richiesta è riuscita
if ($httpCode !== 200) {
    echo "ERRORE: Impossibile accedere all'homepage. Codice HTTP: $httpCode\n";
    curl_close($curl);
    exit(1);
}

// Verifica se ci sono errori cURL
if (curl_errno($curl)) {
    echo "ERRORE cURL: " . curl_error($curl) . "\n";
    curl_close($curl);
    exit(1);
}

curl_close($curl);

// Conta gli elementi trovati
$foundCount = 0;
$missingElements = [];

// Controlla se tutti gli elementi previsti sono presenti
foreach ($expectedElements as $element) {
    if (strpos($response, $element) !== false) {
        $foundCount++;
        echo "√ Trovato: \"$element\"\n";
    } else {
        $missingElements[] = $element;
        echo "✗ NON trovato: \"$element\"\n";
    }
}

// Riepilogo dei risultati
echo "\n--- RIEPILOGO ---\n";
echo "Elementi trovati: $foundCount/" . count($expectedElements) . "\n";

if (count($missingElements) > 0) {
    echo "Elementi mancanti:\n";
    foreach ($missingElements as $element) {
        echo "- $element\n";
    }
    echo "\nL'homepage NON corrisponde alle specifiche ufficiali!\n";
    exit(1);
} else {
    echo "Tutti gli elementi sono presenti. L'homepage corrisponde alle specifiche ufficiali!\n";
    exit(0);
}
