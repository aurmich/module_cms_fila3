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

it('GET /it/patient/referto acceptable', function (): void {
    $res = $this->get('/it/patient/referto');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
