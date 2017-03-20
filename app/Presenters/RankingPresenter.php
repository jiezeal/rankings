<?php

namespace App\Presenters;

use App\Redis\RankingCache;

class RankingPresenter
{
    /**
     * @var RankingCache
     */
    protected $rankingCache;

    /**
     * RankingPresenter constructor.
     * @param RankingCache $rankingCache
     */
    public function __construct(RankingCache $rankingCache)
    {
        $this->rankingCache = $rankingCache;
    }

    /**
     * 点赞排行
     * @param $ranking
     * @return mixed
     */
    public function discussion($ranking){
        // 判断是否是从缓存中获取的数据
        if(isset($ranking->id)){
            // 从string缓存中取
//            $user = unserialize($this->rankingCache->get(STRING_USER_ . $ranking->user_id));
            // 从hash缓存中获取
            $user = (object)$this->rankingCache->hgetall(HASH_USER_ . $ranking->user_id);
            $ranking->avatar = $user->avatar;
            $ranking->name = $user->name;
            return $ranking;
        }else{
            // 从数据库中获取
            $discussion = $ranking->discussion;
            $user = $discussion->user;
            $discussion->avatar = $user->avatar;
            $discussion->name = $user->name;
            return $discussion;
        }
    }

    /**
     * 获取赞过这篇帖子的用户
     * @param $discussion
     * @return array
     */
    public function rankings($discussion){
        // 从缓存中获取赞过这篇帖子的用户
        if($this->rankingCache->exists(SADD_DISCUSSION_ . $discussion->id)){
            $ids = $this->rankingCache->smembers(SADD_DISCUSSION_ . $discussion->id);
            $rankings = [];
            foreach($ids as $id){
                // 从hash缓存中获取
                $rankings[] = (object)$this->rankingCache->hgetall(HASH_USER_ . $id);
            }
            return $rankings;
        // 从数据库中获取赞过这篇帖子的用户
        }else{
            return $discussion->rankings;
        }
    }
}