<?php

declare(strict_types=1);

describe('URL Localization', function () {
    it('homepage renders links prefixed by current locale', function () {
        $response = $this->get('/it');
        
        $response->assertStatus(200);
        $response->assertSee('it/');
    });

    it('generates localized url for a content page', function () {
        $response = $this->get('/it/about');
        
        $response->assertStatus(200);
        $response->assertSee('it/');
    });
});
