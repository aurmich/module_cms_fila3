<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit;

use Tests\TestCase;

/**
 * Test per il dashboard del CMS.
 */
class DashboardTest extends TestCase
{
    /**
     * Test della rotta home.
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
     * Test della rotta di login.
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
