<?php


uses(Modules\SaluteOra\Tests\TestCase::class);

it('homepage redirect', function () {
    $response = $this->get('/');
    
    $response->assertStatus(302);
});

it('homepage lang', function () {
    $lang=app()->getLocale();
    
    $response = $this->get('/'.$lang);
    
    $response->assertStatus(200);
});

