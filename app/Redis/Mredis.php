<?php
/**
 * Created by PhpStorm.
 * User: zhulinjie
 * Date: 2017/3/13
 * Time: 10:35
 * author: zhulinjie
 */

namespace App\Redis;

class Mredis{
    /**
     * 删除已存在的键。不存在的 key 会被忽略
     * 调用：del('key1') del(['key1', 'key2'])
     * @param $key
     * @return bool|int
     */
    public function del($key)
    {
        if(empty($key)) return false;
        return \Redis::del($key);
    }

    /**
     * 检查给定 key 是否存在
     * @param $key
     * @return bool 若 key 存在返回 1 ，否则返回 0
     */
    public function exists($key)
    {
        if(empty($key)) return false;
        return \Redis::exists($key);
    }

    /**
     * 设置 key 的过期时间。key 过期后将不再可用
     * @param $key
     * @param int $time
     * @return bool 设置成功返回 1 。 当 key 不存在或者不能为 key 设置过期时间时 返回 0
     */
    public function expire($key, $time)
    {
        if(empty($key) || !is_numeric($time)) return false;
        return \Redis::expire($key, $time);
    }

    /**
     * 返回 key 所储存的值的类型
     * @param $key
     * @return bool|int 返回 key 的数据类型
     */
    public function type($key)
    {
        if(empty($key)) return false;
        return \Redis::type($key);
    }

    /**
     * 用于清空整个 Redis 服务器的数据(删除所有数据库的所有 key )
     * @return bool  总是返回 OK
     */
    public function flushall(){
        return \Redis::flushall();
    }

    /**
     * 查找所有符合给定模式 pattern 的 key
     * @param $pattern
     * @return array  符合给定模式的 key 列表 (Array)
     */
    public function keys($pattern){
        return \Redis::keys($pattern);
    }

    /**
     * 设置给定 key 的值。如果 key 已经存储其他值， SET 就覆写旧值，且无视类型
     * @param $key
     * @param string $val
     * @return bool  在 Redis 2.6.12 以前版本， SET 命令总是返回 OK 。 从 Redis 2.6.12 版本开始， SET 在设置操作成功完成时，才返回 OK
     */
    public function set($key, $val)
    {
        if(empty($key)) return false;
        return \Redis::set($key, $val);
    }

    /**
     * 获取指定 key 的值。如果 key 不存在，返回 nil
     * @param $key
     * @return bool|string  返回 key 的值，如果 key 不存在时，返回 nil
     */
    public function get($key)
    {
        if(empty($key)) return false;
        return \Redis::get($key);
    }

    /**
     * 对 key 所储存的字符串值，设置或清除指定偏移量上的位(bit)
     * @param $key
     * @param $offset
     * @param $val
     * @return bool|int  返回指定偏移量原来储存的位
     */
    public function setbit($key, $offset, $val)
    {
        if(empty($key) || !is_numeric($offset) || !is_numeric($val)) return false;
        return \Redis::setbit($key, $offset, $val);
    }

    /**
     * 对 key 所储存的字符串值，获取指定偏移量上的位(bit)
     * @param $key
     * @param $offset
     * @return bool|int  返回字符串值指定偏移量上的位(bit)。当偏移量 OFFSET 比字符串值的长度大，或者 key 不存在时，返回 0
     */
    public function getbit($key, $offset)
    {
        if(empty($key) || !is_numeric($offset)) return false;
        return \Redis::getbit($key, $offset);
    }

    /**
     * 同时设置一个或多个 key-value 对
     * 调用：mset(['key1' => 'val1', 'key2' => 'val2'])
     * @param $param
     * @return bool  总是返回 OK
     */
    public function mset($param)
    {
        if(empty($param) || !is_array($param)) return false;
        return \Redis::mset($param);
    }

    /**
     * 返回所有(一个或多个)给定 key 的值。 如果给定的 key 里面，有某个 key 不存在，那么这个 key 返回特殊值 nil
     * 调用：mget('key1') mget(['key1','key2'])
     * @param $key
     * @return array|bool  返回一个包含所有给定 key 的值的列表
     */
    public function mget($key)
    {
        if(empty($key)) return false;
        return \Redis::mget($key);
    }

    /**
     * 为指定的 key 设置值及其过期时间。如果 key 已经存在， SETEX 命令将会替换旧的值
     * @param $key
     * @param $timeout
     * @param $val
     * @return bool  设置成功时返回 OK
     */
    public function setex($key, $timeout, $val)
    {
        if(empty($key) || !is_numeric($timeout)) return false;
        return \Redis::setex($key, $timeout, $val);
    }

