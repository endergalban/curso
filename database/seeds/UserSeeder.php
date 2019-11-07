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
        $professions = Profession::all();

        $user = factory(User::class)->create([
            'name' => 'Ender Galban',
            'email' => 'endergalban@gmail.com',
            'role' => 'admin',
            'password' => '$2y$10$qMvo/bCdk6Rc7mguZkKkRO6zz4xulBZwh8GgK8xEFRCLYy6ahcGjK',
        ]);

        $user->profile()->create([
          'profession_id' => $professions->firstWhere('title', 'BackEnd Developer')->id,
          'bio' => 'fsfsf',
        ]);

        factory(User::class, 20)->create()->each(function ($user) use ($professions) {
          $user->profile()->create([
            'profession_id' => rand(0, 2) ? $professions->random()->id : null,
            'bio' => ''
          ]);
        });
    }
}
