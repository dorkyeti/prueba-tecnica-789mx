<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->user()->cannot('ver usuarios'))
            return redirect('home');

        $roles = Role::orderBy('name', 'asc')->get(['name', 'id']);

        return view('users', compact('roles'));
    }
}
