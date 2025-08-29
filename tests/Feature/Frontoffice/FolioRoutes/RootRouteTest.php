<?php

declare(strict_types=1);

uses(\Modules\Cms\Tests\TestCase::class);

it('GET / redirects to /{locale}', function (): void {
    $locale = app()->getLocale();
    $this->get('/')->assertRedirect('/' . $locale);
});
