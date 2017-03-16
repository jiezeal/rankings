<?php

namespace App\Console\Commands;

use App\Discussion;
use App\Redis\MasterCache;
use App\User;
use Illuminate\Console\Command;

class Recovery extends Command
{
    /**
     * @var string
     */
    protected $signature = 'recovery';

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Discussion
     */
    protected $discussion;

    /**
     * @var MasterCache
     */
    protected $masterCache;

    /**
     * Discussion constructor.
     * @param MasterCache $masterCache
     */
    public function __construct(User $user, Discussion $discussion, MasterCache $masterCache)
    {
        parent::__construct();
        $this->user = $user;
        $this->discussion = $discussion;
        $this->masterCache = $masterCache;
    }

    /**
     * 数据恢复
     */
    public function handle()
    {
        // 用户
        $this->recoveryUser();
        // 帖子
        $this->recoveryDiscussion();
    }

    /**
     * 缓存用户
     */
    public function recoveryUser(){
        $users = $this->user::all();
        foreach($users as $user){
            // string缓存
            $result = $this->masterCache->set(STRING_USER_ . $user->id, serialize($user));
            if(!$result) \Log::info('ID为[' . $user->id . ']的用户信息写入string缓存失败');
            
            // list列表缓存
            $result = $this->masterCache->lpush(LIST_USER, $user->id);
            if(!$result) \Log::info('用户ID[' . $user->id . ']写入list列表缓存失败');
        }
    }

    /**
     * 缓存帖子
     */
    public function recoveryDiscussion(){
        $discussions = $this->discussion::all();
        foreach($discussions as $discussion){
            // string缓存
            $result = $this->masterCache->set(STRING_DISCUSSION_ . $discussion->id, serialize($discussion));
            if(!$result) \Log::info('ID为[' . $discussion->id . ']的帖子写入string缓存失败');

            // list列表缓存
            $result = $this->masterCache->lpush(LIST_DISCUSSION, $discussion->id);
            if(!$result) \Log::info('帖子ID[' . $discussion->id . ']写入list列表缓存失败');
        }
    }
}