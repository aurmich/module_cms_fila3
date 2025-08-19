<?php

declare(strict_types=1);

/**
 * Script per creare 20 studi con postal_code = 66010
 * 
 * Esegui con: php artisan tinker < scripts/create_studios_66010.php
 */

echo "🏥 Creazione 20 studi dentistici con postal_code = 66010...\n";

use Modules\SaluteOra\Models\Studio;
use Modules\Geo\Models\Address;

// Prima aggiungiamo la colonna postal_code alla tabella studios se non esiste
try {
    if (!Schema::hasColumn('studios', 'postal_code')) {
        Schema::table('studios', function (Blueprint $table) {
            $table->string('postal_code', 10)->nullable()->after('phone');
        });
        echo "✓ Aggiunta colonna postal_code alla tabella studios\n";
    }
} catch (Exception $e) {
    echo "⚠️ Colonna postal_code già esistente o errore: " . $e->getMessage() . "\n";
}

// Nomi realistici per studi dentistici
$studioNames = [
    'Studio Dentistico Sorriso',
    'Clinica Odontoiatrica Moderna',
    'Centro Dentale Salute',
    'Studio Odontoiatrico Benessere',
    'Clinica Dentale Excellence',
    'Studio Dentistico Famiglia',
    'Centro Odontoiatrico Avanzato',
    'Studio Dentale Professionale',
    'Clinica Odontoiatrica Specialistica',
    'Studio Dentistico Innovativo',
    'Centro Dentale Qualità',
    'Studio Odontoiatrico Comfort',
    'Clinica Dentale Tecnologica',
    'Studio Dentistico Esperienza',
    'Centro Odontoiatrico Fiducia',
    'Studio Dentale Precisione',
    'Clinica Odontoiatrica Cura',
    'Studio Dentistico Armonia',
    'Centro Dentale Sicurezza',
    'Studio Odontoiatrico Eccellenza'
];

// Servizi dentali comuni
$services = [
    'Igiene dentale',
    'Ortodonzia',
    'Implantologia',
    'Endodonzia',
    'Parodontologia',
    'Chirurgia orale',
    'Protesi dentale',
    'Odontoiatria pediatrica',
    'Estetica dentale',
    'Radiologia dentale'
];

// Orari di apertura standard
$openingHours = [
    'monday' => ['09:00-12:30', '14:30-18:30'],
    'tuesday' => ['09:00-12:30', '14:30-18:30'],
    'wednesday' => ['09:00-12:30', '14:30-18:30'],
    'thursday' => ['09:00-12:30', '14:30-18:30'],
    'friday' => ['09:00-12:30', '14:30-18:30'],
    'saturday' => ['09:00-13:00'],
    'sunday' => []
];

$createdStudios = [];

for ($i = 0; $i < 20; $i++) {
    try {
        $studio = Studio::create([
            'name' => $studioNames[$i],
            'postal_code' => '66010',
            'phone' => '+39 085 ' . str_pad((string)rand(1000000, 9999999), 7, '0', STR_PAD_LEFT),
            'email' => strtolower(str_replace(' ', '', $studioNames[$i])) . '@example.com',
            'website' => 'https://www.' . strtolower(str_replace(' ', '', $studioNames[$i])) . '.it',
            'registration_number' => str_pad((string)rand(100000, 999999), 6, '0', STR_PAD_LEFT),
            'vat_number' => 'IT' . str_pad((string)rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT),
            'description' => 'Studio dentistico moderno e professionale situato nella zona di Chieti (66010). Offriamo servizi odontoiatrici completi con tecnologie all\'avanguardia.',
            'opening_hours' => $openingHours,
            'services' => array_slice($services, 0, rand(4, 8)),
            'active' => true,
        ]);

        // Crea anche un indirizzo per lo studio
        $address = Address::create([
            'model_type' => Studio::class,
            'model_id' => $studio->id,
            'street' => 'Via ' . fake()->streetName() . ' ' . rand(1, 200),
            'city' => 'Chieti',
            'postal_code' => '66010',
            'province' => 'CH',
            'region' => 'Abruzzo',
            'country' => 'Italia',
            'latitude' => 42.3498 + (rand(-100, 100) / 10000), // Coordinate vicine a Chieti
            'longitude' => 14.1677 + (rand(-100, 100) / 10000),
        ]);

        $createdStudios[] = $studio;
        echo "✓ Creato studio: {$studio->name} (ID: {$studio->id})\n";
        
    } catch (Exception $e) {
        echo "❌ Errore nella creazione dello studio {$studioNames[$i]}: " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 CREAZIONE COMPLETATA!\n";
echo "📊 Studi creati: " . count($createdStudios) . "/20\n";
echo "📍 Tutti gli studi hanno postal_code = 66010\n";
echo "🏙️ Località: Chieti, Abruzzo\n\n";

// Verifica finale
$studiosCount = Studio::where('postal_code', '66010')->count();
echo "✅ Verifica: Trovati {$studiosCount} studi con postal_code = 66010 nel database\n";

// Mostra alcuni dettagli degli studi creati
echo "\n📋 DETTAGLI STUDI CREATI:\n";
echo "┌─────┬─────────────────────────────────┬──────────────────┐\n";
echo "│ ID  │ Nome Studio                     │ Telefono         │\n";
echo "├─────┼─────────────────────────────────┼──────────────────┤\n";

foreach ($createdStudios as $studio) {
    $id = str_pad((string)$studio->id, 3, ' ', STR_PAD_LEFT);
    $name = str_pad(substr($studio->name, 0, 31), 31, ' ', STR_PAD_RIGHT);
    $phone = str_pad($studio->phone ?? 'N/A', 16, ' ', STR_PAD_RIGHT);
    echo "│{$id} │ {$name} │ {$phone} │\n";
}

echo "└─────┴─────────────────────────────────┴──────────────────┘\n\n";

echo "💡 Gli studi sono ora disponibili per:\n";
echo "- Assegnazione di dottori\n";
echo "- Prenotazione appuntamenti\n";
echo "- Gestione calendario\n";
echo "- Ricerca per codice postale 66010\n\n";
