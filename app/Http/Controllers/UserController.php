<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

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
    return view('users.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|confirmed',
    ]);
    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    return redirect()->route('users.index');
  }

  public function edit(User $user)
  {
    return view('users.edit', compact('user'));
  }

  public function update(User $user)
  {
    request()->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email,'.$user->id,
    ]);
    $user->fill(request()->all());
    $user->save();

    return redirect()->route('users.show', $user);
  }

  public function destroy(User $user)
  {
    $user->delete();

    return redirect()->route('users.index');
  }

}
