<?php

namespace App\Services;

use App\Ranking;

class RankingService
{
    /**
     * @var Ranking
     */
    protected $ranking;

    /**
     * RankingService constructor.
     * @param Ranking $ranking
     */
    public function __construct(Ranking $ranking)
    {
        $this->ranking = $ranking;
    }

    /**
     * 获取所有点赞记录
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->ranking::latest()->get();
    }

    /**
     * 点赞操作
     * @param $data
     * @return bool|static
     */
    public function ranking($data){
        // 已经赞过的情况
        $result = $this->ranking->where($data)->first();
        if($result){
            return $result;
        }
        // 没有赞过的情况
        $ranking = $this->ranking::create($data);
        if(!$ranking){
            return false;
        }
        return $ranking;
    }
}