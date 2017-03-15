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
    private $uri;

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
        $this->uri = Request()->root() . Request()->getRequestUri();
    }

    /**
     * 获取所有记录
     * @return bool|mixed|string
     */
    public function getAll(){
        if(!$this->exists($this->skey . $this->uri)){
            $discussions = $this->discussion::latest()->get();
            $result = $this->addString($this->skey . $this->uri, serialize($discussions), STRING_DISCUSSION_OVERTIME);
            if(!$result) \Log::info('Redis添加失败：' . $this->skey . $this->uri);
            return $discussions;
        }else{
            $discussions = $this->get($this->skey . $this->uri);
            if(!$discussions) return false;
            return unserialize($discussions);
        }
    }

    /**
     * 获取带有分页的记录
     * @param $pagenum  每页显示的记录数
     * @return bool|mixed|string
     */
    public function paginate($pagenum){
        if(!$this->exists($this->skey . $this->uri)){
            $discussions = $this->discussion::latest()->paginate($pagenum);
            $result = $this->addString($this->skey . $this->uri, serialize($discussions), STRING_DISCUSSION_OVERTIME);
            if(!$result) \Log::info('Redis添加失败：' . $this->skey . $this->uri);
            return $discussions;
        }else{
            $discussions = $this->get($this->skey . $this->uri);
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
        if(!$this->exists($this->skey . $this->uri)){
            $discussion = $this->discussion::find($id);
            $result = $this->addString($this->skey . $this->uri, serialize($discussion), STRING_DISCUSSION_OVERTIME);
            if(!$result) \Log::info('Redis添加失败：' . $this->skey . $this->uri);
            return $discussion;
        }else{
            $discussion = $this->get($this->skey . $this->uri);
            if(!$discussion) return false;
            return unserialize($discussion);
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}