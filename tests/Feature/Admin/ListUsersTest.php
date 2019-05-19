<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ListUsersTest extends TestCase
{
  use RefreshDatabase;
  /** @test **/
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
  /** @test **/
  function lista_de_usuarios_vacia()
  {
    $this->get('users')
      ->assertStatus(200)
      ->assertSee('No existen usuarios');
  }
  /** @test **/
  function ver_usuario()
  {
    $user = factory(User::class)->create();
    $this->get('users/'.$user->id)
      ->assertStatus(200)
      ->assertSee($user->name);
  }

  /** @test **/
  function ver_invalido_usuario()
  {
    $this->withExceptionHandling();
    $this->get('users/1000')
      ->assertStatus(404)
      ->assertSee("Not Found");
  }
}
