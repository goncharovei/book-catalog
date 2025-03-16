<?php

namespace Tests\Browser;

use App\Common\Models\Publisher;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CabinetPage;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;

class CabinetTest extends DuskTestCase
{
    public function testLogin(): void
    {
        $this->browse(function (Browser $browser) {
            /**
             * @var Publisher $publisher
             */
            $publisher = Publisher::first();
            $browser->visit(new LoginPage())
                ->type('email', $publisher->email)
                ->type('password', env('PUBLISHER_DEFAULT_PASSWORD'))
                ->click('@btn-submit')
                ->waitForRoute('publisher.cabinet.index')
                ->on(new CabinetPage());
        });
    }

}
