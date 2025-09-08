<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
<<<<<<< HEAD
namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

=======
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
uses(\Modules\Cms\Tests\TestCase::class);

it('GET /{locale} returns 200 and has lang attribute', function (): void {
    $locale = app()->getLocale();
<<<<<<< HEAD
    $response = $this->get('/' . $locale);
    $response->assertStatus(200);
    $response->assertSee('<html', false);
    $response->assertSee(' lang="' . $locale . '"', false);
=======
<<<<<<< HEAD
    $response = $this->get('/'.$locale);
    $response->assertStatus(200);
    $response->assertSee('<html', false);
    $response->assertSee(' lang="'.$locale.'"', false);
=======
    $response = $this->get('/' . $locale);
    $response->assertStatus(200);
    $response->assertSee('<html', false);
    $response->assertSee(' lang="' . $locale . '"', false);
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
});
