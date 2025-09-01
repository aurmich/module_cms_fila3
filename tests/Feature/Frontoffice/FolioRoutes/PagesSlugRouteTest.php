<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

uses(\Modules\Cms\Tests\TestCase::class);

it('SKIP dynamic /it/pages/{slug}', function (): void {
    $this->markTestSkipped('Dynamic pages slug requires fixture.');
});
