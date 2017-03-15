<?php

namespace App\Services;

use App\Discussion;
use App\Redis\DiscussionCache;

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
     * 获取所有记录
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->discussionCache->getAll();
    }

    /**
     * 获取带有分页的记录
     * @param $pagenum
     * @return mixed
     */
    public function paginate($pagenum){
        return $this->discussionCache->paginate($pagenum);
    }

    /**
     * 获取一条记录
     * @param $id
     * @return mixed
     */
    public function getRaw($id){
        return $this->discussionCache->getRaw($id);
    }

    /**
     * 发表一篇文章
     * @param $data
     * @return bool|static
     */
    public function Publish($data){
        $discussion = $this->discussion::create($data);
        if(!$discussion){
            return false;
        }
        return $discussion;
    }

    /**
     * 修改一篇文章
     * @param $data
     * @param $id
     * @return bool
     */
    public function modify($data, $id){
        $discussion = $this->discussion::findOrFail($id);
        if(!$discussion){
            return false;
        }
        if(!$discussion->update($data)){
            return false;
        }
        return $discussion;
    }
}