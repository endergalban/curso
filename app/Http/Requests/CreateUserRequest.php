<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use DB;

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
          'twitter' => '',
        ];
    }

    public function createUser()
    {
      $data = $this->validated();
      DB::transaction(function (){
        $user = User::create([
          'name' => $this->name,
          'email' => $this->email,
          'password' => bcrypt($this->password),
        ]);
        $user->profile()->create([
          'bio' => $this->bio,
          'twitter' => $this->twitter,
        ]);
      });
    }
}
