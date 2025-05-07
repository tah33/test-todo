<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    public function test_validation_errors()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit('/register')
                    ->assertSee('Register')
                    ->press('Register')
                    ->waitFor('.text-danger', 5);
            });
    }

    public function test_successful_registration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('Register')
                ->type('name', fake()->unique()->name())
                ->type('email', fake()->unique()->safeEmail())
                ->type('password', 'password')
                ->press('Register')
                ->waitUntilMissing('.spinner-border', 5)
                ->waitFor('.table-hover', 5);
        });
    }

}
