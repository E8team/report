<?php

namespace App\Http\Controllers\Api\Admin\Auth;


use App\Http\Controllers\Api\Admin\AdminController;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Auth;

class RegisterController extends AdminController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest:web_admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['required', 'alpha_dash', 'between:2,10', 'unique:users'],
            'name' => ['required', 'string', 'max:20'],
            'password' => 'required|string|min:6|confirmed',
            'department_id' => ['required', Rule::exists('department_classes', 'id')->where('parent_id', 0)],
            'role' => ['required', 'in:dz,xsh']
        ], [
            'user_name.required' => '请输入用户名',
            'user_name.alpha_dash' => '用户名只允许包含字母、数字、破折号（ - ）以及下划线（ _ ）',
            'user_name.between' => '用户名只能在2到10个字符之间',
            'name.required' => '请输入姓名',
            'name.regex' => '姓名输入有误',
            'name.max' => '姓名不能超过20字',
            'password.required' => '请输入密码',
            'password.min' => '密码最少6位',
            'password.confirmed' => '两次密码输入不一致',
            'department_id.required' => '请选择学院',
            'department_id.exists' => '所选学院不存在',
            'role.required' => '请选择部门',
            'role.in' => '所选部门不存在',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'user_name' => $data['user_name'],
            'name' => e($data['name']),
            'password' => bcrypt($data['password']),
            'department_id' => $data['department_id']
        ]);
        // todo 这里写死了
        $roleId = $data['role'] == 'xsh' ? 2 : 3;
        $user->roles()->save(['role_id' => $roleId]);

    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return $this->response->noContent();
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web_admin');
    }

}
