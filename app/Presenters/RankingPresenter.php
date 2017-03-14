<?php

namespace App\Presenters;

class RankingPresenter
{
    /**
     * 点赞排序
     * @param $discussions
     * @return array
     */
    public function rankingSort($discussions){
        foreach($discussions as $discussion){
            $list[count($discussion->rankings)][] = $discussion;
        }
        krsort($list);
        return $list;
    }
}