<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogOutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->session()->flush();

        return redirect('login');
    }
}
