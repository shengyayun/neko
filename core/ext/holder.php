<?php
class Holder
{
    private $neko;
    private $params;
    private $ismgr = false;

    /**
     * 处理
     * @param  array $neko
     * @param  array $params
     * @param  string $content
     * @return string
     */
    public function handle($neko, $params, $content)
    {
        $this->neko = $neko;
        $this->params = $params;
        $this->ismgr = array_key_exists('gnumber', $this->params) && $this->neko->context['group_base_info'][$this->params['gnumber']]['gtype'] == 'manage';
        $methods = array_diff(get_class_methods($this), ['handle']);
        foreach ($methods as $method)
        {
            if(preg_match_all("/\[$method(\(([\s\S]+)\))?\]/i", $content, $matches))
            {
                $content = str_ireplace($matches[0][0], $this->$method(empty($matches[1][0]) ? false : $matches[2][0]), $content);
            }
        }
        return $content;
    }

    /**
     * 丝丝的投票记录
     * @param  string $args 参数
     * @return string
     */
    public function vote($args)
    {
        $ext = $this->neko->sisi->voteInfo();
        return "愚蠢的丝丝的推荐票数为{$ext['support']}，总月票数为{$ext['all']}，当月月票数为{$ext['month']}";
    }

    /**
     * 丝丝的更新记录
     * @param  string $args 参数
     * @return string
     */
    public function update($args)
    {
        $ext = $this->neko->sisi->latestUpdate();
        return "愚蠢的丝丝上次更新在{$ext['raw_time']}" . ($ext['today'] ? '' : '，今天还没有更新');
    }

    /**
     * 催更
     * @param  string $args 参数
     * @return string
     */
    public function more($args)
    {
        if(!$args) return;
        if($this->ismgr)
        {
            $cache = $this->neko->cache->hGet('sisi_more', $args);
            if($cache == false)
            {
                $cache = 0;
            }
            $cache++;
            $this->neko->cache->hSet('sisi_more', $args, $cache);
            $result = $this->params['sender'] . "的催更值变动为{$cache}";
            $this->neko->api->shutupGroupMember($this->params['gnumber'], $args, ceil($cache / 5) * 60);
            $result .= "，同时他也为自己的愚蠢付出了代价";
            return $result;
        }
    }

    /**
     * 禁言某人
     * @param  string $args 参数
     * @return string
     */
    public function shutup($args)
    {
        if(!$args) return;
        if($this->ismgr)
        {
            if($this->params['sender_qq'] == 364624812)
            {
                $this->neko->api->shutupGroupMember($this->params['gnumber'], $args, rand(10, 20) * 60);
                return "要给黎妹特殊照顾～";
            }
            else
            {
                $time = rand(1, 10);
                $this->neko->api->shutupGroupMember($this->params['gnumber'], $args, $time * 60);
                return $this->params['sender'] . "获得了{$time}分钟的大礼包～";;
            }
        }
    }

    public function fortune($args)
    {
        return "TODO";
    }
}
return new Holder();