<?php

namespace Inferno\Foundation\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ValidatesRequests, AuthorizesRequests, DispatchesJobs;

    /**
     * This is the function to return the credentials from
     * the request object. Added the status code as well.
     */
    public function getCustomCredentials(Request $request)
    {
        $request->request->add(['active' => 1]);
        return $request->only($this->username(), 'password', 'active');
    }
}
