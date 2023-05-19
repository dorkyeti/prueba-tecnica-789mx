<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle permission
     *
     * @return void
     **/
    protected function handlePermissions(array $permissions)
    {
        if (count($permissions) == 0)
            return;

        foreach ($permissions as $permission => $method) {
            $this->middleware("permission:{$permission},web", ['only' => $method]);
        }
    }
}
