<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profession;
use App\Models\Skill;

class CreateUsersTest extends TestCase
{
  use RefreshDatabase;
  protected $profession;
  /** @test **/
  function nuevo_usuario()
  {
    $profession = factory(Profession::class)->create();
    $skillA = factory(Skill::class)->create();
    $skillB = factory(Skill::class)->create();
    $this->get('users/create')
      ->assertStatus(200)
      ->assertSee("Nuevo usuario")
      ->assertViewHas('professions', function ($professions) use ($profession) {
        return $professions->contains($profession);
      })
      ->assertViewHas('skills', function ($skills) use ($skillA, $skillB) {
        return $skills->contains($skillA) && $skills->contains($skillB);
      });
  }
  /** @test **/
  function guardar_usuario()
  {
    $this->withoutExceptionHandling();
    $skillA = factory(Skill::class)->create();
    $skillB = factory(Skill::class)->create();
    $skillC = factory(Skill::class)->create();

    $this->post('users', $this->getValidData([
      'skills' => [$skillA->id, $skillB->id]
    ]))
      ->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
      'role' => 'user',
    ]);
    $user = User::where('email','endergalban@gmail.com' )->first();
    $this->assertDatabaseHas('user_profiles', [
      'bio' => 'Programador Laravel',
      'twitter' => 'https:twitter.com/endergalban',
      'user_id' => $user->id,
      'profession_id' => $this->profession->id,
    ]);
    $this->assertDatabaseHas('user_skill', [
      'user_id' => $user->id,
      'skill_id' => $skillA->id
    ])->assertDatabaseHas('user_skill', [
      'user_id' => $user->id,
      'skill_id' => $skillB->id
    ])->assertDatabaseMissing('user_skill', [
      'user_id' => $user->id,
      'skill_id' => $skillC->id
    ]);
  }
  /** @test **/
  function guardar_usuario_sin_twitter()
  {
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
  // function guardar_usuario_sin_role()
  // {
  //   $this->post('users', $this->getValidData([
  //     'role' => ''
  //   ]))->assertRedirect(route('users.index'));
  //
  //   $this->assertDatabaseHas('users', [
  //     'name' => 'Ender Galban',
  //     'email' => 'endergalban@gmail.com',
  //   ]);
  //   $this->assertDatabaseHas('user_profiles', [
  //     'bio' => 'Programador Laravel',
  //     'twitter' => null,
  //     'user_id' => User::first()->id,
  //   ]);
  // }
  /** @test **/
  function guardar_usuario_sin_profession_id()
  {
    $this->post('users', $this->getValidData([
      'profession_id' => null
    ]))->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
    ]);
    $this->assertDatabaseHas('user_profiles', [
      'bio' => 'Programador Laravel',
      'user_id' => User::first()->id,
      'profession_id' => null
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
  function requerir_profession_valida()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'profession_id' => '999',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['profession_id']);
    $this->assertDatabaseMissing('users', [
        'email' => 'endergalban@gmail.com',
    ]);
  }
  /** @test **/
  function requerir_role_valido()
  {
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'role' => 'sadasda',
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['role']);
    $this->assertDatabaseMissing('users', [
        'email' => 'endergalban@gmail.com',
    ]);
  }
  /** @test **/
  function requerir_skill_valido()
  {
    // $this->withoutExceptionHandling();
    $skillA = factory(Skill::class)->create();
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'skills' => [$skillA->id, $skillA->id + 1],
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['skills']);
    $this->assertDatabaseMissing('users', [
        'email' => 'endergalban@gmail.com',
    ]);
  }
  /** @test **/
  function solo_profession_selecionada_valida()
  {
    $professionNoseleccionable = factory(Profession::class)->create([
        'selectable' => false,
    ]);
    $this->from(route('users.create'))->post('users', $this->getValidData([
      'profession_id' => $professionNoseleccionable->id,
    ]))->assertRedirect(route('users.create'))
      ->assertSessionHasErrors(['profession_id']);
    $this->assertDatabaseMissing('users', [
        'email' => 'endergalban@gmail.com',
    ]);
  }

  private function getValidData(array $custom = [])
  {
    $this->profession = factory(Profession::class)->create();
    return array_filter(array_merge([
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
      'password' => '123456',
      'password_confirmation' => '123456',
      'bio' => 'Programador Laravel',
      'profession_id' => $this->profession->id,
      'twitter' => 'https:twitter.com/endergalban',
      // 'role' => 'user',
    ], $custom));
  }
}
