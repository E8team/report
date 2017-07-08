<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends ApiController
{
    use AuthenticatesUsers;

}