<?php

use Illuminate\Database\Seeder;
use App\Models\Profession;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profession = Profession::get()->random();

        $user = factory(User::class)->create([
            'name' => 'Ender Galban',
            'email' => 'endergalban@gmail.com',
            'role' => 'admin',
            'password' => '$2y$10$qMvo/bCdk6Rc7mguZkKkRO6zz4xulBZwh8GgK8xEFRCLYy6ahcGjK',
        ]);

        $user->profile()->create([
          'profession_id' => $profession->id,
          'bio' => 'fsfsf',
        ]);

        factory(User::class, 5)->create()->each(function ($user){
          $user->profile()->create(
            factory(\App\Models\UserProfile::class)->raw()
          );
        });
    }
}
