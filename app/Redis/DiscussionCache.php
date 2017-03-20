<?php

namespace App\Redis;

use Illuminate\Pagination\LengthAwarePaginator;

class DiscussionCache extends MasterCache
{
    /**
     * 获取带有分页的记录
     * @param $pagenum  每页显示的记录数
     * @return bool|mixed|string
     */
    public function paginate($pagenum){
        $data = Request()->all();
        if(!isset($data['page']) && empty($data['page'])) $data['page'] = 1;

        // 获取帖子总记录数
        $total = $this->llen(LIST_DISCUSSION);

        $ids = $this->getPageLists(LIST_DISCUSSION, PAGENUM, $data['page']);
        $lists = [];
        
        foreach($ids as $id){
            // 从string缓存中获取数据
//            $lists[] = unserialize($this->get(STRING_DISCUSSION_ . $id));

            // 从hash缓存中获取数据
            $lists[] = (object)$this->hgetall(HASH_DISCUSSION_ . $id);
        }

        // 手动创建分页
        $discussions = new LengthAwarePaginator($lists, $total, PAGENUM);
        $discussions->setPath('index');

        return $discussions;
    }

    /**
     * 将新增的帖子写入到缓存中
     * @param $discussion
     */
    public function publish($discussion){
        // 将新增的帖子加入到string缓存中
        $res = $this->set(STRING_DISCUSSION_ . $discussion->id, serialize($discussion));
        if(!$res) \Log('将ID为[' . $discussion->id . ']的帖子写入到string缓存失败');

        // 将新增的帖子加入到hash缓存中
        $res = $this->hmset(HASH_DISCUSSION_ . $discussion->id, $discussion->toArray());
        if(!$res) \Log('将ID为[' . $discussion->id . ']的帖子写入到hash缓存失败');
        
        // 同时将新增的帖子ID写入到list列表缓存中
        $res = $this->lpush(LIST_DISCUSSION, $discussion->id);
        if(!$res) \Log('帖子ID[' . $discussion->id . ']写入到list列表缓存失败');
    }
}