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
}
return new Holder();