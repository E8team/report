<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Api\ApiController;
use Auth;

class AdminController extends ApiController
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web_admin');
    }
}