    /**
     * 获取指定 key 所储存的字符串值的长度
     * @param $key
     * @return bool|int  返回符串值的长度。 当 key 不存在时，返回 0
     */
    public function strlen($key)
    {
        if(empty($key)) return false;
        return \Redis::strlen($key);
    }

    /**
     * 将 key 中储存的数字值增一
     * @param $key
     * @return bool|int  执行 INCR 命令之后 key 的值
     */
    public function incr($key)
    {
        if(empty($key)) return false;
        return \Redis::incr($key);
    }

    /**
     * 将 key 中储存的数字加上指定的增量值
     * @param $key
     * @param $increment
     * @return bool|int  返回加上指定的增量值之后， key 的值
     */
    public function incrby($key, $increment)
    {
        if(empty($key) || !is_numeric($increment)) return false;
        return \Redis::incrby($key, $increment);
    }

    /**
     * 将 key 中储存的数字值减一
     * @param $key
     * @return bool|int  返回执行命令之后 key 的值
     */
    public function decr($key)
    {
        if(empty($key)) return false;
        return \Redis::decr($key);
    }

    /**
     * 将 key 所储存的值减去指定的减量值
     * @param $key
     * @param $increment
     * @return bool|int  返回减去指定减量值之后， key 的值
     */
    public function decrby($key, $increment)
    {
        if(empty($key) || !is_numeric($increment)) return false;
        return \Redis::decrby($key, $increment);
    }

    /**
     * 为哈希表中的字段赋值
     * @param $key
     * @param $field
     * @param $val
     * @return bool|int  如果字段是哈希表中的一个新建字段，并且值设置成功，返回 1 。 如果哈希表中域字段已经存在且旧值已被新值覆盖，返回 0
     */
    public function hset($key, $field, $val)
    {
        if(empty($key) || empty($field)) return false;
        return \Redis::hset($key, $field, $val);
    }

    /**
     * 返回哈希表中指定字段的值
     * @param $key
     * @param $field
     * @return bool|string  返回给定字段的值。如果给定的字段或 key 不存在时，返回 nil
     */
    public function hget($key, $field)
    {
        if(empty($key) || empty($field)) return false;
        return \Redis::hget($key, $field);
    }

    /**
     * 同时将多个 field-value (字段-值)对设置到哈希表中
     * 调用：hmset('key', ['name' => 'zhangsan', 'age' => 'lishi'])
     * @param $key
     * @param $param
     * @return bool  如果命令执行成功，返回 OK
     */
    public function hmset($key, $param)
    {
        if(empty($key) || empty($param) || !is_array($param)) return false;
        return \Redis::hmset($key, $param);
    }

    /**
     * 返回哈希表中，一个或多个给定字段的值
     * 调用：hmget('key', 'name') hmget('key', ['name', 'age'])
     * @param $key
     * @param $param
     * @return array|bool  一个包含多个给定字段关联值的表，表值的排列顺序和指定字段的请求顺序一样
     */
    public function hmget($key, $param)
    {
        if(empty($key) || empty($param)) return false;
        return \Redis::hmget($key, $param);
    }

    /**
     * 返回哈希表中，所有的字段和值
     * @param $key
     * @return array|bool  以列表形式返回哈希表的字段及字段值。 若 key 不存在，返回空列表
     */
    public function hgetall($key)
    {
        if(empty($key)) return false;
        return \Redis::hgetall($key);
    }

    /**
     * 查看哈希表的指定字段是否存在
     * @param $key
     * @param $field
     * @return bool  如果哈希表含有给定字段，返回 1 。 如果哈希表不含有给定字段，或 key 不存在，返回 0
     */
    public function hexists($key, $field)
    {
        if(empty($key) || empty($field)) return false;
        return \Redis::hexists($key, $field);
    }

    /**
     * 获取哈希表中的所有字段名
     * @param $key
     * @return array|bool  返回包含哈希表中所有字段的列表。 当 key 不存在时，返回一个空列表
     */
    public function hkeys($key)
    {
        if(empty($key)) return false;
        return \Redis::hkeys($key);
    }

    /**
     * 获取哈希表中字段的数量
     * @param $key
     * @return bool|int  返回哈希表中字段的数量。 当 key 不存在时，返回 0
     */
    public function hlen($key)
    {
        if(empty($key)) return false;
        return \Redis::hlen($key);
    }

