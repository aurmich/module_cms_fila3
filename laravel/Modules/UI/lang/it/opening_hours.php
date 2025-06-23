<?php

declare(strict_types=1);

return [
    'instructions' => [
        'title' => 'Orari di Apertura',
        'description' => 'Configura gli orari di apertura per ogni giorno della settimana. Lascia vuoto per indicare giorno di chiusura.',
    ],
    
    'headers' => [
        'day' => 'Giorno',
        'morning' => 'Mattina',
        'afternoon' => 'Pomeriggio',
    ],
    
    'legend' => [
        'open' => 'Aperto',
        'closed' => 'Chiuso',
        'format' => 'Formato: HH:MM-HH:MM',
    ],
    
    'days' => [
        'monday' => 'Lunedì',
        'tuesday' => 'Martedì', 
        'wednesday' => 'Mercoledì',
        'thursday' => 'Giovedì',
        'friday' => 'Venerdì',
        'saturday' => 'Sabato',
        'sunday' => 'Domenica',
    ],
    
    'periods' => [
        'morning' => 'Mattina',
        'afternoon' => 'Pomeriggio',
        'evening' => 'Sera',
    ],
    
    'labels' => [
        'from' => 'Dalle',
        'to' => 'Alle',
    ],
    
    'placeholders' => [
        'morning' => '08:00-12:30',
        'afternoon' => '15:00-19:00',
        'evening' => '20:00-23:00',
    ],
    
    'notes' => [
        'format_hint' => 'Utilizzare il formato HH:MM-HH:MM (es. 08:30-12:00)',
        'empty_hint' => 'Lasciare vuoto per indicare che il periodo è chiuso',
        'validation_error' => 'L\'orario di apertura deve essere precedente all\'orario di chiusura',
        'overlap_error' => 'Gli orari non possono sovrapporsi nello stesso giorno',
    ],
    
    'validation' => [
        'invalid_format' => 'Formato orario non valido. Utilizzare HH:MM-HH:MM',
        'invalid_time_range' => 'L\'orario di apertura deve essere precedente all\'orario di chiusura',
        'overlapping_hours' => 'Gli orari di mattina e pomeriggio si sovrappongono',
        'from_before_to' => 'L\'orario "Dalle" deve essere precedente all\'orario "Alle"',
        'to_after_from' => 'L\'orario "Alle" deve essere successivo all\'orario "Dalle"',
        'time_sequence' => 'L\'orario di inizio deve essere precedente a quello di fine',
    ],
]; 