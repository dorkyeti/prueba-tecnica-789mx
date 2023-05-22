<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LogOutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        Auth::logout();

        return redirect('login');
    }
}
