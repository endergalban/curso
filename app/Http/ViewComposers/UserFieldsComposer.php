<?php

namespace App\Http\ViewComposers;

use App\Models\Skill;
use App\Models\Profession;
use Illuminate\Contracts\View\View;

class UserFieldsComposer
{
    public function compose(View $view)
    {
        $professions = Profession::orderBy('title', 'ASC')->get();
        $skills = Skill::orderBy('name', 'ASC')->get();
        $roles = ['admin' => 'Administrador', 'user' => 'Usuario'];
        $view->with(compact('professions', 'skills', 'roles'));
    }
}
