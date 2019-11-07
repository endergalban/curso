<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserFilter;
use App\Models\Profession;
use App\Models\UserProfile;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Forms\UserForm;
use App\Sortable;

class UserController extends Controller
{
  public function index(Request $request, UserFilter $filters, Sortable $sortable)
  {
    $users = User::filterBy(
            $filters,
            $request->only(['search', 'created_at', 'skills', 'from', 'to', 'order'])
        )
        ->orderByDesc('created_at')
        ->paginate();
    $users->load('profile.profession');

    $users->appends($filters->valid());
    $sortable->appends($filters->valid());

    $title = "Lista de usuarios";

    return view('users.index', compact('users', 'title', 'sortable'));
  }

  public function show(User $user)
  {
    return view('users.show', compact('user'));
  }

  public function create()
  {
    return new UserForm('users.create', new User);
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

  public function update(UpdateUserRequest $request)
  {
    $user = $request->update();

    return redirect()->route('users.show', $user);
  }

  public function destroy(User $user)
  {
    $user->delete();

    return redirect()->route('users.index');
  }

}
