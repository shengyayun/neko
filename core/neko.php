<?php
/**
 * neko
 */
class Neko
{
    /**
     * __construct
     */
    public function __construct()
    {
        define('ROOT', dirname(__DIR__));
        //debug
        if(php_sapi_name() == 'cli' || array_key_exists('debug', $_GET))
        {
            ini_set('display_errors', 1);
            error_reporting(-1);
        }
        //配置
        $file = __DIR__ . "/config";
        if(!file_exists($file))
        {
            echo "put your config at '$file'";
            die;
        }
        foreach (file($file) as $row) 
        {
            if(empty(trim($row))) continue;
            $line = explode('=>', $row);
            $config[trim($line[0])] = trim($line[1]);
        }
        define('CONFIG', json_encode($config));
        //扩展
        $folder = __DIR__ . "/ext/";
        foreach (scandir($folder) as $path) 
        {
            $file = $folder . $path;
            if(is_file($file))
            {
                $this->{basename($path, '.php')} = require $file;
            }
        }
    }

    /**
     * 主线程
     * @return void
     */
    public function main()
    {
        $this->interval();
        $current = date('i');
        while($current == date('i'))
        {
            usleep(500000);
            $this->poll();
        }
    }


    /**
     * 定时,每分钟跑一次
     * @return void
     */
    public function interval()
    {
        $rs = $this->db->select("select msg from task where time = '" . date('H:i') . "'");
        foreach ($rs as $row)
        {
            $this->broadcast($row['msg']);
        }
    }

    /**
     * 群发
     * @return void
     */
    public function broadcast($msg)
    {
        if($msg !== false)
        {
            foreach ($this->api->getDiscussInfo() as $discuss) 
            {
                $this->api->sendDiscussMessage($discuss['did'], $msg);
            }
            foreach ($this->api->getGroupInfo() as $group) 
            {
                $this->api->sendGroupMessage($group['gnumber'], $msg);
            }
        }
    }


    /**
     * 心跳,每秒钟跑一次
     * @return void
     */
    public function poll()
    {
        $msg = $this->cache->pop();
        if(!$msg) return;
        $this->log->write(str_replace(array("\r", "\n", "\r\n"), "", var_export($msg, true)) . "\r\n");
        $rs = $this->db->select("select * from lexicon");
        $list = array();
        foreach ($rs as $row) 
        {
            if(!preg_match($this->blur2regex($row['key']), $msg['content'], $match)) continue;
            $value = $row['value'];
            foreach ($match as $index => $holder)
            {
                if($index == 0) continue;
                $value = str_ireplace("[$index]", $match[$index], $value);
            }
            $list[] = $value;
        }
        if(count($list) == 0) return;
        shuffle($list);
        $reply = $list[0];
        switch($msg['type'])
        {
            case 'message': 
                $this->api->sendMessage($msg['sender_qq'], $reply);
                break;
            case 'discuss_message': 
                $this->api->sendDiscussMessage($msg['discuss_id'], $reply);
                break;
            case 'group_message': 
                $this->api->sendGroupMessage($msg['gnumber'], $reply);
                break;
        }
    }

    /**
     * 可以把我的模糊查询词条变更为正则表达式
     * @param  string $str 原字符串
     * @return string      新字符串
     */
    private function blur2regex($str)
    {
        $str = preg_replace("/\*/", "&holder;", $str);
        $mapping = array("\\"=> "\\\\", "$"=> "\\$", "("=> "\\(", ")"=> "\\)", "["=> "\\[", "]"=> "\\]", "{"=> "\\{", "}"=> "\\}", "*"=> "\\*", "+"=> "\\+", "?"=> "\\?", "^"=> "\\^", "|"=> "\\|", "."=> "\\.");
        $words = str_split($str);
        foreach ($words as &$word) 
        {
            if(array_key_exists($word, $mapping))
            {
                $word = $mapping[$word];
            }
        }
        $str = implode('', $words);
        $str = "/^" . preg_replace("/&holder;/", "(.*)", $str) . "$/";
        return $str;
    }
}