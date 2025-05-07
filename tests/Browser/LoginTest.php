<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_validation_errors()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit('/login')
                    ->assertSee('Log In')
                    ->press('Login')
                    ->waitFor('.text-danger', 5);
            });
    }

    public function test_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);
        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->visit('/login')
                    ->assertSee('Log In')
                    ->type('email', $user->email)
                    ->type('password', '')
                    ->press('Login')
                    ->waitFor('.text-danger', 5);
            });
    }

    public function test_successful_login()
    {
        $user = User::factory()->create([
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->assertSee('Log In')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->waitUntilMissing('.spinner-border', 5)
                ->waitFor('.table-hover', 5);
        });
    }

}
