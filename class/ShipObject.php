<?php
class ShipObject extends Fly
{
    protected $_id;
    protected $_shipId;
    protected $_type;
    protected $_typeId;
    protected $_typeOrder;
    protected $_typeEnabled;


    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_SHIPS_OBJECTS;


    public function getShipId()
    {
        return $this->_shipId;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getTypeId()
    {
        return $this->_moduleId;
    }

    public function getTypeOrder()
    {
        return $this->_moduleOrder;
    }

    public function getTypeEnabled()
    {
        return $this->_moduleEnabled;
    }



    public function setShipId($shipId)
    {
        $this->_shipId = $shipId;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setTypeId($moduleId)
    {
        $this->_typeId = $moduleId;
    }

    public function setTypeOrder($moduleOrder)
    {
        $this->_typeOrder = $moduleOrder;
    }

    public function setTypeEnabled($moduleEnabled)
    {
        $this->_typeEnabled = $moduleEnabled;
    }



    /*
     * Load object values
     * @param array $param Instanciation values
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_shipId = $param['shipId'];
            $this->_type = $param['type'];
            $this->_typeId = $param['typeId'];
            $this->_typeOrder = $param['typeOrder'];
            $this->_typeEnabled = $param['typeEnabled'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :shipId, :type, :typeId, :typeOrder, :typeEnabled)');
        $args = array(
            ':id' => $this->_id,
            ':shipId' => $this->_shipId,
            ':type' => $this->_type,
            ':typeId' => $this->_typeId,
            ':typeOrder' => $this->_typeOrder,
            ':typeEnabled' => $this->_typeEnabled
        );
        if ($req->execute($args)) {
            return $sql->lastInsertId();
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to save in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }


    protected function _update()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `shipId` = :shipId, `type` = :type, `typeId` = :typeId, `typeOrder` = :typeOrder, `typeEnabled` = :typeEnabled WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':shipId' => $this->_shipId,
            ':type' => $this->_type,
            ':typeId' => $this->_typeId,
            ':typeOrder' => $this->_typeOrder,
            ':typeEnabled' => $this->_typeEnabled
        );
        if ($req->execute($args)) {
            return $this->_id;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to update in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }

    public static function get($id)
    {
        $array = static::getAll($id, true);
        return array_shift($array);
    }

    public static function getAll($id = null, $to_array = false, $shipId = null, $type = null, $typeId = null, $typeEnabled = null)
    {
        $where = '';
        $args = array();

        if ($id) {
            if (empty($where)) {
                $where = ' WHERE ';
            }
            $where .= '`'.static::$_sqlTable.'`.id = :id';
            $args[':id'] = $id;
        }

        if ($shipId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.shipId = :shipId';
            $args[':shipId'] = $shipId;
        }

        if ($typeId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.typeId = :typeId';
            $args[':typeId'] = $typeId;
        }
        
        if ($typeEnabled !== null) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.typeEnabled = :typeEnabled';
            $args[':typeEnabled'] = $typeEnabled;
        }

        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.* FROM `'.static::$_sqlTable.'`'.$where);

        if ($req->execute($args)) {
            $current = 0;
            $loaded = false;
            $param = array();
            $class = get_called_class();
            while ($row = $req->fetch())
            {
                
                if ($current != $row['id'] && $current != '') {
                    if ($to_array) {
                        $array[$current] = $param;
                    } else {
                        $array[$current] = new $class($param);
                    }
                    $param = array();
                    $loaded = false;
                }

                $current = $row['id'];
                if (!$loaded) {
                    $loaded = true;
                    $param = $row;
                }

                

            }
            if (!empty($param)) {
                if ($to_array) {
                    $array[$current] = $param;
                } else {
                    $array[$current] = new $class($param);
                }
            }
            return $array;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to load from SQL', E_USER_ERROR);
        }
    }
}