    /**
     * 返回哈希表所有字段的值
     * @param $key
     * @return array|bool  返回一个包含哈希表中所有值的表。 当 key 不存在时，返回一个空表
     */
    public function hvals($key)
    {
        if(empty($key)) return false;
        return \Redis::hvals($key);
    }

    /**
     * 删除哈希表 key 中的一个或多个指定字段，不存在的字段将被忽略
     * 调用：hdel('key', 'name') hdel('key', ['name', 'age'])
     * @param $key
     * @param $param
     * @return bool|int  被成功删除字段的数量，不包括被忽略的字段
     */
    public function hdel($key, $param)
    {
        if(empty($key) || empty($param)) return false;
        return \Redis::hdel($key, $param);
    }

    /**
     * 将一个或多个值插入到列表头部。 如果 key 不存在，一个空列表会被创建并执行 LPUSH 操作
     * 调用：lpush('key', 10) lpush('key', [20,30])
     * @param $key
     * @param $param
     * @return bool|int  执行 LPUSH 命令后，返回列表的长度
     */
    public function lpush($key, $param)
    {
        if(empty($key)) return false;
        return \Redis::lpush($key, $param);
    }

    /**
     * 将一个或多个值插入到列表的尾部(最右边)。如果列表不存在，一个空列表会被创建并执行 RPUSH 操作
     * 调用：rpush('key', 10) rpush('key', [20,30])
     * @param $key
     * @param $param
     * @return bool|int  返回执行 RPUSH 操作后，列表的长度
     */
    public function rpush($key, $param)
    {
        if(empty($key)) return false;
        return \Redis::rpush($key, $param);
    }

    /**
     * 返回列表的长度。 如果列表 key 不存在，则 key 被解释为一个空列表，返回 0
     * @param $key
     * @return bool|int  返回列表的长度
     */
    public function llen($key)
    {
        if(empty($key)) return false;
        return \Redis::llen($key);
    }

    /**
     * 通过索引获取列表中的元素。你也可以使用负数下标，以 -1 表示列表的最后一个元素， -2 表示列表的倒数第二个元素，以此类推
     * @param $key
     * @param $index
     * @return bool|String  返回列表中下标为指定索引值的元素。 如果指定索引值不在列表的区间范围内，返回 nil
     */
    public function lindex($key, $index)
    {
        if(empty($key) || !is_numeric($index)) return false;
        return \Redis::lindex($key, $index);
    }

    /**
     * 移除并返回列表的第一个元素
     * @param $key
     * @return bool|string  列表的第一个元素。 当列表 key 不存在时，返回 nil
     */
    public function lpop($key)
    {
        if(empty($key)) return false;
        return \Redis::lpop($key);
    }

    /**
     * 移除并返回列表的最后一个元素
     * @param $key
     * @return bool|string  列表的最后一个元素。 当列表不存在时，返回 nil
     */
    public function rpop($key)
    {
        if(empty($key)) return false;
        return \Redis::rpop($key);
    }

    /**
     * 返回列表中指定区间内的元素，区间以偏移量 START 和 END 指定。 其中 0 表示列表的第一个元素， 1 表示列表的第二个元素，以此类推。 你也可以使用负数下标，以 -1 表示列表的最后一个元素， -2 表示列表的倒数第二个元素，以此类推
     * @param $key
     * @param $start
     * @param $end
     * @return array|bool  返回一个列表，包含指定区间内的元素
     */
    public function lrange($key, $start, $end)
    {
        if(empty($key) || !is_numeric($start) || !is_numeric($end)) return false;
        return \Redis::lrange($key, $start, $end);
    }

    /**
     * 通过索引来设置元素的值。当索引参数超出范围，或对一个空列表进行 LSET 时，返回一个错误
     * @param $key
     * @param $index
     * @param $val
     * @return BOOL  操作成功返回 ok ，否则返回错误信息
     */
    public function lset($key, $index, $val)
    {
        if(empty($key) || !is_numeric($index)) return false;
        return \Redis::lset($key, $index, $val);
    }

    /**
     * 在列表的元素前或者后插入元素。 当指定元素不存在于列表中时，不执行任何操作。 当列表不存在时，被视为空列表，不执行任何操作
     * @param $key
     * @param $pivot  before|after
     * @param $field
     * @param $param
     * @return bool|int  如果命令执行成功，返回插入操作完成之后，列表的长度。 如果没有找到指定元素 ，返回 -1 。 如果 key 不存在或为空列表，返回 0
     */
    public function linsert($key, $pivot, $field, $val)
    {
        if(empty($key)) return false;
        return \Redis::linsert($key, $pivot, $field, $val);
    }

