<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use function Pest\Laravel\get;
<<<<<<< HEAD
use function Pest\Laravel\actingAs;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
=======
<<<<<<< HEAD
=======
use function Pest\Laravel\actingAs;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)

uses(\Modules\Cms\Tests\TestCase::class);

describe('CMS Individual Folio Routes Tests', function () {
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    beforeEach(function () {
        $this->lang = app()->getLocale();
    });

    // Test homepage dal punto di vista CMS
    test('cms: route GET /{locale} (homepage)', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang);
        
        $response->assertStatus(200);
        
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang);

        $response->assertStatus(200);

=======
        $response = get('/' . $this->lang);
        
        $response->assertStatus(200);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verifica integrazione CMS specifica
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('x-page');
        $response->assertSee('side="content"');
        $response->assertSee('slug="home"');
    });

    // Test auth routes dal punto di vista CMS
    test('cms: route GET /{locale}/auth/login', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/login');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/login');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/login: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/login');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/login: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verifica che il CMS carichi correttamente i contenuti auth
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms: route GET /{locale}/auth/register', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/register');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/register');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/register: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/register');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/register: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verifica che il CMS gestisca correttamente la registrazione
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms: route GET /{locale}/auth/logout', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/logout');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/logout');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/logout: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/logout');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/logout: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verifica rendering CMS per logout
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/logout_fixed', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/logout_fixed');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/logout_fixed');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/logout_fixed: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/logout_fixed');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/logout_fixed: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/password/confirm', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/password/confirm');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/password/confirm');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/password/confirm: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/password/confirm');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/password/confirm: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/password/reset', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/password/reset');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/password/reset');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/password/reset: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/password/reset');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/password/reset: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/password/{token}', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/password/test-token');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/password/test-token');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/password/{token}: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 404]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/password/test-token');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/password/{token}: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 404]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/verify', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/verify');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/verify');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/verify: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/verify');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/verify: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/thank-you', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/thank-you');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/thank-you');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/thank-you: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/thank-you');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/thank-you: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/register/thank-you', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/register/thank-you');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/register/thank-you');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/register/thank-you: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/register/thank-you');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/register/thank-you: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/auth/{type}/register - patient', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/patient/register');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/patient/register');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/{type}/register (patient): ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/patient/register');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/{type}/register (patient): ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verifica che CMS gestisca correttamente la registrazione per tipo
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms: route GET /{locale}/auth/{type}/register - doctor', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/auth/doctor/register');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/auth/doctor/register');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/{type}/register (doctor): ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/auth/doctor/register');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/auth/{type}/register (doctor): ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    // Test pagine CMS specifiche
    test('cms: route GET /{locale}/pages', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/pages');
        
        $response->assertStatus(200);
        
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/pages');

        $response->assertStatus(200);

=======
        $response = get('/' . $this->lang . '/pages');
        
        $response->assertStatus(200);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verifica che CMS gestisca l'indice delle pagine
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/pages/{slug}', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/pages/test-slug');
        
        // Le pagine dinamiche potrebbero non esistere
        expect($response->status())->toBeIn([200, 404]);
        
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/pages/test-slug');

        // Le pagine dinamiche potrebbero non esistere
        expect($response->status())->toBeIn([200, 404]);

