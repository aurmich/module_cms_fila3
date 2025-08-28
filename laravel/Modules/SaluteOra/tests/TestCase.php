<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests;

use Tests\TestCase as BaseTestCase;

/**
 * TestCase specifico per il modulo SaluteOra.
 * Estende il TestCase principale per ereditare la configurazione di base.
 */
abstract class TestCase extends BaseTestCase
{
    // Il TestCase principale gestisce già tutta la configurazione necessaria
    // inclusi database, session, cache e altre configurazioni di test
}