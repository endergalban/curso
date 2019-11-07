<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profession;
use App\Models\UserProfile;
use App\Models\Skill;

class UpdateUsersTest extends TestCase
{
  protected $profession;

  protected $defaultData = [
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
      'profession_id' => '',
      'bio' => 'Programador de Laravel y Vue.js',
      'twitter' => 'https://twitter.com/endergalban',
      'role' => 'admin',
  ];


  /** @test **/
  function editar_usuario_invalido()
  {
    $this->withExceptionHandling();
    $this->get("users/1000/edit")
      ->assertStatus(404)
      ->assertSee("Not Found");
  }
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
  /** @test **/
  function actualizar_usuario_requerir_nombre()
  {
    $user = factory(User::class)->create();
    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}", $this->withData([
        'name' => ''
      ]))
      ->assertRedirect(route('users.edit', $user->id))
      ->assertSessionHasErrors(['name']);
  }
  /** @test **/
  function actualizar_usuario_requerir_email()
  {
    $user = factory(User::class)->create();
    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}", $this->withData([
          'email' => ''
        ]))->assertRedirect(route('users.edit', $user->id))
      ->assertSessionHasErrors('email');
  }
  /** @test **/
  function actualizar_usuario_sin_duplicado()
  {
    factory(User::class)->create([
      'email' => 'endergalban@gmail.com',
      'name' => 'Ender Galban'
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
    $user = factory(User::class)->create();

    $oldProfession = factory(Profession::class)->create();
    $user->profile()->save(factory(UserProfile::class)->make([
        'profession_id' => $oldProfession->id
    ]));

    $oldSkill = factory(Skill::class)->create();
    $oldSkill2 = factory(Skill::class)->create();
    $user->skills()->attach([$oldSkill->id, $oldSkill2->id]);

    $newProfession = factory(Profession::class)->create();
    $newSkill = factory(Skill::class)->create();
    $newSkill2 = factory(Skill::class)->create();

    $this->from("users/{$user->id}/edit")
      ->put("users/{$user->id}",[
        'user_id' => $user->id,
        'name' => 'Ender Galban1',
        'email' => 'endergalban@gmail1.com',
        'bio' => 'fdfsd',
        'twitter' => 'https://twitter.com/endergalban',
        'role' => 'user',
        'profession_id' => $newProfession->id,
        'skills' => [
          $newSkill->id,
          $newSkill2->id
        ],
      ])
      ->assertRedirect(route('users.show', $user->id));

    $this->assertDatabaseHas('users', [
      'name' => 'Ender Galban1',
      'email' => 'endergalban@gmail1.com',
      'role' => 'user',
    ]);

    $this->assertDatabaseHas('user_profiles', [
      'user_id' => $user->id,
      'bio' => 'fdfsd',
      'twitter' => 'https://twitter.com/endergalban',
      'profession_id' => $newProfession->id
    ]);

    $this->assertDatabaseHas('user_skill', [
      'user_id' => $user->id,
      'skill_id' => $newSkill->id
    ]);

    $this->assertDatabaseHas('user_skill', [
      'user_id' => $user->id,
      'skill_id' => $newSkill2->id
    ]);
  }
}
