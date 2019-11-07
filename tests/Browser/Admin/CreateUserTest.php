<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use App\Models\Profession;
use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_usuario_puede_ser_creado()
    {
        $profession = factory(Profession::class)->create();
        $this->browse(function (Browser $browser) use ($profession) {
            $browser->visit('users/create')
                ->type('name', 'Ender Galban')
                ->type('email', 'endergalban@gmail.com')
                ->type('password', '123456')
                ->type('password_confirmation', '123456')
                ->select('profession_id', $profession->id)
                ->type('twitter', 'https://twitter/endergalban')
                ->type('bio', 'bio')
                ->press('REGISTRAR')
                ->assertPathIs('/users')
                ->assertSee('Ender Galban')
                ->assertSee('endergalban@gmail.com');
        });

        $user = User::where('email', 'endergalban@gmail.com')->first();
        $this->assertDatabaseHas('user_profiles', [
          'twitter' => 'https://twitter/endergalban',
          'bio' => 'bio',
          'profession_id' => $profession->id,
          'user_id' => $user->id,
        ]);
    }
}