    /**
     * 根据参数 COUNT 的值，移除列表中与参数 VALUE 相等的元素。
     * COUNT 的值可以是以下几种：
     * count > 0 : 从表头开始向表尾搜索，移除与 VALUE 相等的元素，数量为 COUNT 。
     * count < 0 : 从表尾开始向表头搜索，移除与 VALUE 相等的元素，数量为 COUNT 的绝对值。
     * count = 0 : 移除表中所有与 VALUE 相等的值
     * @param $key
     * @param $count
     * @param $val
     * @return bool|int  返回被移除元素的数量。 列表不存在时返回 0
     */
    public function lrem($key, $count, $val)
    {
        if(empty($key)) return false;
        return \Redis::lrem($key, $count, $val);
    }

    /**
     * 对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。下标 0 表示列表的第一个元素，以 1 表示列表的第二个元素，以此类推。 你也可以使用负数下标，以 -1 表示列表的最后一个元素， -2 表示列表的倒数第二个元素，以此类推
     * @param $key
     * @param $start
     * @param $stop
     * @return array|bool  命令执行成功时，返回 ok
     */
    public function ltrim($key, $start, $stop)
    {
        if(empty($key)) return false;
        return \Redis::ltrim($key, $start, $stop);
    }

    /**
     * 将一个或多个成员元素加入到集合中，已经存在于集合的成员元素将被忽略。
     * 假如集合 key 不存在，则创建一个只包含添加的元素作成员的集合。
     * 当集合 key 不是集合类型时，返回一个错误
     * 调用：sadd('key', 10) sadd('key', [10, 20, 30, 40, 50, 60])
     * @param $key
     * @param $param
     * @return bool|int  被添加到集合中的新元素的数量，不包括被忽略的元素
     */
    public function sadd($key, $param)
    {
        if(empty($key)) return false;
        return \Redis::sadd($key, $param);
    }

    /**
     * 返回集合中元素的数量
     * @param $key
     * @return bool|int  返回集合的数量。 当集合 key 不存在时，返回 0
     */
    public function scard($key)
    {
        if(empty($key)) return false;
        return \Redis::scard($key);
    }

    /**
     * 返回给定集合之间的差集。不存在的集合 key 将视为空集
     * 调用：sdiff(['key1', 'key2'])
     * @param $param
     * @return array|bool  返回包含差集成员的列表
     */
    public function sdiff($param)
    {
        if(empty($param)) return false;
        return \Redis::sdiff($param);
    }

    /**
     * 返回给定所有给定集合的交集。 不存在的集合 key 被视为空集。 当给定集合当中有一个空集时，结果也为空集(根据集合运算定律)
     * 调用：sinter(['key1', 'key2'])
     * @param $param
     * @return array|bool  返回交集成员的列表
     */
    public function sinter($param)
    {
        if(empty($param)) return false;
        return \Redis::sinter($param);
    }

    /**
     * 判断成员元素是否是集合的成员
     * @param $key
     * @param $val
     * @return bool  如果成员元素是集合的成员，返回 1 。 如果成员元素不是集合的成员，或 key 不存在，返回 0
     */
    public function sismember($key, $val)
    {
        if(empty($key)) return false;
        return \Redis::sismember($key, $val);
    }

    /**
     * 返回集合中的所有的成员。 不存在的集合 key 被视为空集合
     * @param $key
     * @return array|bool  返回集合中的所有成员
     */
    public function smembers($key)
    {
        if(empty($key)) return false;
        return \Redis::smembers($key);
    }

    /**
     * 移除并返回集合中的一个随机元素
     * @param $key
     * @return bool|string  被移除的随机元素。 当集合不存在或是空集时，返回 nil
     */
    public function spop($key)
    {
        if(empty($key)) return false;
        return \Redis::spop($key);
    }

