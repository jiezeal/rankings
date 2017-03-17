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
     * @param $ranking
     * @return mixed
     */
    public function discussion($ranking){
        // 判断是否是从缓存中获取的数据
        if(isset($ranking->id)){
            // 从缓存中取
            $user = unserialize($this->rankingCache->get(STRING_USER_ . $ranking->user_id));
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
}