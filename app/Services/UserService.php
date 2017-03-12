<?php

namespace App\Services;

use App\User;

class UserService
{
    /**
     * @var User
     */
    protected $user;
    protected $emailService;

    /**
     * UserService constructor.
     * @param User $user
     */
    public function __construct(User $user, EmailService $emailService)
    {
        $this->user = $user;
        $this->emailService = $emailService;
    }

    /**
     * 用户注册
     * @param $data
     * @return bool
     */
    public function register($data){
        $user = $this->user::create($data);
        if(!$user) return false;
        // 邮件发送
        $subject = 'Confirm Your Email';
        $view = 'email.register';
        $this->emailService->sendEmail($user->email, $subject, $view, ['confirm_code' => $user->confirm_code]);
        return true;
    }

    /**
     * 验证邮箱
     * @param $confirm_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($confirm_code){
        $user = $this->user::where('confirm_code', $confirm_code)->first();
        if(is_null($user)){
            return false;
        }
        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        if($user->save()){
            return true;
        }else{
            return false;
        }
    }
}