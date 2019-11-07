<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create(['title' => 'BackEnd Developer']);
        Profession::create(['title' => 'FrontkEnd Developer']);
        Profession::create(['title' => 'FrontkEnd Designer']);

        factory(Profession::class, 7)->create();

    }

}
