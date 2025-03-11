<?php

namespace Tests\Feature\Front;

class HomeTest extends TestCaseFront
{
    public function testMain(): void
    {
        $this->get(route('book.list'))->assertOk();
    }

    public function testGetBookList(): void
    {
        $requestData = [
            'search' => ['value' => 'test']
        ];

        $response = $this
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->getJson(route('book.data-table-items', $requestData));

        $response->assertOk()->assertJsonStructure([
            'data' => [],
            'input' => []
        ]);

    }

}
