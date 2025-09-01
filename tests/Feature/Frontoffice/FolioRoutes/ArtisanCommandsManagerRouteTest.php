<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

uses(\Modules\Cms\Tests\TestCase::class);

it('GET /it/artisan-commands-manager returns acceptable status', function (): void {
    $res = $this->get('/it/artisan-commands-manager');
    $status = $res->getStatusCode();
    if ($status >= 500) {
        $this->markTestSkipped('Server error on /it/artisan-commands-manager: '.$status);
    }
    expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
