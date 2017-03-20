<?php

namespace App\Console\Commands;

use App\Discussion;
use App\Redis\MasterCache;
use App\User;
use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * @var string
     */
    protected $signature = 'clear';

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
     * 清除缓存
     */
    public function handle()
    {
        // 用户
        $users = $this->user::all();
        // 帖子
        $discussions = $this->discussion::all();

        if($this->masterCache->exists(LIST_USER)) $this->masterCache->del(LIST_USER);
        if($this->masterCache->exists(LIST_DISCUSSION)) $this->masterCache->del(LIST_DISCUSSION);
        if($this->masterCache->exists(ZADD_RANKING)) $this->masterCache->del(ZADD_RANKING);

        foreach($users as $user){
            if($this->masterCache->exists(STRING_USER_ . $user->id)) $this->masterCache->del(STRING_USER_ . $user->id);
            if($this->masterCache->exists(HASH_USER_ . $user->id)) $this->masterCache->del(HASH_USER_ . $user->id);
        }

        foreach($discussions as $discussion){
            if($this->masterCache->exists(STRING_DISCUSSION_ . $discussion->id)) $this->masterCache->del(STRING_DISCUSSION_ . $discussion->id);
            if($this->masterCache->exists(HASH_DISCUSSION_ . $discussion->id)) $this->masterCache->del(HASH_DISCUSSION_ . $discussion->id);
        }

        foreach($discussions as $discussion){
            if($this->masterCache->exists(SADD_DISCUSSION_ . $discussion->id)) $this->masterCache->del(SADD_DISCUSSION_ . $discussion->id);
        }
    }
}