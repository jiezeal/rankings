<?php

namespace App\Services;

use App\Discussion;
use App\Redis\DiscussionCache;
use Illuminate\Http\Request;

class DiscussionService
{
    /**
     * @var Discussion
     */
    protected $discussion;

    /**
     * @var
     */
    protected $discussionCache;

    /**
     * DiscussionService constructor.
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion, DiscussionCache $discussionCache)
    {
        $this->discussion = $discussion;
        $this->discussionCache = $discussionCache;
    }

    /**
     * 获取带有分页的记录
     * @param $pagenum
     * @return mixed
     */
    public function paginate($pagenum){
        // 判断缓存中是否存在，如果存在从缓存中获取数据
        if($this->discussionCache->exists(LIST_DISCUSSION)){
            return $this->discussionCache->paginate($pagenum);
        // 缓存不存在，则从数据库中获取
        }else{
            return $this->discussion::latest()->paginate($pagenum);
        }
    }

    /**
     * 获取一条记录
     * @param $id
     * @return mixed
     */
    public function getRaw($id){
        // 判断帖子在缓存中是否存在
        if($this->discussionCache->exists(STRING_DISCUSSION_ . $id)){
            // 从string缓存中获取
//            return unserialize($this->discussionCache->get(STRING_DISCUSSION_ . $id));
            
            // 从hash缓存中获取
            return (object)$this->discussionCache->hgetall(HASH_DISCUSSION_ . $id);
        }
        // 缓存不存在则从数据库中获取
        return $this->discussion::find($id);
    }

    /**
     * 发表一篇文章
     * @param $data
     * @return bool|static
     */
    public function publish($data){
        // 加入到数据库
        $discussion = $this->discussion::create($data);
        if(!$discussion){
            return false;
        }
        // 加入到缓存
        $this->discussionCache->publish($discussion);
        return $discussion;
    }

    /**
     * 修改一篇文章
     * @param $data
     * @param $id
     * @return bool
     */
    public function modify($data, $id){
        $discussion = $this->discussion::find($id);
        if(!$discussion){
            return false;
        }
        // 修改操作
        $result = $discussion->update($data);
        if(!$result){
            return false;
        }
        // 更新string缓存
        $this->discussionCache->set(STRING_DISCUSSION_ . $discussion->id, serialize($discussion));
        // 更新hash缓存
        $this->discussionCache->hmset(HASH_DISCUSSION_ . $discussion->id, $discussion->toArray());
        return $discussion;
    }
}