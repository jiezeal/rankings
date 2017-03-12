<?php

namespace App\Presenters;

class DiscussionPresenter
{
    /**
     * 检测帖子是否被点赞
     * @param $rankings
     * @param $user_id
     * @return bool
     */
    public function is_ranking($rankings, $user_id){
        foreach($rankings as $ranking){
            if($ranking->user_id == $user_id){
                return true;
            }
        }
        return false;
    }
}