<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic test example.
     */
<<<<<<< HEAD
    public function testRouteHome(): void
=======
    public function test_route_home(): void
>>>>>>> feb96d7 (.)
    {
        $testResponse = $this->get('/');

        $testResponse->assertSuccessful();
        $testResponse->assertViewIs('pub_theme::home');
    }

    /**
     * A basic test example.
     */
<<<<<<< HEAD
    public function testRouteLogin(): void
=======
    public function test_route_login(): void
>>>>>>> feb96d7 (.)
    {
        $testResponse = $this->get('/it/login');

        $testResponse->assertSuccessful();
        $testResponse->assertViewIs('pub_theme::auth.login');
    }
}
