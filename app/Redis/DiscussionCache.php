<?php

namespace App\Redis;

use App\Discussion;

class DiscussionCache extends MasterCache
{
    /**
     * @var string
     */
    protected $skey = STRING_DISCUSSION_INFO_;

    /**
     * @var string
     */
    protected $lkey = LIST_DISCUSSION_INFO_;

    /**
     * @var string
     */
    protected $hkey = HASH_DISCUSSION_INFO_;

    /**
     * @var
     */
    protected $discussion;

    /**
     * DiscussionCache constructor.
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * 获取带有分页的记录
     * @param $pagenum  每页显示的记录数
     * @return bool|mixed|string
     */
    public function paginate($pagenum){
        $uri = Request()->root() . Request()->getRequestUri();
        if(!$this->exists($this->skey . $uri)){
            $discussions = $this->discussion::latest()->paginate($pagenum);
            $result = $this->addString($this->skey . $uri, serialize($discussions), STRING_DISCUSSION_OVERTIME);
            if(!$result) \Log::info('Redis添加失败：' . $this->skey . $uri);
            return $discussions;
        }else{
            $discussions = $this->get($this->skey . $uri);
            if(!$discussions) return false;
            return unserialize($discussions);
        }
    }

    /**
     * 获取一条数据
     * @param $id
     * @return bool|mixed|string
     */
    public function getRaw($id){
        $uri = Request()->root() . Request()->getRequestUri();
        if(!$this->exists($this->skey . $uri)){
            $discussion = $this->discussion::find($id);
            $result = $this->addString($this->skey . $uri, serialize($discussion), STRING_DISCUSSION_OVERTIME);
            if(!$result) \Log::info('Redis添加失败：' . $this->skey . $uri);
            return $discussion;
        }else{
            $discussion = $this->get($this->skey . $uri);
            if(!$discussion) return false;
            return unserialize($discussion);
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}