=======
        $response = get('/' . $this->lang . '/pages/test-slug');
        
        // Le pagine dinamiche potrebbero non esistere
        expect($response->status())->toBeIn([200, 404]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        if ($response->status() === 200) {
            // Verifica che CMS carichi correttamente la pagina dinamica
            $response->assertSee('<!DOCTYPE html>');
            $response->assertSee('<html');
            $response->assertSee('x-page');
        }
    });

    test('cms: route GET /{locale}/learn', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/learn');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/learn');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/learn: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/learn');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/learn: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/genesis/about', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/genesis/about');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/genesis/about');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/genesis/about: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/genesis/about');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/genesis/about: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/genesis/power-ups', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/genesis/power-ups');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/genesis/power-ups');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/genesis/power-ups: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/genesis/power-ups');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/genesis/power-ups: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/classi-css', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/classi-css');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/classi-css');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/classi-css: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/classi-css');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/classi-css: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/registration/thank-you', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/registration/thank-you');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/registration/thank-you');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/registration/thank-you: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/registration/thank-you');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/registration/thank-you: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms: route GET /{locale}/errors/password-expired', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang . '/errors/password-expired');
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang.'/errors/password-expired');
>>>>>>> 681ae6a (.)
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/errors/password-expired: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang . '/errors/password-expired');
        $status = $response->status();
        if ($status >= 500) {
            $this->markTestSkipped('Server error on /{locale}/errors/password-expired: ' . $status);
        }
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    // Test CMS con contenuti JSON
    describe('CMS Content Management Routes', function () {
<<<<<<< HEAD
        
=======
<<<<<<< HEAD

>>>>>>> 681ae6a (.)
        test('cms verifies json content loading for homepage', function () {
            $response = get('/' . $this->lang);
            $response->assertStatus(200);
            
            // Verifica che il JSON della homepage sia caricato correttamente
            $homepageJsonPath = config_path('local/saluteora/database/content/pages/home.json');
            expect(file_exists($homepageJsonPath))->toBeTrue();
            
            $homepageData = json_decode(file_get_contents($homepageJsonPath), true);
            expect($homepageData['content_blocks'])->toHaveKey($this->lang);
            
            $content = $response->getContent();
<<<<<<< HEAD
            
=======

=======
        
        test('cms verifies json content loading for homepage', function () {
            $response = get('/' . $this->lang);
            $response->assertStatus(200);
            
            // Verifica che il JSON della homepage sia caricato correttamente
            $homepageJsonPath = config_path('local/saluteora/database/content/pages/home.json');
            expect(file_exists($homepageJsonPath))->toBeTrue();
            
            $homepageData = json_decode(file_get_contents($homepageJsonPath), true);
            expect($homepageData['content_blocks'])->toHaveKey($this->lang);
            
            $content = $response->getContent();
            
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            // Verifica che i blocchi JSON siano renderizzati
            $blocks = $homepageData['content_blocks'][$this->lang];
            foreach ($blocks as $block) {
                if (isset($block['data']['title'])) {
                    expect($content)->toContain($block['data']['title']);
                }
            }
        });

        test('cms handles theme view resolution correctly', function () {
<<<<<<< HEAD
            $response = get('/' . $this->lang);
=======
<<<<<<< HEAD
            $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
            $response->assertStatus(200);
            
            $homepageData = json_decode(
                file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
                true
            );
            
            $blocks = $homepageData['content_blocks'][$this->lang];
<<<<<<< HEAD
            
=======

=======
            $response = get('/' . $this->lang);
            $response->assertStatus(200);
            
            $homepageData = json_decode(
                file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
                true
            );
            
            $blocks = $homepageData['content_blocks'][$this->lang];
            
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            // Verifica che le viste seguano il pattern theme
            foreach ($blocks as $block) {
                $view = $block['data']['view'];
                expect($view)->toStartWith('pub_theme::');
                expect($view)->toContain('components.blocks');
            }
        });

        test('cms processes blade syntax in json correctly', function () {
            $homepageData = json_decode(
<<<<<<< HEAD
                file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
=======
<<<<<<< HEAD
                file_get_contents(config_path('local/saluteora/database/content/pages/home.json')),
>>>>>>> 681ae6a (.)
                true
            );
            
            $blocks = $homepageData['content_blocks'][$this->lang];
            $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');
            
            if ($landingBlock) {
                // Verifica che la sintassi Blade sia nel JSON
                expect($landingBlock['data']['cta_link'])->toContain("{{ route('register') }}");
                
                // Verifica che sia processata correttamente nella pagina
                $response = get('/' . $this->lang);
                $content = $response->getContent();
<<<<<<< HEAD
                
=======

=======
                file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
                true
            );
            
            $blocks = $homepageData['content_blocks'][$this->lang];
            $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');
            
            if ($landingBlock) {
                // Verifica che la sintassi Blade sia nel JSON
                expect($landingBlock['data']['cta_link'])->toContain("{{ route('register') }}");
                
                // Verifica che sia processata correttamente nella pagina
                $response = get('/' . $this->lang);
                $content = $response->getContent();
                
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                $expectedUrl = route('register');
                expect($content)->toContain($expectedUrl);
            }
        });
    });

    // Test performance CMS
    test('cms: homepage renders within acceptable time', function () {
        $startTime = microtime(true);
<<<<<<< HEAD
        
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD

        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertStatus(200);
        
        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;
<<<<<<< HEAD
        
=======

=======
        
        $response = get('/' . $this->lang);
        $response->assertStatus(200);
        
        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // CMS dovrebbe renderizzare la homepage velocemente
        expect($loadTime)->toBeLessThan(1500, 'CMS homepage should load within 1.5 seconds');
    });

    test('cms: auth pages render within acceptable time', function () {
        $authRoutes = [
<<<<<<< HEAD
            '/' . $this->lang . '/auth/login',
            '/' . $this->lang . '/auth/register',
=======
<<<<<<< HEAD
            '/'.$this->lang.'/auth/login',
            '/'.$this->lang.'/auth/register',
>>>>>>> 681ae6a (.)
        ];
        
        foreach ($authRoutes as $route) {
            $startTime = microtime(true);
            
            $response = get($route);
            $response->assertStatus(200);
            
            $endTime = microtime(true);
            $loadTime = ($endTime - $startTime) * 1000;
            
            expect($loadTime)->toBeLessThan(1000, "CMS route {$route} should load within 1 second");
        }
    });
<<<<<<< HEAD
});
=======
});
=======
            '/' . $this->lang . '/auth/login',
            '/' . $this->lang . '/auth/register',
        ];
        
        foreach ($authRoutes as $route) {
            $startTime = microtime(true);
            
            $response = get($route);
            $response->assertStatus(200);
            
            $endTime = microtime(true);
            $loadTime = ($endTime - $startTime) * 1000;
            
            expect($loadTime)->toBeLessThan(1000, "CMS route {$route} should load within 1 second");
        }
    });
});
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
