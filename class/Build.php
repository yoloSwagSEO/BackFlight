<?php
class Build extends Fly
{
    protected $_id;
    protected $_type;
    protected $_typeId;
    protected $_userId;
    protected $_destination;
    protected $_destinationId;
    protected $_start;
    protected $_end;
    protected $_state;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_BUILDS;


    public function getType()
    {
        return $this->_type;
    }

    public function getTypeId()
    {
        return $this->_typeId;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function getDestination()
    {
        return $this->_destination;
    }

    public function getDestinationId()
    {
        return $this->_destinationId;
    }

    public function getStart()
    {
        return $this->_start;
    }

    public function getEnd()
    {
        return $this->_end;
    }

    public function getState()
    {
        return $this->_state;
    }



    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setTypeId($typeId)
    {
        $this->_typeId = $typeId;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function setDestination($destination)
    {
        $this->_destination = $destination;
    }

    public function setDestinationId($destinationId)
    {
        $this->_destinationId = $destinationId;
    }

    public function setStart($start)
    {
        $this->_start = $start;
    }

    public function setEnd($end)
    {
        $this->_end = $end;
    }

    public function setState($state)
    {
        $this->_state = $state;
    }



    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_type = $param['type'];
            $this->_typeId = $param['typeId'];
            $this->_userId = $param['userId'];
            $this->_destination = $param['destination'];
            $this->_destinationId = $param['destinationId'];
            $this->_start = $param['start'];
            $this->_end = $param['end'];
            $this->_state = $param['state'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :type, :typeId, :userId, :destination, :destinationId, :start, :end, :state)');
        $args = array(
            ':id' => $this->_id,
            ':type' => $this->_type,
            ':typeId' => $this->_typeId,
            ':userId' => $this->_userId,
            ':destination' => $this->_destination,
            ':destinationId' => $this->_destinationId,
            ':start' => $this->_start,
            ':end' => $this->_end,
            ':state' => $this->_state
        );
        if ($req->execute($args)) {
            return $sql->lastInsertId();
        } else {
            var_dump($req->errorInfo());
            trigger_error('Enregistrement impossible in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }


    protected function _update()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `type` = :type, `typeId` = :typeId, `userId` = :userId, `destination` = :destination, `destinationId` = :destinationId, `start` = :start, `end` = :end, `state` = :state WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':type' => $this->_type,
            ':typeId' => $this->_typeId,
            ':userId' => $this->_userId,
            ':destination' => $this->_destination,
            ':destinationId' => $this->_destinationId,
            ':start' => $this->_start,
            ':end' => $this->_end,
            ':state' => $this->_state
        );
        if ($req->execute($args)) {
            return $this->_id;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Mise à jour impossible in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }

    public static function get($id)
    {
        $array = static::getAll($id, true);
        return array_shift($array);
    }

    /**
     *
     * @param type $id
     * @param type $to_array
     * @param type $userId
     * @return \class
     */
    public static function getAll($id = null, $to_array = false, $userId = null, $state = null)
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
        
        if ($userId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.userId = :userId';
            $args[':userId'] = $userId;
        }

        if (!$state) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.`state` IS NULL OR `'.static::$_sqlTable.'`.`state` NOT LIKE "%end%"';
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
                // Nécessaire aux jointures (pour médias ou autres)
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

                // A partir d'ici, on charge les paramètres supplémentaires (par exemple conversion pour les médias)

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
            trigger_error('Chargement impossible', E_USER_ERROR);
        }
    }
}