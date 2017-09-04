<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Exceptions\LoginFailed;
use App\Http\Controllers\Api\Admin\AdminController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Lang;
use Auth;

class LoginController extends AdminController
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web_admin')->only('logout');
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'user_name';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $username = $this->username();
        $this->validate($request, [
            $username => ['required', 'alpha_dash'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            $username . '.required' => '请输入用户名',
            $username . '.alpha_dash' => '用户名只允许包含字母、数字、破折号（ - ）以及下划线（ _ ）',
            $username . '.between' => '用户名只能在2到10个字符之间',
            'password.required' => '请输入密码',
            'password.min' => '密码最少6位',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->response->noContent();
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw new LoginFailed(trans('auth.admin_failed'));
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        throw new HttpException(423, Lang::get('auth.throttle', ['seconds' => $seconds]));
    }

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
