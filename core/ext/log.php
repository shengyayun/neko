<?php
/**
 * file log
 */
class NekoLog
{
    /**
     * 写个日志
     * @param  string $msg 日志内容
     * @return void
     */
    public function write($msg)
    {
        $folder = dirname(dirname(__DIR__)) . "/log/";
        if(!is_dir($folder)) mkdir($folder);
        $path = $folder . date('Y-m-d') . ".txt";
        file_put_contents($path, date("Y-m-d H:i:s") . "\t" . $msg . "\r\n", FILE_APPEND);
    }
}
return new NekoLog(json_decode(CONFIG, true));