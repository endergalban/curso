<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use DB;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|confirmed',
          'bio' => 'required|string|max:1000',
          'profession_id' => Rule::exists('professions', 'id')->where('selectable', true),
          'twitter' => '',
          'skills' => ['array',  Rule::exists('skills', 'id')],
          'role' => 'in:admin,user',
        ];
    }

    public function createUser()
    {
      DB::transaction(function (){
        $user = User::create([
          'name' => $this->name,
          'email' => $this->email,
          'role' => $this->role ?? 'user',
          'password' => bcrypt($this->password),
        ]);
        $user->profile()->create([
          'bio' => $this->bio,
          'twitter' => $this->twitter,
          'profession_id' => $this->profession_id,
        ]);
        $user->skills()->attach($this->skills);
      });
    }
}
