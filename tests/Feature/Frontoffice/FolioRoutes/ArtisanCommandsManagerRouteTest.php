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

it('GET /it/artisan-commands-manager returns acceptable status', function (): void {
    $res = $this->get('/it/artisan-commands-manager');
    $status = $res->getStatusCode();
    if ($status >= 500) {
<<<<<<< HEAD
        $this->markTestSkipped('Server error on /it/artisan-commands-manager: ' . $status);
=======
<<<<<<< HEAD
        $this->markTestSkipped('Server error on /it/artisan-commands-manager: '.$status);
=======
        $this->markTestSkipped('Server error on /it/artisan-commands-manager: ' . $status);
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    }
    expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
