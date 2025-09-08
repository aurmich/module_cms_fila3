<?php

declare(strict_types=1);

uses(\Modules\Cms\Tests\TestCase::class);

it('GET /it/settings acceptable (likely auth required)', function (): void {
    $res = $this->get('/it/settings');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
