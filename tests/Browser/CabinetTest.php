<?php

namespace Tests\Browser;

use App\Common\Models\Publisher;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CabinetPage;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Pages\RegisterPage;
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
                ->type('password', env('SEEDER_PUBLISHER_PASSWORD'))
                ->click('@btn-submit')
                ->waitForReload(function (Browser $browser){
                    $browser->on(new CabinetPage());
                });
        });
    }

}
