<?php
class FlyPDO
{
    private static $_instance;
    private $_PDOInstance = null;

    private function __construct()
    {
        $this->_PDOInstance = new PDO(SQL_DSN, SQL_USER, SQL_PASS);
        if (defined('SQL_ENCODE')) {
            $this->_PDOInstance->exec('SET NAMES '.SQL_ENCODE);
        }
    }

    public static function get()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new FlyPDO();
        }
        return self::$_instance;
    }

    public function prepare($query)
    {
        $prepare = $this->_PDOInstance->prepare($query);
        $prepare->setFetchMode(PDO::FETCH_ASSOC);
        return $prepare;
    }

    public function lastInsertId()
    {
        return $this->_PDOInstance->lastInsertId();
    }
}
