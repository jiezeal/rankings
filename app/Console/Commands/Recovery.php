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
        // 点赞排行榜
        $this->recoveryRanking();
    }
    
    /**
     * 缓存用户
     */
    public function recoveryUser(){
        $users = $this->user::all();
        foreach($users as $user){
            // 如果缓存已经存在，则先删除缓存
            if($this->masterCache->exists(STRING_USER_ . $user->id)) $this->masterCache->del(STRING_USER_ . $user->id);
            if($this->masterCache->exists(HASH_USER_ . $user->id)) $this->masterCache->del(HASH_USER_ . $user->id);
            if($this->masterCache->exists(LIST_USER)) $this->masterCache->del(LIST_USER);

            // string缓存
            $result = $this->masterCache->set(STRING_USER_ . $user->id, serialize($user));
            if(!$result) \Log::info('ID为[' . $user->id . ']的用户信息写入string缓存失败');

            // hash缓存
            $result = $this->masterCache->hmset(HASH_USER_ . $user->id, $user->toArray());
            if(!$result) \Log::info('ID为[' . $user->id . ']的用户信息写入hash缓存失败');

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
            // 如果缓存已经存在，则先删除缓存
            if($this->masterCache->exists(STRING_DISCUSSION_ . $discussion->id)) $this->masterCache->del(STRING_DISCUSSION_ . $discussion->id);
            if($this->masterCache->exists(HASH_DISCUSSION_ . $discussion->id)) $this->masterCache->del(HASH_DISCUSSION_ . $discussion->id);
            if($this->masterCache->exists(LIST_DISCUSSION)) $this->masterCache->del(LIST_DISCUSSION);

            // string缓存
            $result = $this->masterCache->set(STRING_DISCUSSION_ . $discussion->id, serialize($discussion));
            if(!$result) \Log::info('ID为[' . $discussion->id . ']的帖子写入string缓存失败');

            // hash缓存
            $result = $this->masterCache->hmset(HASH_DISCUSSION_ . $discussion->id, $discussion->toArray());
            if(!$result) \Log::info('ID为[' . $discussion->id . ']的帖子写入hash缓存失败');

            // list列表缓存
            $result = $this->masterCache->lpush(LIST_DISCUSSION, $discussion->id);
            if(!$result) \Log::info('帖子ID[' . $discussion->id . ']写入list列表缓存失败');
        }
    }

    /**
     * 缓存点赞
     */
    public function recoveryRanking(){
        $discussions = $this->discussion::all();
        foreach($discussions as $discussion){
            $rankings = $discussion->rankings;
            
            // 如果缓存已经存在，则先删除缓存
            if($this->masterCache->exists(SADD_DISCUSSION_ . $discussion->id)) $this->masterCache->del(SADD_DISCUSSION_ . $discussion->id);
            if($this->masterCache->exists(ZADD_RANKING)) $this->masterCache->del(ZADD_RANKING);
            
            foreach($rankings as $ranking){
                if($ranking->is_ranked == 1){
                    // 写入集合
                    $this->masterCache->sadd(SADD_DISCUSSION_ . $discussion->id, $ranking->user_id);
                    // 判断是否存在，如果不存在，则score为1。如果存在，则在它的基础上新增1
                    $zrank = $this->masterCache->zrank(ZADD_RANKING, $discussion->id);
                    if($zrank){
                        $this->masterCache->zincrby(ZADD_RANKING, 1, $discussion->id);
                    }else{
                        $this->masterCache->zadd(ZADD_RANKING, [$discussion->id => 1]);
                    }
                }
            }
        }
    }
}