    /**
     * 返回集合中的一个随机元素。
     * 从 Redis 2.6 版本开始， Srandmember 命令接受可选的 count 参数：
     * 如果 count 为正数，且小于集合基数，那么命令返回一个包含 count 个元素的数组，数组中的元素各不相同。如果 count 大于等于集合基数，那么返回整个集合。
     * 如果 count 为负数，那么命令返回一个数组，数组中的元素可能会重复出现多次，而数组的长度为 count 的绝对值。
     * 该操作和 SPOP 相似，但 SPOP 将随机元素从集合中移除并返回，而 Srandmember 则仅仅返回随机元素，而不对集合进行任何改动
     * @param $key
     * @param null $count
     * @return bool|string  只提供集合 key 参数时，返回一个元素；如果集合为空，返回 nil 。 如果提供了 count 参数，那么返回一个数组；如果集合为空，返回空数组
     */
    public function srandmember($key, $count=null)
    {
        if(empty($key)) return false;
        if(isset($count)) return \Redis::srandmember($key, $count);
        return \Redis::srandmember($key);
    }

    /**
     * 移除集合中的一个或多个成员元素，不存在的成员元素会被忽略。
     * 当 key 不是集合类型，返回一个错误
     * @param $key
     * @param $param
     * @return bool|int  返回被成功移除的元素的数量，不包括被忽略的元素
     */
    public function srem($key, $param)
    {
        if(empty($key)) return false;
        return \Redis::srem($key, $param);
    }

    /**
     * 返回给定集合的并集。不存在的集合 key 被视为空集
     * @param $param
     * @return array|bool  返回并集成员的列表
     */
    public function sunion($param)
    {
        if(!is_array($param)) return false;
        return \Redis::sunion($param);
    }

    /**
     * 将一个或多个成员元素及其分数值加入到有序集当中。
     * 如果某个成员已经是有序集的成员，那么更新这个成员的分数值，并通过重新插入这个成员元素，来保证该成员在正确的位置上。
     * 分数值可以是整数值或双精度浮点数。
     * 如果有序集合 key 不存在，则创建一个空的有序集并执行 ZADD 操作。
     * 当 key 存在但不是有序集类型时，返回一个错误
     * 调用：zadd('key', ['html'=>80, 'css'=>90, 'php'=>100])
     * @param $key
     * @param $param
     * @return bool|int  被成功添加的新成员的数量，不包括那些被更新的、已经存在的成员
     */
    public function zadd($key, $param)
    {
        if(!is_array($param)) return false;
        return \Redis::zadd($key, $param);
    }

    /**
     * 计算集合中元素的数量
     * @param $key
     * @return bool|int  当 key 存在且是有序集类型时，返回有序集的基数。 当 key 不存在时，返回 0
     */
    public function zcard($key)
    {
        if(empty($key)) return false;
        return \Redis::zcard($key);
    }

    /**
     * 计算有序集合中指定分数区间的成员数量
     * @param $key
     * @param $min
     * @param $max
     * @return bool|int  分数值在 min 和 max 之间的成员的数量
     */
    public function zcount($key, $min, $max)
    {
        if(empty($key) || !is_numeric($min) || !is_numeric($max)) return false;
        return \Redis::zcount($key, $min, $max);
    }

    /**
     * 有序集合中指定成员的分数加上增量 increment
     * 可以通过传递一个负数值 increment ，让分数减去相应的值，比如 ZINCRBY key -5 member ，就是让 member 的 score 值减去 5 。
     * 当 key 不存在，或分数不是 key 的成员时， ZINCRBY key increment member 等同于 ZADD key increment member 。
     * 当 key 不是有序集类型时，返回一个错误。
     * 分数值可以是整数值或双精度浮点数
     * @param $key
     * @param $increment
     * @param $member
     * @return bool|float  member 成员的新分数值，以字符串形式表示
     */
    public function zincrby($key, $increment, $member)
    {
        if(empty($key) || !is_numeric($increment) || empty($member)) return false;
        return \Redis::zincrby($key, $increment, $member);
    }

    /**
     * 返回有序集中，指定区间内的成员。
     * 其中成员的位置按分数值递增(从小到大)来排序。
     * 具有相同分数值的成员按字典序(lexicographical order )来排列。
     * 如果你需要成员按
     * 值递减(从大到小)来排列，请使用 ZREVRANGE 命令。
     * 下标参数 start 和 stop 都以 0 为底，也就是说，以 0 表示有序集第一个成员，以 1 表示有序集第二个成员，以此类推。
     * 你也可以使用负数下标，以 -1 表示最后一个成员， -2 表示倒数第二个成员，以此类推
     * 调用：zrange('key', 0, -1) zrange('key', 0, -1) zrange('key', 0, -1, 'WITHSCORES')
     * @param $key
     * @param $start
     * @param $stop
     * @param null $withscores
     * @return array|bool  指定区间内，带有分数值(可选)的有序集成员的列表
     */
    public function zrange($key, $start, $stop, $withscores=null)
    {
        if(empty($key) || !is_numeric($start) || !is_numeric($stop)) return false;
        if(isset($withscores) && $withscores == 'WITHSCORES') return \Redis::zrange($key, $start, $stop, $withscores);
        return \Redis::zrange($key, $start, $stop);
    }

