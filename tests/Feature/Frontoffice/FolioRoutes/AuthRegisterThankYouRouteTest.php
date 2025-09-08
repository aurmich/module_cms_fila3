<?php

declare(strict_types=1);

uses(\Modules\Cms\Tests\TestCase::class);

it('GET /it/auth/register/thank-you acceptable', function (): void {
    $res = $this->get('/it/auth/register/thank-you');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
