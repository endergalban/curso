<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profession;
use App\Models\UserProfile;

class UpdateUsersTest extends TestCase
{
  use RefreshDatabase;
  protected $profession;
  /** @test **/
  // function editar_usuario_invalido()
  // {
  //   $this->withExceptionHandling();
  //   $this->get("users/1000/edit")
  //     ->assertStatus(404)
  //     ->assertSee("Not Found");
  // }
  // /** @test **/
  // function editar_usuario()
  // {
  //   $user = factory(User::class)->create();
  //   $this->get("users/{$user->id}/edit")
  //     ->assertStatus(200)
  //     ->assertViewIs('users.edit')
  //     ->assertViewHas('user', function ($userView) use ($user) {
  //       return $userView->id == $user->id;
  //     });
  // }
  // /** @test **/
  // function actualizar_usuario_requerir_nombre()
  // {
  //   $user = factory(User::class)->create();
  //   $this->from("users/{$user->id}/edit")
  //     ->put("users/{$user->id}", [
  //       'name' => '',
  //       'email' => 'endergalban@gmail.com',
  //     ])
  //     ->assertRedirect(route('users.edit', $user->id))
  //     ->assertSessionHasErrors(['name']);
  // }
  // /** @test **/
  // function actualizar_usuario_requerir_email()
  // {
  //   $user = factory(User::class)->create();
  //   $this->from("users/{$user->id}/edit")
  //     ->put("users/{$user->id}", [
  //       'name' => 'Ender Galban',
  //       'email' => '',
  //     ])->assertRedirect(route('users.edit', $user->id))
  //     ->assertSessionHasErrors('email');
  // }
  // /** @test **/
  // function actualizar_usuario_sin_duplicado()
  // {
  //   factory(User::class)->create([
  //     'email' => 'endergalban@gmail.com',
  //     'name' => 'Ender Galban'
  //   ]);
  //   $user = factory(User::class)->create();
  //   $this->from("users/{$user->id}/edit")
  //     ->put("users/{$user->id}", [
  //     'name' => 'Ender Galban',
  //     'email' => 'endergalban@gmail.com',
  //   ])->assertRedirect(route('users.edit', $user->id))
  //     ->assertSessionHasErrors('email');
  // }
  /** @test **/
  // function actualizar_usuario()
  // {
  //   $user = factory(User::class)->create([
  //     'name' => 'Ender Galban',
  //     'email' => 'endergalban@gmail.com',
  //   ]);
  //   UserProfile::create([
  //     'user_id' => $user->id,
  //     'bio' => 'Analista Programador',
  //     'twitter' => 'https://twitter.com/endergalban',
  //   ]);
  //   $this->from("users/{$user->id}/edit")
  //     ->put("users/{$user->id}", $this->getValidData())
  //     ->assertRedirect(route('users.show', $user->id));
  //   $this->assertDatabaseHas('users', [
  //     'name' => 'Ender Galban',
  //     'email' => 'endergalban@gmail.com',
  //   ]);
  // }


  // private function getValidData(array $custom = [])
  // {
  //   $this->profession = factory(Profession::class)->create();
  //   return array_filter(array_merge([
  //     'name' => 'Ender Galban',
  //     'email' => 'endergalban@gmail.com',
  //     'password' => '123456',
  //     'password_confirmation' => '123456',
  //     'bio' => 'Programador Laravel',
  //     'profession_id' => $this->profession->id,
  //     'twitter' => 'https:twitter.com/endergalban',
  //   ], $custom));
  // }
}
