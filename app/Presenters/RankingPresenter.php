<?php

namespace App\Presenters;

class RankingPresenter
{
    /**
     * @var array
     */
    protected $discussions = [];

    /**
     * 点赞排序
     * @param $discussions
     * @return array
     */
    public function rankingSort($discussions){
        foreach($discussions as $discussion){
            $this->discussions[count($discussion->rankings)][] = $discussion;
        }
        krsort($this->discussions);
        return $this->discussions;
    }
}