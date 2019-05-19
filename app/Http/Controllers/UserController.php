<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\Profession;
use App\Models\UserProfile;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    $title = "Lista de usuarios";

    return view('users.index', compact('users', 'title'));
  }

  public function show(User $user)
  {
    return view('users.show', compact('user'));
  }

  public function create()
  {
    $user = new User;

    return view('users.create')->with(compact('user'));
  }

  public function store(CreateUserRequest $request)
  {
    $request->createUser();

    return redirect()->route('users.index');
  }

  public function edit(User $user)
  {
    return view('users.edit', compact('user'));
  }

  public function update(UpdateUser $request)
  {
    $user = $request->updateUser();

    return redirect()->route('users.show', $user);
  }

  public function destroy(User $user)
  {
    $user->delete();

    return redirect()->route('users.index');
  }

}
