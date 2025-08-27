<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;

uses(TestCase::class);

describe('Homepage Business Logic', function () {
    it('redirects root path to localized homepage', function () {
        $response = $this->get('/');

        // BUSINESS BEHAVIOR: Root redirect per localizzazione
        $response->assertStatus(302);
    });

    it('serves localized homepage content', function () {
        $lang = app()->getLocale();

        $response = $this->get('/'.$lang);

        // BUSINESS BEHAVIOR: Homepage localizzata accessibile
        $response->assertStatus(200);
    });

    it('has localized routing structure', function () {
        // BUSINESS BEHAVIOR: Sistema supporta localizzazione
        $locale = app()->getLocale();
        expect($locale)->toBeString()
            ->and(strlen($locale))->toBeGreaterThan(0);
    });
});
