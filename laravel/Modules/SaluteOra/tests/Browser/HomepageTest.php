<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use function Pest\Laravel\browse;

/**
 * Test per verificare che l'homepage mostri correttamente i contenuti secondo le specifiche
 */

uses(\Tests\DuskTestCase::class);

test('homepage title', function (): void {
    $this->browse(function (Browser $browser): void {
        $browser->visit('/')
               ->assertSee('Benvenuta su Salute Orale,');
    });
});

test('homepage content', function (): void {
    $this->browse(function (Browser $browser): void {
        $browser->visit('/')
               // Verifica titolo e testo principale
               ->assertSee('Benvenuta su Salute Orale,')
               ->assertSee('il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza')
               ->assertSee('servizi odontoiatrici di prevenzione a titolo completamente gratuito')

               // Verifica testo requisiti
               ->assertSee('Se sei una donna in stato di gravidanza residente in Italia')
               ->assertSee('valore ISEE pari a euro 20,000 o inferiore')

               // Verifica presenza CTA
               ->assertSee('INIZIA ORA')

               // Verifica che il pulsante sia cliccabile
               ->assertPresent('a:contains("INIZIA ORA"), button:contains("INIZIA ORA")');

        // Screenshot per verifica visiva (opzionale)
        $browser->screenshot('homepage');
    });
});

test('homepage visual requirements', function (): void {
    /**
     * Test per verificare i requisiti visivi e di stile descritti nella documentazione
     * Basato sui requisiti in /var/www/html/saluteora/docs/images/2.md
     */
    $this->browse(function (Browser $browser): void {
        $browser->visit('/')
               // Verifica la presenza del titolo stilizzato "SALUTE ORAle"
               ->assertPresent('h1, .hero-title')
               ->assertSee('SALUTE ORA')
               
               // Verifica la presenza del sottotitolo "Benvenuta su Salute Orale"
               ->assertPresent('h2, .hero-subtitle, .subtitle')
               ->assertSee('Benvenuta su Salute Orale')
               
               // Verifica che il testo sui servizi gratuiti sia in grassetto o evidenziato
               ->assertPresent('strong:contains("gratuito"), b:contains("gratuito"), .font-bold:contains("gratuito"), .font-semibold:contains("gratuito")')
               
               // Verifica la presenza del pulsante di azione con stile appropriato
               ->assertPresent('a.btn, button.btn, .btn, .button, a.cta-button, button.cta-button')
               ->assertSee('INIZIA ORA')
               
               // Verifica che il font sia sans-serif
               ->assertPresent('body.font-sans, .font-sans')
               
               // Verifica la presenza di sezioni per le caratteristiche
               ->assertSee('Perché è importante la salute orale in gravidanza?')
               ->assertPresent('.feature-section, .features, .feature-grid')
               
               // Verifica la presenza delle tre caratteristiche principali
               ->assertSee('Prevenzione')
               ->assertSee('Assistenza')
               ->assertSee('Supporto')
               
               // Screenshot per verifica visiva
               ->screenshot('homepage-visual-requirements');
    });
});

test('homepage structure', function (): void {
    /**
     * Test degli elementi strutturali dell'homepage
     */
    $this->browse(function (Browser $browser): void {
        $browser->visit('/')
                // Verifica intestazione
                ->assertPresent('header, .header')

                // Verifica selettore lingua
                ->assertPresent('.language-selector, [data-language-selector]')

                // Verifica piè di pagina con loghi partner
                ->assertPresent('footer, .footer')
                ->assertPresent('.partner-logos, .sponsors');
    });
});
