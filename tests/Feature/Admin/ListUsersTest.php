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

  /** @test **/
  function ver_usuarios_paginados()
  {
    $user = factory(User::class)->create([
      'name' => 'endergalban@gmail1.com'
    ]);
    $user = factory(User::class, 14)->create();

    $user = factory(User::class)->create([
      'name' => 'endergalban@gmail.com'
    ]);

    $this->get('users?page=2')
    ->assertStatus(200)
    ->assertDontSee("endergalban@gmail1.com")
    ->assertSee("endergalban@gmail.com");
  }

  /** @test **/
  function filtrar_por_rango_desde()
  {
    $user = factory(User::class)->create([
      'created_at' => '2019-07-27 12:00:00'
    ]);
    $newUser = factory(User::class)->create([
      'created_at' => '2019-07-27 12:00:00'
    ]);
    $oldUser = factory(User::class)->create([
      'created_at' => '2019-07-26 00:00:00'
    ]);
    $oldestUser = factory(User::class)->create([
      'created_at' => '2019-07-25 12:00:00'
    ]);

    $this->get('users?from=27-07-2019')
    ->assertStatus(200)
    ->assertSee($user->name)
    ->assertSee($newUser->name)
    ->assertDontSee($oldUser->name)
    ->assertDontSee($oldestUser->name);

  }

  /** @test **/
  function filtrar_por_rango_hasta()
  {
    $user = factory(User::class)->create([
      'created_at' => '2019-07-27 12:00:00'
    ]);
    $newUser = factory(User::class)->create([
      'created_at' => '2019-07-27 12:00:00'
    ]);
    $oldUser = factory(User::class)->create([
      'created_at' => '2019-07-26 00:00:00'
    ]);
    $oldestUser = factory(User::class)->create([
      'created_at' => '2019-07-25 12:00:00'
    ]);

    $this->get('users?to=26-07-2019')
    ->assertStatus(200)
    ->assertDontSee($user->name)
    ->assertDontSee($newUser->name)
    ->assertSee($oldUser->name)
    ->assertSee($oldestUser->name);

  }
  /** @test */
  function users_are_ordered_by_name()
  {
      factory(User::class)->create(['name' => 'Ender']);
      factory(User::class)->create(['name' => 'Karla']);
      factory(User::class)->create(['name' => 'Eduardo']);

      $this->get('/users?order=name')
          // ->dump()
          ->assertSeeInOrder([
              'Eduardo',
              'Ender',
              'Karla',
          ]);

      $this->get('/users?order=name-desc')
          ->assertSeeInOrder([
              'Karla',
              'Ender',
              'Eduardo',
          ]);
  }

  /** @test */
    function invalid_order_query_data_is_ignored_and_the_default_order_is_used_instead()
    {
        factory(User::class)->create(['name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        factory(User::class)->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        factory(User::class)->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);
        $this->get('/users?order=id')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
        $this->get('/users?order=invalid_column-desc')
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
    }
}
