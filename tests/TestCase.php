<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Track initial output buffer level to avoid interfering with framework buffers
    protected int $initialObLevel = 0;

    protected function setUp(): void
    {
        parent::setUp();
        $this->initialObLevel = ob_get_level();
    }

    protected function tearDown(): void
    {
        // Close only buffers opened during the test, leave framework buffers intact
        while (ob_get_level() > $this->initialObLevel) {
            @ob_end_clean();
        }

        parent::tearDown();
    }
}
