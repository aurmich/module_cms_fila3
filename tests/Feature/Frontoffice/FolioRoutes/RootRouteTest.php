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

it('GET / redirects to /{locale}', function (): void {
    $locale = app()->getLocale();
<<<<<<< HEAD
    $this->get('/')->assertRedirect('/' . $locale);
=======
<<<<<<< HEAD
    $this->get('/')->assertRedirect('/'.$locale);
=======
    $this->get('/')->assertRedirect('/' . $locale);
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
});
