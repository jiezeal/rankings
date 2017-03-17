<?php

namespace App\Redis;

class MasterCache extends Mredis
{
    /**
     * 获取redis缓存里某一个list中的指定页的所有元素
     * @param $key
     * @param $pagelist  每页显示的记录条数
     * @param $page  当前页
     * @return array|bool
     */
    public function getPageLists($key, $pagenum, $page)
    {
        if(empty($key) || !is_numeric($pagenum) || !is_numeric($page)) return false;
        // 起始偏移量
        $start = $pagenum * ($page - 1);
        // 结束位置
        $end = $start + $pagenum - 1;
        return $this->lrange($key, $start, $end);
    }

    /**
     * 获取redis缓存里某一个有序体集合中的指定页的所有元素
     * @param $key
     * @param $pagenum
     * @param $page
     * @return array|bool
     */
    public function getPageZadds($key, $pagenum, $page){
        if(empty($key) || !is_numeric($pagenum) || !is_numeric($page)) return false;
        // 起始偏移量
        $start = $pagenum * ($page - 1);
        // 结束位置
        $end = $start + $pagenum - 1;
        return $this->zrevrange($key, $start, $end, 'WITHSCORES');
    }

    /**
     * 获取hash的全部字段数据
     * @param $key
     * @param int $time
     * @return array|bool 成功： array 全部字段的键值对 失败：bool false
     */
    public function getHash($key, $time = HASH_OVERTIME){
        if(empty($key)) return false;
        $data = $this->hgetall($key);
        if(!$data) return false;
        $this->expire($key, $time);
        return $data;
    }

    /**
     * 获取hash的指定几个字段的数据
     * @param $key
     * @param $fields  hash的指定几个字段 array('field1', 'field2')
     * @return array
     */
    public function getHashFileds($key, $fields){
        if(empty($key) || !is_array($fields)) return false;
        $i = 0;
        $data = $this->hmget($key, $fields);
        $list = [];
        foreach($fields as $field){
            $list[$field] = $data[$i++];
        }
        return $list;
    }

    /**
     * 将一条记录写入hash
     * @param $key
     * @param $data  存入hash的具体字段和值
     * @param int $time
     * @return bool
     */
    public function addHash($key, $data, $time = HASH_OVERTIME){
        if(empty($key) || !is_array($data)) return false;
        if($this->exists($key)) return $this->expire($key, $time);
        if(!$this->hmset($key, $data)){
            \Log::error('写入hash出错'.$key);
            return false;
        }
        return $this->expire($key, $time);
    }

    /**
     * 修改一条hash记录
     * @param $key
     * @param $data  所要修改的键值对
     * @param int $time
     * @return bool
     */
    public function changeOneHash($key, $data, $time = HASH_OVERTIME){
        if(empty($key) || !is_numeric($data)) return false;
        if(!$this->hmset($key, $data)) return false;
        return $this->expire($key, $time);
    }

    /**
     * 添加一个新的短存的string redis
     * @param $key
     * @param $value
     * @param int $time
     * @return bool
     */
    public function addString($key, $value, $time = STRING_OVERTIME){
        if(empty($key)) return false;
        if(!$this->set($key, $value)) return false;
        return $this->expire($key, $time);
    }

    /**
     * 得到一个string
     * @param $key
     * @param int $time
     * @return bool|string
     */
    public function getString($key, $time = STRING_OVERTIME){
        if(empty($key)) return false;
        $data = $this->get($key);
        if(!$data) return false;
        $this->expire($key, $time);
        return $data;
    }
}