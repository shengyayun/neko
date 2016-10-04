<?php
/**
 * Redis
 */
class NekoCache
{
    /**
     * redis
     * @var Redis
     */
    private $redis;

    /**
     * cache中的队列名称
     * @var string
     */
    private $queueKey = 'neko';

    /**
     * __construct
     */
    public function __construct($config)
    {
        $this->redis = new Redis();
        $this->redis->connect($config['redis_ip'], $config['redis_port']);
        $this->redis->auth($config['redis_pwd']);
    }

    /**
     * 入队列
     * @param  array  $item 对象
     * @return mixed
     */
    public function push($item)
    {
       return $this->redis->lPush($this->queueKey, json_encode($item));
    }

    /**
     * 出队列
     * @return array
     */
    public function pop()
    {
        return json_decode($this->redis->rPop($this->queueKey), true);
    }
}
return new NekoCache(json_decode(CONFIG, true));