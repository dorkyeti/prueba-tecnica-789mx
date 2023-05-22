<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('register');
    }

    /**
     * Handle the incoming request.
     */
    public function action(Request $request)
    {
        $data = $request->validate([
            'name'      =>  ['required', 'string'],
            'email'     =>  ['required', 'email', 'unique:users'],
            'password'  =>  ['required', 'min:8']
        ]);

        $user = User::create($data);

        if (!$user->exists)
            return back()->with('error', 'Error registrando al usuario');

        $user->assignRole('Operador');

        if (!Auth::attempt($data))
            return back()->with('error', 'Error al intentar logear al usuario');

        $request->session()->regenerate();

        return redirect()->intended('home');
    }
}