    /**
     * 返回有序集中指定成员的排名。其中有序集成员按分数值递增(从小到大)顺序排列 或者说 返回有序集合中指定成员的索引
     * @param $key
     * @param $member
     * @return bool|int  如果成员是有序集 key 的成员，返回 member 的排名。 如果成员不是有序集 key 的成员，返回 nil
     */
    public function zrank($key, $member)
    {
        if(empty($key) || empty($member)) return false;
        return \Redis::zrank($key, $member);
    }

    /**
     * 用于移除有序集中的一个或多个成员，不存在的成员将被忽略
     * 当 key 存在但不是有序集类型时，返回一个错误
     * 调用：zrem('key', 'html') zrem('key', ['css', 'php'])
     * @param $key
     * @param $param
     * @return bool|int  被成功移除的成员的数量，不包括被忽略的成员
     */
    public function zrem($key, $param)
    {
        if(empty($key)) return false;
        return \Redis::zrem($key, $param);
    }

    /**
     * 用于移除有序集中，指定排名(rank)区间内的所有成员 或者说 指定索引区间内的所有成员
     * 调用：zremrangebyrank('key', 0, 1)
     * @param $key
     * @param $start
     * @param $stop
     * @return bool|int  被移除成员的数量
     */
    public function zremrangebyrank($key, $start, $stop)
    {
        if(empty($key) || !is_numeric($start) || !is_numeric($stop)) return false;
        return \Redis::zremrangebyrank($key, $start, $stop);
    }

    /**
     * 用于移除有序集中，指定分数（score）区间内的所有成员
     * 调用：zremrangebyscore('key', 10, 20)
     * @param $key
     * @param $min
     * @param $max
     * @return bool|int  被移除成员的数量
     */
    public function zremrangebyscore($key, $min, $max)
    {
        if(empty($key) || !is_numeric($min) || !is_numeric($max)) return false;
        return \Redis::zremrangebyscore($key, $min, $max);
    }

    /**
     * 返回有序集中，指定区间内的成员。
     * 其中成员的位置按分数值递减(从大到小)来排列。
     * 具有相同分数值的成员按字典序的逆序(reverse lexicographical order)排列。
     * 除了成员按分数值递减的次序排列这一点外， ZREVRANGE 命令的其他方面和 ZRANGE 命令一样
     * 调用：zrevrange('key', 0, -1, 'WITHSCORES')
     * @param $key
     * @param $start
     * @param $stop
     * @param null $withscores
     * @return array|bool  指定区间内，带有分数值(可选)的有序集成员的列表
     */
    public function zrevrange($key, $start, $stop, $withscores=null)
    {
        if(empty($key) || !is_numeric($start) || !is_numeric($stop)) return false;
        if(isset($withscores) && $withscores == 'WITHSCORES') return \Redis::zrevrange($key, $start, $stop, $withscores);
        return \Redis::zrevrange($key, $start, $stop);
    }

    /**
     * 返回有序集中成员的排名。其中有序集成员按分数值递减(从大到小)排序。
     * 排名以 0 为底，也就是说， 分数值最大的成员排名为 0 。
     * 使用 ZRANK 命令可以获得成员按分数值递增(从小到大)排列的排名
     * 调用：zrevrank('key', 'html')
     * @param $key
     * @param $member
     * @return bool|int  如果成员是有序集 key 的成员，返回成员的排名。 如果成员不是有序集 key 的成员，返回 nil
     */
    public function zrevrank($key, $member)
    {
        if(empty($key) || empty($member)) return false;
        return \Redis::zrevrank($key, $member);
    }

    /**
     * 返回有序集中，成员的分数值。 如果成员元素不是有序集 key 的成员，或 key 不存在，返回 nil
     * 调用：zscore('key', 'html')
     * @param $key
     * @param $member
     * @return bool|float  返回成员的分数值，以字符串形式表示
     */
    public function zscore($key, $member)
    {
        if(empty($key) || empty($member)) return false;
        return \Redis::zscore($key, $member);
    }
}