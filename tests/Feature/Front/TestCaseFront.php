<?php

namespace Tests\Feature\Front;

use App\Common\Service\SiteSide;
use Tests\TestCase;

abstract class TestCaseFront extends TestCase
{
    protected function setUp(): void
    {
        SiteSide::getInstance(isFront: true);

        parent::setUp();
    }

}
