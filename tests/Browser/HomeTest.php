<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ApiPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Pages\RegisterPage;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    public function testMain(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                    ->assertSee(config('app.name'));
        });
    }

    public function testApi(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ApiPage());
        });
    }

    public function testLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->clickLink(__('Login'))
                ->on(new LoginPage());
        });
    }

    public function testRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->clickLink(__('Register'))
                ->on(new RegisterPage());
        });
    }
}
