<?php

namespace App\Services;

use App\Redis\UserCache;
use App\User;

class UserService
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * @var
     */
    protected $userCache;

    /**
     * UserService constructor.
     * @param User $user
     * @param EmailService $emailService
     * @param MasterCache $masterCache
     */
    public function __construct(User $user, EmailService $emailService, UserCache $userCache)
    {
        $this->user = $user;
        $this->emailService = $emailService;
        $this->userCache = $userCache;
    }

    /**
     * 用户注册
     * @param $data
     * @return bool
     */
    public function register($data){
        // 写入数据库
        $user = $this->user::create($data);
        if(!$user) return false;
        // 写入缓存
        $this->userCache->register($user);
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
        if(!$user->save()) return false;

        // 更新string缓存
        $this->userCache->set(STRING_USER_ . $user->id, serialize($user));
        // 更新hash缓存
        $this->userCache->hmget(HASH_USER_ . $user->id, $user->toArray());

        return true;
    }
}