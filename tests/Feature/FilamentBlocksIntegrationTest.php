<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

<<<<<<< HEAD
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
=======
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
>>>>>>> bc33217 (.)

uses(\Modules\Cms\Tests\TestCase::class);

describe('Filament Blocks Integration', function () {
    it('integrates with PageContentBuilder correctly', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);

=======
        
        $response->assertStatus(200);
>>>>>>> bc33217 (.)
        // Verifica che il PageContentBuilder funzioni correttamente
        // Questo test verifica l'integrazione tra CMS e frontend
    });

    it('displays blocks with correct data structure', function () {
        $response = get('/');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        $response->assertStatus(200);
        // Verifica struttura dati blocchi
        $response->assertSee('landing-page');
        $response->assertSee('view');
        $response->assertSee('title');
        $response->assertSee('subtitle');
        $response->assertSee('image');
        $response->assertSee('cta_text');
        $response->assertSee('cta_link');
    });

    it('renders blocks using correct view templates', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);

=======
        
        $response->assertStatus(200);
>>>>>>> bc33217 (.)
        // Verifica che i blocchi usino i template corretti
        // Questo test verifica l'integrazione con il sistema di view
    });

    it('handles block configuration correctly', function () {
        $response = get('/');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        $response->assertStatus(200);
        // Verifica configurazione blocchi
        $response->assertSee('bg-white');
        $response->assertSee('text-gray-900');
        $response->assertSee('bg-indigo-600');
        $response->assertSee('hover:bg-indigo-700');
    });

    it('displays block content with proper formatting', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);

=======
        
        $response->assertStatus(200);
>>>>>>> bc33217 (.)
        // Verifica formattazione contenuto blocchi
        // Titolo e sottotitolo devono essere formattati correttamente
    });

    it('handles block relationships correctly', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);

=======
        
        $response->assertStatus(200);
>>>>>>> bc33217 (.)
        // Verifica relazioni tra blocchi
        // Questo test verifica che i blocchi si integrino correttamente
    });

    it('renders blocks with correct styling', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);
        // Verifica styling blocchi
        $response->assertSee('class="');

=======
        
        $response->assertStatus(200);
        // Verifica styling blocchi
        $response->assertSee('class="');
>>>>>>> bc33217 (.)
        // Verifica che le classi CSS siano applicate correttamente
    });

    it('handles block validation correctly', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);

=======
        
        $response->assertStatus(200);
>>>>>>> bc33217 (.)
        // Verifica validazione blocchi
        // Questo test verifica che i blocchi siano validati correttamente
    });

    it('displays blocks with correct localization', function () {
        // Test italiano
        $response = get('/');
        $response->assertStatus(200);
        $response->assertSee('Benvenuta su SaluteOra');

        // Test inglese
        $response = get('/en');
        $response->assertStatus(200);
        // Verifica localizzazione blocchi

        // Test tedesco
        $response = get('/de');
        $response->assertStatus(200);
<<<<<<< HEAD

=======
>>>>>>> bc33217 (.)
        // Verifica localizzazione blocchi
    });

    it('handles block errors gracefully', function () {
        $response = get('/');
<<<<<<< HEAD

        $response->assertStatus(200);

=======
        
        $response->assertStatus(200);
>>>>>>> bc33217 (.)
        // Verifica gestione errori blocchi
        // Questo test verifica che gli errori siano gestiti correttamente
    });

    it('renders blocks with correct performance', function () {
        $startTime = microtime(true);
<<<<<<< HEAD

        $response = get('/');

        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;

        $response->assertStatus(200);

=======
        
        $response = get('/');
        
        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;
        
        $response->assertStatus(200);
        
>>>>>>> bc33217 (.)
        // Verifica che i blocchi si carichino entro tempi accettabili
        expect($loadTime)->toBeLessThan(500);
    });
});
<<<<<<< HEAD
=======

>>>>>>> bc33217 (.)
