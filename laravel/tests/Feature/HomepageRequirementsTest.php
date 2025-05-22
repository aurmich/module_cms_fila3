<?php

use function Pest\Laravel\get;

/**
 * Test che verifica se la homepage rispetta i requisiti documentati.
 * 
 * I requisiti sono documentati in /var/www/html/saluteora/docs/images/2.md
 */
test('la homepage contiene tutti gli elementi richiesti dai requisiti', function () {
    // Visita la homepage
    $response = get('/');
    
    // Verifica che la risposta sia corretta
    $response->assertStatus(200);
    
    // Verifica la presenza del titolo principale
    $response->assertSee('SALUTE ORA', false); // Il titolo principale dovrebbe contenere "SALUTE ORA"
    
    // Verifica la presenza del sottotitolo/introduzione
    $response->assertSee('Benvenuta su Salute Orale', false);
    
    // Verifica la descrizione del servizio
    $response->assertSee('servizi odontoiatrici', false);
    $response->assertSee('gratuito', false);
    $response->assertSee('pazienti vulnerabili in stato di gravidanza', false);
    
    // Verifica la specificazione del target
    $response->assertSee('ISEE', false);
    $response->assertSee('20,000', false);
    $response->assertSee('residente in Italia', false);
    
    // Verifica la presenza del pulsante di azione
    $response->assertSee('INIZIA ORA', false);
});

/**
 * Test che verifica la struttura semantica della homepage.
 */
test('la homepage ha la corretta struttura semantica', function () {
    // Visita la homepage
    $response = get('/');
    
    // Verifica che la risposta sia corretta
    $response->assertStatus(200);
    
    // Ottieni il contenuto HTML
    $html = $response->getContent();
    
    // Verifica la presenza di elementi semantici appropriati
    expect($html)->toContain('<header');
    expect($html)->toContain('<main');
    expect($html)->toContain('<h1');
    expect($html)->toContain('<button');
    expect($html)->toContain('<footer');
});

/**
 * Test che verifica l'accessibilità della homepage.
 */
test('la homepage è accessibile', function () {
    // Visita la homepage
    $response = get('/');
    
    // Verifica che la risposta sia corretta
    $response->assertStatus(200);
    
    // Ottieni il contenuto HTML
    $html = $response->getContent();
    
    // Verifica la presenza di attributi di accessibilità
    expect($html)->toContain('alt="');
    expect($html)->toContain('aria-');
    
    // Verifica che tutte le immagini abbiano un testo alternativo
    $this->assertFalse(str_contains($html, '<img src="') && !str_contains($html, '<img src=" alt="'));
});

/**
 * Test che verifica la responsività della homepage.
 */
test('la homepage contiene meta tag per la responsività', function () {
    // Visita la homepage
    $response = get('/');
    
    // Verifica che la risposta sia corretta
    $response->assertStatus(200);
    
    // Verifica la presenza del meta tag viewport
    $response->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1', false);
});
