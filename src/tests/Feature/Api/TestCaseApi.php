<?php

namespace Tests\Feature\Api;

use App\Common\Service\SiteSide;
use Tests\TestCase;

abstract class TestCaseApi extends TestCase
{
    protected function setUp(): void
    {
        SiteSide::getInstance(isApi: true);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        SiteSide::flush();
        parent::tearDown();
    }
}
