<?php
/**
 * MySql
 */
class NekoDB
{
    /**
     * db
     * @var PDO
     */
    private $db;

    /**
     * __construct
     */
    public function __construct($config)
    {
        $this->db = new PDO($config['mysql_path'], $config['mysql_user'], $config['mysql_pwd']);
    }

     /**
     * mysql select
     * @param  string $sql    sql
     * @param  array  $params 参数
     * @return array
     */
    public function select($sql, $params = array())
    {
        $sth = $this->db->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * mysql query
     * @param  string $sql    sql
     * @param  array  $params 参数
     * @return mixed
     */
    public function query($sql, $params = array())
    {
        $sth = $this->db->prepare($sql);
        return $sth->execute($params);
    }
}
return new NekoDB(json_decode(CONFIG, true));