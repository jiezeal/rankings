<?php

namespace App\Redis;

use Illuminate\Pagination\LengthAwarePaginator;

class RankingCache extends MasterCache
{
    /**
     * 获取redis缓存里某一个有序体集合中的指定页的所有元素
     * @param $pagenum
     * @return LengthAwarePaginator
     */
    public function paginate($pagenum){
        $data = Request()->all();
        if(!isset($data['page']) && empty($data['page'])) $data['page'] = 1;

        // 获取帖子总记录数
        $total = $this->zcard(ZADD_RANKING);

        $ids = $this->getPageZadds(ZADD_RANKING, PAGENUM, $data['page']);
        $lists = [];
        foreach($ids as $id => $count){
            // 从string缓存中获取一篇帖子记录
//            $discussion = unserialize($this->get(STRING_DISCUSSION_ . $id));
            
            // 从hash缓存中获取一篇帖子记录
            $discussion = (object)$this->hgetall(HASH_DISCUSSION_ . $id);
            $discussion->count = $count;
            $lists[] = $discussion;
        }

        // 手动创建分页
        $discussions = new LengthAwarePaginator($lists, $total, PAGENUM);
        $discussions->setPath('ranking_list');
        
        return $discussions;
    }
}