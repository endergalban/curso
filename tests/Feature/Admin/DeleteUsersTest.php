<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profession;

class DeleteUsersTest extends TestCase
{
  use RefreshDatabase;
  protected $profession;

  /** @test **/
  function eliminar_usuario()
  {
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
    $profession = factory(Profession::class)->create();
    return array_filter(array_merge([
      'name' => 'Ender Galban',
      'email' => 'endergalban@gmail.com',
      'password' => '123456',
      'password_confirmation' => '123456',
      'bio' => 'Programador Laravel',
      'profession_id' => $profession->id,
      'twitter' => 'https:twitter.com/endergalban',
    ], $custom));
  }
}
