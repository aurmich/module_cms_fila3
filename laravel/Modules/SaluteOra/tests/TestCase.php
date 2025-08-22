<?php

declare(strict_types=1);

// Modules/SaluteOra/Tests/TestCase.php

namespace Modules\SaluteOra\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}