<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navigation;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Pages\RegisterPage;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    public function testMainShow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                    ->assertSee(config('app.name'));
        });
    }

    public function testApiLink(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())->within(new Navigation(), function (Browser $browser) {
                $browser->assertSee('API');
            });
        });
    }

    public function testLoginShow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->clickLink(__('Login'))
                ->on(new LoginPage());
        });
    }

    public function testRegisterShow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->clickLink(__('Register'))
                ->on(new RegisterPage());
        });
    }
}
