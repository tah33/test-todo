<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    public function test_successful_logout()
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
                ->waitFor('.table-hover', 5)
                ->click('.nav-link')
                ->pause(1000)
                ->click('[data-test="sign-out"]')
                ->waitForText('Login',5)
                ->assertPathIs('/login')
            ;
        });
    }

}
