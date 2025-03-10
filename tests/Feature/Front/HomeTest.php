<?php

namespace Tests\Feature\Front;

use App\Common\Service\SiteSide;
use Tests\TestCase;

class HomeTest extends TestCase
{
    protected function setUp(): void
    {
        SiteSide::getInstance(isFront: true);

        parent::setUp();
    }

    /**
     * A basic feature test example.
     */
    public function testMain(): void
    {
        $this->get(route('book.list'))->assertOk();
    }

    public function testBookList(): void
    {
        $response = $this
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->getJson(route('book.data-table-items'));

        $response->assertOk()->assertJsonStructure([
            'data' => [],
            'input' => []
        ]);
    }

}
