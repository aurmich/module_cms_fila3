<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    // Removed RefreshDatabase to allow simple tests without database
    // Individual tests can add it if needed: use \Illuminate\Foundation\Testing\RefreshDatabase;
}
