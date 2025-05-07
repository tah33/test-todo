<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TaskTest extends DuskTestCase
{
    public function test_index()
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
                    ->type('password', 'password')
                    ->press('Login')
                    ->waitUntilMissing('.spinner-border', 5)
                    ->waitFor('.table-hover', 5)
                    ->waitUntilMissing('.text-danger', 5);
            });
    }

    public function test_successful_create()
    {
        $name = fake()->name();
        $this->browse(function (Browser $browser) use($name){
            $browser->visit('/tasks')
                ->waitFor('.table-hover', 5)
                ->waitUntilMissing('.text-danger', 5)
                ->press('+ Add New')
                ->waitFor('.modal-header', 5)
                ->press('Submit')
                ->waitFor('.text-danger', 5)
                ->type('title', $name)
                ->type('description', 'description')
                ->press('Submit')
                ->waitUntilMissing('.spinner-border', 5)
                ->assertSee($name);
        });
    }
    public function test_successful_complete()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->waitFor('.table-hover', 5)
                ->waitUntilMissing('.text-danger', 5)
                ->press('+ Add New')
                ->waitFor('.modal-header', 5)
                ->press('Submit')
                ->waitFor('.text-danger', 5)
                ->type('title', fake()->name())
                ->type('description', 'description')
                ->press('Submit')
                ->waitUntilMissing('.spinner-border', 5)
                ->within('tr:nth-child(2) td:nth-child(4)', function ($row) {
                    $row->press('button')
                        ->waitFor('.dropdown-item', 5)
                        ->press('.dropdown-item:first-child');
                })->within('tr:nth-child(2) td:nth-child(3)', function ($row) {
                    $row->waitFor('.bg-success', 5);
                });
        });
    }

    public function test_successful_edit()
    {
        $name = fake()->name();
        $this->browse(function (Browser $browser) use($name){
            $browser->visit('/tasks')
                ->waitFor('.table-hover', 5)
                ->waitUntilMissing('.text-danger', 5)
                ->press('+ Add New')
                ->waitFor('.modal-header', 5)
                ->press('Submit')
                ->waitFor('.text-danger', 5)
                ->type('title', fake()->name())
                ->type('description', 'description')
                ->press('Submit')
                ->waitUntilMissing('.spinner-border', 5)
                ->within('tbody tr:first-child td:nth-child(4)', function ($row) use($name){
                    $row->press('Action')
                        ->waitFor('.dropdown-item', 5)
                        ->click('[data-test="edit-task"]');
                })->waitFor('.modal-header', 5)
                ->type('title', $name)
                ->type('description', 'description')
                ->press('Submit')
                ->waitUntilMissing('.spinner-border', 5)->assertSee($name);
        });
    }
    public function test_successful_delete()
    {
        $name = fake()->name();
        $this->browse(function (Browser $browser) use($name){
            $rows       = $browser->elements('table tr:not(:first-child)');
            $total_row  = count($rows);

            $browser->visit('/tasks')
                ->waitFor('.table-hover', 5)
                ->waitUntilMissing('.text-danger', 5)
                ->press('+ Add New')
                ->waitFor('.modal-header', 5)
                ->press('Submit')
                ->waitFor('.text-danger', 5)
                ->type('title', fake()->name())
                ->type('description', 'description')
                ->press('Submit')
                ->waitUntilMissing('.spinner-border', 5)
                ->pause(5000)
                ->within('tbody tr:first-child td:nth-child(4)', function ($row) use($name){
                    $row->press('Action')
                        ->waitFor('.dropdown-item', 5)
                        ->click('[data-test="delete-task"]');
                })->acceptDialog()
                ->waitUntilMissing('.alert-danger', 5);
        });
    }

}
