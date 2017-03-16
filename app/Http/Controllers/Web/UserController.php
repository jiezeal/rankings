<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 注册界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('web.user.register');
    }

    /**
     * 用户注册
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRegisterRequest $request){
        $data = $request->all();
        $data['confirm_code'] = str_random(48);
        $data['avatar'] = '/web/images/default-avatar.jpg';

        $result = $this->userService->register($data);

        if($result){
            return redirect('/web/login_interface');
        }else{
            return redirect('/web/user/create');
        }
    }

    /**
     * 验证邮箱
     * @param $confirm_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($confirm_code){
        $result = $this->userService->verify($confirm_code);
        if($result){
            return redirect('/web/login_interface');
        }else{
            return redirect('/web/index');
        }
    }

    /**
     * 登录界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginInterface(){
        return view('web.user.login');
    }

    /**
     * 登录操作
     * @param UserLoginRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(UserLoginRequest $request){
        if(\Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'is_confirmed' => 1
        ])){
            Session::put('user_info', \Auth::user());
            return redirect('web/index');
        }
        Session::flash('user_login_failed', '密码不正确或邮箱未验证');
        return redirect('/web/login_interface')->withInput();
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(){
        \Auth::logout();
        Session::forget('user_info');
        return redirect('/web/index');
    }
}
