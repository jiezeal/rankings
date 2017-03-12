<?php

namespace App\Services;

use App\Discussion;
use App\User;

class DiscussionService
{
    /**
     * @var Discussion
     */
    protected $discussion;

    /**
     * DiscussionService constructor.
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * 获取所有记录
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->discussion::latest()->get();
    }

    /**
     * 获取一条记录
     * @param $id
     * @return mixed
     */
    public function getRaw($id){
        return $this->discussion::findOrFail($id);
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