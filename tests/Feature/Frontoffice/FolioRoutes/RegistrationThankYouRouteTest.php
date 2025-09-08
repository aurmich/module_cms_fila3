<?php

declare(strict_types=1);

uses(\Modules\Cms\Tests\TestCase::class);

it('GET /it/registration/thank-you acceptable', function (): void {
    $res = $this->get('/it/registration/thank-you');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
