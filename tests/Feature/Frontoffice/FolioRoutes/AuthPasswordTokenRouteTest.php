<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

uses(\Modules\Cms\Tests\TestCase::class);

it('SKIP dynamic /it/auth/password/{token}', function (): void {
    $this->markTestSkipped('Dynamic token route requires fixture.');
});
