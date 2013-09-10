<?php
abstract class Fly
{
    protected $_id;
    protected $_sql;

    /**
     * Called when an object is instanciated
     * Check all requirements and exit if unsuccessfull
     * @param mixed $param
     */
    public function __construct($param = null)
    {
        // Check if required methods exists
        $required_methods = array('_create', '_update', '_load');
        $missing_methods = array();

        foreach ($required_methods as $method)
        {
            if (!method_exists($this, $method)) {
                $missing_methods[] = $method;
            }
        }
        
        if (!empty($missing_methods)) {
            $methods = implode(',', $missing_methods);
            trigger_error ($methods.' must be defined for '.get_class($this).'!', E_USER_ERROR);
        }

        // Instanciating object
        if (!empty($param)) {
            if (!is_array($param)) {
                $args = '';
                if (func_num_args() > 1) {
                    $args = func_get_args();
                }
                $param = static::get($param, $args);
            }
        } else if (func_num_args() > 1) {
            $args = func_get_args();
            $param = static::get($param, $args);
        }

        $this->_load($param);

    }

    /**
     * Return element's id
     * @return type
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Check if element is sql-loaded
     * @return boolean
     */
    public function isSql()
    {
        return $this->_sql;
    }

    /**
     * Save the element : create or update
     * @return int
     */
    public function save()
    {
        if (!$this->isSql()) {            
            $id = $this->_create();
        } else {
            $id = $this->_update();
        }
        return $id;

    }

    /**
     * Supprime l'objet de la base de données
     * @see iOwnWeb::delete()
     */
    public function delete()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('DELETE FROM '.static::$_tableSql.' WHERE id = :id');
        if ($req->execute()) {
            return true;
        }
        var_dump($req->errorInfo());
        trigger_error('Unable to delete', E_USER_ERROR);
    }

    /**
     * Get values for on element
     * @param int $id
     * @return array
     */
    public static function get($id, $args)
    {
        $array = array();
        if (!empty($id)) {
            $array = self::getAll(true, $id);
        }
        return array_shift($array);
    }

    /**
     * Get all elements of class
     * @param boolean $to_array true to return non instanciated values
     */
    public static function getAll($to_array = false, $id = null)
    {
        $array = array();
        $className = get_called_class();
        $args = array();
        $where = '';

        if (!empty($id)) {
            $where = ' WHERE id = :id';
            $args[':id'] = $id;
        }

        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT * FROM '.static::$_tableSql.$where);
        if ($req->execute($args)) {
            while ($row = $req->fetch())
            {
                if (!$to_array) {
                    $array[] = new $className($row);
                } else {
                    $array[] = $row;
                }
            }
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to get all');
        }
    }
}