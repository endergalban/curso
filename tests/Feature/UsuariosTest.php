<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UsuariosTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    function lista_de_usuarios()
    {
        factory(User::class)->create([
            'name' => 'Ender'
        ]);
        factory(User::class, 19)->create();

        $this->get('users')
            ->assertStatus(200)
            ->assertSee('Ender');
    }
    /**
     * @test
     */
    function lista_de_usuarios_vacia()
    {

        $this->get('users')
            ->assertStatus(200)
            ->assertSee('No existen usuarios');
    }
    /**
     * @test
     */
    function ver_usuario()
    {
        $user = factory(User::class)->create([
            'name' => 'Ender'
        ]);

        $this->get('users/'.$user->id)
            ->assertStatus(200)
            ->assertSee("Mostrando el usuario Ender");
    }

    /**
     * @test
     */
    function ver_invalido_usuario()
    {

        $this->get('users/1000')
            ->assertStatus(404)
            ->assertSee("Not Found");
    }
    /**
    * @test
    */
    function nuevo_usuario()
    {
        $this->get('users/create')
        ->assertStatus(200)
        ->assertSee("Nuevo usuario");
    }
    /**
    * @test
    */
    function guardar_usuario()
    {

        $this->post('users', [
            'name' => 'Ender Galban',
            'email' => 'endergalban@gmail.com',
            'password' => '123456',
        ])->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Ender Galban',
            'email' => 'endergalban@gmail.com',
        ]);
        // $this->assertCredentials([
        //     'name' => 'Ender Galban',
        //     'email' => 'endergalban@gmail.com',
        //     'password' => '123456',
        // ]);
    }

    /**
    * @test
    */
    function requerir_usuario_name()
    {
        $this->from(route('users.create'))->post('users', [
            'name' => '',
            'email' => 'endergalban@gmail.com',
            'password' => '123456',
        ])->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', [
            'email' => 'endergalban@gmail.com',
        ]);

    }

}
