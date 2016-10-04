<?php
/**
 * Mojo-Webqq
 */
class NekoAPI
{
    /**
     * api地址
     * @var string
     */
    private $url = null;

    /**
     * __construct
     */
    public function __construct($config)
    {
        $this->url = $config['mojowebqq_url'];
    }

    /**
     * 获取用户数据
     * @return array
     */
    public function getUserInfo()
    {
        return json_decode(file_get_contents("$this->url/get_user_info"), true);
    }

    /**
     * 获取好友数据
     * @return array
     */
    public function getFriendInfo()
    {
        return json_decode(file_get_contents("$this->url/get_friend_info"), true);
    }

    /**
     * 拉取讨论组列表
     * @return array
     */
    public function getDiscussInfo()
    {
        return json_decode(file_get_contents("$this->url/get_discuss_info"), true);
    }

    /**
     * 拉取群组列表
     * @return array
     */
    public function getGroupInfo()
    {
        return json_decode(file_get_contents("$this->url/get_group_info"), true);
    }

    /**
     * 获取群组基础数据
     * @return array
     */
    public function getGroupBasicInfo()
    {
        return json_decode(file_get_contents("$this->url/get_group_basic_info"), true);
    }

    /**
     * 发送好友消息
     * @param  integer $qq      好友的QQ号
     * @param  string  $content 消息内容
     * @return array
     */
    public function sendMessage($qq, $content)
    {
        $this->pause();
        return json_decode(file_get_contents("$this->url/send_message?qq=$qq&content=" . urlencode($content)));
    }

    /**
     * 发送讨论组信息
     * @param  integer $did 讨论组id
     * @param  string  $content 消息内容
     * @return array
     */
    public function sendDiscussMessage($did, $content)
    {
        $this->pause();
        return json_decode(file_get_contents("$this->url/send_discuss_message?did=$did&content=" . urlencode($content)));
    }


    /**
     * 发送群组信息
     * @param  integer $gnumber 群qq
     * @param  string  $content 消息内容
     * @return array
     */
    public function sendGroupMessage($gnumber, $content)
    {
        $this->pause();
        return json_decode(file_get_contents("$this->url/send_group_message?gnumber=$gnumber&content=" . urlencode($content)));
    }

    /**
     * 休息一下
     * @param  integer $sec seconds
     * @return void
     */
    private function pause($sec = 1)
    {
        sleep($sec);
    }
}
return new NekoAPI(json_decode(CONFIG, true));