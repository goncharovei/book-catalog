<?php

namespace Front;

use App\Common\Models\Publisher;
use Tests\Feature\Front\TestCaseFront;

class CabinetTest extends TestCaseFront
{
    public function testIndex(): void
    {
        $publisher = Publisher::factory()->create();
        $this->actingAs($publisher)
            ->get(route('publisher.cabinet.index'))->assertOk();
    }

    public function testRefresh(): void
    {
        $publisher = Publisher::factory()->create();
        $response = $this->actingAs($publisher)
            ->postJson(route('publisher.cabinet.token-refresh'));

        $response->assertOk()->assertJsonStructure(['token']);
    }

    public function testRevoke(): void
    {
        $publisher = Publisher::factory()->create();
        $response = $this->actingAs($publisher)
            ->deleteJson(route('publisher.cabinet.token-revoke'))->assertOk();

        $response->assertOk()->assertJsonStructure([]);
    }

}
