<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use function Pest\Laravel\get;

test('homepage shows the correct title', function () {
    get('/')
        ->assertOk()
        ->assertSee('Benvenuta su Salute Orale,');
});

test('homepage shows the correct main text', function () {
    get('/')
        ->assertOk()
        ->assertSee('il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito.');
});

test('homepage shows the correct requirements text', function () {
    get('/')
        ->assertOk()
        ->assertSee('Se sei una donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore, e vuoi partecipare a questa iniziativa clicca il pulsante qui sotto:');
});

test('homepage shows the CTA button with correct text', function () {
    get('/')
        ->assertOk()
        ->assertSee('INIZIA ORA');
});

test('homepage shows all required elements according to specifications', function () {
    $response = get('/');

    $response->assertOk();

    // Verifica titolo e testi principali
    $response->assertSee('Benvenuta su Salute Orale,');
    $response->assertSee('il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza');
    $response->assertSee('servizi odontoiatrici di prevenzione a titolo completamente gratuito');
    $response->assertSee('Se sei una donna in stato di gravidanza residente in Italia');
    $response->assertSee('valore ISEE pari a euro 20,000 o inferiore');
    $response->assertSee('INIZIA ORA');

    // Verifica elementi strutturali (selettore lingua, eventuali loghi dei partner)
    // Nota: questi controlli possono richiedere selettori CSS specifici in base all'implementazione

    // Esempio di verifica per il selettore lingua (assunzione per l'implementazione)
    $response->assertSee('IT');
    $response->assertSee('EN');
}); 