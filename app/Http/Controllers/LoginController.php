<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::check())
            return redirect('home');

        return view('login');
    }

    /**
     * Handle the incoming request.
     */
    public function action(Request $request)
    {
        $data = $request->validate([
            'email' =>  ['required', 'email', 'exists:users'],
            'password'  => ['required', 'min:8']
        ]);

        if (!Auth::attempt($data))
            return back()->with('error', 'Error al intentar logear al usuario');

        $request->session()->regenerate();

        return redirect()->intended('home');
    }
}
