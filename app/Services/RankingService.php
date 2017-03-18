<?php

namespace App\Services;

use App\Ranking;
use App\Redis\RankingCache;

class RankingService
{
    /**
     * @var Ranking
     */
    protected $ranking;

    /**
     * @var
     */
    protected $rankingCache;

    /**
     * RankingService constructor.
     * @param Ranking $ranking
     * @param RankingCache $rankingCache
     */
    public function __construct(Ranking $ranking, RankingCache $rankingCache)
    {
        $this->ranking = $ranking;
        $this->rankingCache = $rankingCache;
    }

    /**
     * 获取点赞排行 带分页
     * @param $pagenum  每页显示记录条数
     * @return mixed
     */
    public function paginate($pagenum){
        // 从缓存获取数据
        if($this->rankingCache->exists(ZADD_RANKING)){
            return $this->rankingCache->paginate($pagenum);
        // 从数据库中获取数据
        }else{
            $this->rankingCache->paginate($pagenum);
            return $this->ranking::select('discussion_id', \DB::raw('count("user_id") as count'))->where('is_ranked', '1')->groupBy('discussion_id')->orderBy('count', 'desc')->paginate($pagenum);
        }
    }

    /**
     * 点赞操作
     * @param $data
     * @return bool|static
     */
    public function ranking($data){
        $ranking = $this->ranking->where(['user_id' => $data['user_id'], 'discussion_id' => $data['discussion_id']])->first();
        if($ranking){
            // 取消点赞
            if($ranking->is_ranked){
                $ranking->is_ranked = 0;
                if(!$ranking->save()) return false;
                // 更新缓存
                $this->rankingCache->srem(SADD_DISCUSSION_ . $ranking->discussion_id, $ranking->user_id);
                $this->rankingCache->zincrby(ZADD_RANKING, -1, $ranking->discussion_id);
            // 重新点赞
            }else{
                $ranking->is_ranked = 1;
                if(!$ranking->save()) return false;
                // 更新缓存
                $this->rankingCache->sadd(SADD_DISCUSSION_ . $ranking->discussion_id, $ranking->user_id);
                $this->rankingCache->zincrby(ZADD_RANKING, 1, $ranking->discussion_id);
            }
            return $ranking;
        // 点赞操作
        }else{
            $data['is_ranked'] = 1;
            $ranking= $this->ranking::create($data);
            if(!$ranking){
                return false;
            }
            // 写入到缓存
            $this->rankingCache->sadd(SADD_DISCUSSION_ . $ranking->discussion_id, $ranking->user_id);
            $this->rankingCache->zadd(ZADD_RANKING, [$ranking->discussion_id => 1]);
            return $ranking;
        }
    }
}