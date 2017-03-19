<?php

namespace App\Redis;

class UserCache extends MasterCache
{
    /**
     * 将新增的用户写入到缓存中
     * @param $user
     */
    public function register($user){
        // 将新增的用户加入到string缓存中
        $res = $this->set(STRING_USER_ . $user->id, serialize($user));
        if(!$res) \Log::info('将ID为[' . $user->id . ']的用户写入到string缓存失败');
        
        // 同时将新增的用户ID写入到list列表缓存中
        $res = $this->lpush(LIST_USER, $user->id);
        if(!$res) \Log::info('用户ID[' . $user->id . ']写入到list列表缓存失败');
    }
}