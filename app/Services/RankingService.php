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
     * 获取点赞排行 带分页
     * @param $pagenum  每页显示记录条数
     * @return mixed
     */
    public function paginate($pagenum){
        return $this->ranking::select('discussion_id', \DB::raw('count("user_id") as count'))->where('is_ranked', '1')->groupBy('discussion_id')->orderBy('count', 'desc')->paginate(5);
    }

    /**
     * 点赞操作
     * @param $data
     * @return bool|static
     */
    public function ranking($data){
        $ranking = $this->ranking->where($data)->first();
        if($ranking){
            // 取消点赞
            if($ranking->is_ranked){
                $ranking->is_ranked = 0;
                $result = $ranking->save();
                if(!$result) return false;
            // 重新点赞
            }else{
                $ranking->is_ranked = 1;
                $result = $ranking->save();
                if(!$result) return false;
            }
            return $result;
        }else{
            $result = $this->ranking::create($data);
            if(!$result){
                return false;
            }
            return $result;
        }
    }
}