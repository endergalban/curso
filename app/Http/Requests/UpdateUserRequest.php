<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use DB;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        'user_id' => 'required|exists:users,id',
        'name' => 'required',
        'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id, 'id')],
        'password' => 'nullable',
        'bio' => 'required|string|max:1000',
        'profession_id' => [Rule::exists('professions', 'id')->where('selectable', true)],
        'twitter' => '',
        'role' => 'in:admin,user',
        'skills' => '',
      ];
    }

    public function update()
    {
      $data = $this->validated();
      // DB::transaction(function () {
        $user = User::find($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        if ($this->password) {
          $user->password = bcrypt($this->password);
        }
        $user->save();
        $profile = $user->profile;
        if ($profile) {
          $profile->bio = $this->bio;
          $profile->profession_id = $this->profession_id;
          if ($this->twitter) {
            $profile->twitter = $this->twitter;
          }
        }
        $profile->save();
        if ($this->skills) {
            $user->skills()->sync($this->skills);
        }
      // });

      return $user;
    }
}
