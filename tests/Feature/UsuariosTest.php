<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UsuariosTest extends TestCase
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
    $this->get('users/1000')
      ->assertStatus(404)
      ->assertSee("Not Found");
  }
  /** @test **/
  function nuevo_usuario()
  {
    $this->get('users/create')
      ->assertStatus(200)
      ->assertSee("Nuevo usuario");
  }
  /** @test **/
  function guardar_usuario()
  {
    $this->withoutExceptionHandling();
    $this->post('users', $this->getValidData())
      ->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
    ]);
    $this->assertDatabaseHas('user_profiles', [
      'bio' => 'Programador Laravel',
      'twitter' => 'https:twitter.com/endergalban',
      'user_id' => User::first()->id,
    ]);
  }
  /** @test **/
  function guardar_usuario_sin_twitter()
  {
    $this->withoutExceptionHandling();
    $this->post('users', $this->getValidData([
      'twitter' => ''
    ]))->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
    ]);
    $this->assertDatabaseHas('user_profiles', [
      'bio' => 'Programador Laravel',
      'twitter' => null,
      'user_id' => User::first()->id,
    ]);
  }
  /** @test **/
  function requerir_usuario_name()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'name' => '',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['name']);
    $this->assertDatabaseMissing('users', [
        'email' => 'endergalban@gmail.com',
    ]);
  }
  /** @test **/
  function requerir_usuario_email()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'email' => '',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['email']);
    $this->assertEquals(0, User::count());
  }
  /** @test **/
  function requerir_usuario_email_valido()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'email' => 'rewwr',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['email']);
    $this->assertEquals(0, User::count());
  }
  /** @test **/
  function requerir_usuario_email_unico()
  {
    // $this->withoutExceptionHandling();
    factory(User::class)->create([
      'email' => 'endergalban@gmail.com'
    ]);
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'email' => 'endergalban@gmail.com',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['email']);
    $this->assertEquals(1, User::count());
  }
  /** @test **/
  function requerir_usuario_password()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'password' => 'endergalban@gmail.com',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['password']);
    $this->assertEquals(0, User::count());
  }
  /** @test **/
  function requerir_usuario_password_confirmacion()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'password' => '423342',
      'password_confirmation' => '123456',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['password']);
    $this->assertEquals(0, User::count());
  }
  /** @test **/
  function editar_usuario_invalido()
  {
    $this->get("users/1000/edit")
      ->assertStatus(404)
      ->assertSee("Not Found");
  }
  /** @test **/
  function editar_usuario()
  {
    $user = factory(User::class)->create();
    $this->get("users/{$user->id}/edit")
      ->assertStatus(200)
      ->assertViewIs('users.edit')
      ->assertViewHas('user', function ($userView) use ($user) {
        return $userView->id == $user->id;
      });
  }
  /** @test **/
  function actualizar_usuario_requerir_nombre()
  {
    // $this->withoutExceptionHandling();
    $user = factory(User::class)->create();
    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}", [
        'name' => '',
        'email' => 'endergalban@gmail.com',
      ])
      ->assertRedirect(route('users.edit', $user->id))
      ->assertSessionHasErrors(['name']);
  }
  /** @test **/
  function actualizar_usuario_requerir_email()
  {
    // $this->withoutExceptionHandling();
    $user = factory(User::class)->create();
    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}", [
        'name' => 'Ender Galban',
        'email' => '',
      ])->assertRedirect(route('users.edit', $user->id))
      ->assertSessionHasErrors('email');
  }
  /** @test **/
  function actualizar_usuario_sin_duplicado()
  {
    // $this->withoutExceptionHandling();
    factory(User::class)->create([
      'email' => 'endergalban@gmail.com'
    ]);
    $user = factory(User::class)->create();
    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}", [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
    ])->assertRedirect(route('users.edit', $user->id))
      ->assertSessionHasErrors('email');
  }
  /** @test **/
  function actualizar_usuario()
  {
    // $this->withoutExceptionHandling();
    $user = factory(User::class)->create([
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
    ]);
    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}", [
        'name' => 'Ender Galban',
        'email' => 'endergalban@gmail.com',
      ])
      ->assertRedirect(route('users.show', $user->id));
    $this->assertDatabaseHas('users', [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
    ]);
  }
  /** @test **/
  function eliminar_usuario()
  {
    // $this->withoutExceptionHandling();
    $user = factory(User::class)->create();
    $this->from("users")
      ->delete("users/{$user->id}")
      ->assertRedirect(route('users.index'));
    $this->assertDatabaseMissing('users', [
      'id' => $user->id
    ]);
  }

  private function getValidData(array $custom = [])
  {
    return array_filter(array_merge([
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
      'password' => '123456',
      'password_confirmation' => '123456',
      'bio' => 'Programador Laravel',
      'twitter' => 'https:twitter.com/endergalban',
    ], $custom));
  }

}
