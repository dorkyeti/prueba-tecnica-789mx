<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('roles:name,id')->get(['id', 'name', 'email']);

        $data = $data->map(function ($user) {
            $role = $user->roles->first();

            $user->role = $role->name;
            $user->role_id = $role->id;

            unset($user->roles);

            return $user;
        });

        return json(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  =>  ['required'],
            'email' =>  ['required', 'unique:users', 'email'],
            'password'  =>  ['required', 'min:8'],
            'role'      =>  ['required', 'exists:roles,id']
        ]);

        $user = User::create($request->only('email', 'password', 'name'));
        $user->assignRole($request->role);

        return json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return json(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::with('roles:name,id')->findOrFail($id);

        $request->validate([
            'name'  =>  ['string'],
            'email' =>  ['email', Rule::unique('users')->ignore($user), 'email'],
            'password'  =>  ['nullable', 'min:8'],
            'role'      =>  ['exists:roles,id']
        ]);

        $data = array_filter($request->only('email', 'password', 'name'));

        $user->update($data);

        if ($request->has('role')) {
            $users_admin = User::whereHas('roles', function ($query) {
                $query->where('name', 'Admin');
            })->count();

            $user_role = $user->roles->first();

            if (
                $user_role->name == 'Admin' &&
                $request->role != $user_role->id &&
                $users_admin == 1
            ) {
                return json(['message' => 'El sistema siempre debe tener al menos un administrador'], 500);
            }
            $user->syncRoles($request->role);
        }

        if (!$user->wasChanged() && $request->missing('role'))
            return json(['message' => 'No se pudo hacer el cambio'], 500);

        return nothing();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::with('roles:name,id')->findOrFail($id);

        if ($user->roles->first()->name == 'Admin')
            return json(['message' => 'No se puede eliminar a un usuario administrador'], 500);

        $user->delete();

        if ($user->exists)
            return json(['message' => 'No se pudo eliminar'], 500);

        return nothing();
    }
}
