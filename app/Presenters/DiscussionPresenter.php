<?php

namespace App\Presenters;

use App\Redis\MasterCache;

class DiscussionPresenter
{
    /**
     * @var MasterCache
     */
    protected $masterCache;

    /**
     * DiscussionPresenter constructor.
     * @param MasterCache $masterCache
     */
    public function __construct(MasterCache $masterCache)
    {
        $this->masterCache = $masterCache;
    }

    /**
     * 获取用户信息
     * @param $discussion
     * @return mixed
     */
    public function user($discussion){
        // 判断用户信息在缓存中是否存在，如果存在则从缓存中获取用户信息
        if($this->masterCache->exists(STRING_USER_ . $discussion->user_id)){
            return unserialize($this->masterCache->get(STRING_USER_ . $discussion->user_id));
        // 不存在缓存则从数据库中获取用户信息
        }else{
            return $discussion->user;
        }
    }

    /**
     * 检测帖子是否被点赞
     * @param $discussion
     * @param $user_id
     * @return bool
     */
    public function is_ranking($discussion, $user_id){
        $res = $this->masterCache->exists(SADD_DISCUSSION_ . $discussion->id);
        if($res){
            // 获取被点赞的用户
            $uids = $this->masterCache->smembers(SADD_DISCUSSION_ . $discussion->id);
            if(in_array($user_id, $uids)) return true;
            return false;
        }else{
            // 获取被点赞的用户
            $rankings = $discussion->rankings;
            foreach($rankings as $ranking){
                if($ranking->is_ranked && $ranking->user_id == $user_id){
                    return true;
                }
            }
            return false;
        }
    }
}