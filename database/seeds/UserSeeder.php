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

        factory(User::class)->create([
            'name' => 'Ender Galban',
            'email' => 'endergalban@gmail.com',
            'password' => bcrypt(123456),
            'profession_id' =>  $profession->id
        ]);

        factory(User::class, 50)->create();
    }
}
