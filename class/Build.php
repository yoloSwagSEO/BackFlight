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
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_BUILDS;

    /**
     * Get build type
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Get build typeId
     * @return type
     */
    public function getTypeId()
    {
        return $this->_typeId;
    }

    /**
     * Get userId
     * @return int userId
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Get build destination (eg. ship)
     * @return varchar
     */
    public function getDestination()
    {
        return $this->_destination;
    }

    /**
     * Get build destination ID
     * @return int
     */
    public function getDestinationId()
    {
        return $this->_destinationId;
    }

    /**
     * Get build start
     * @return int
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * Get build end
     * @return int
     */
    public function getEnd()
    {
        return $this->_end;
    }

    /**
     * Get build state
     * @return varchar
     */
    public function getState()
    {
        return $this->_state;
    }


    /**
     * Set build type (eg. module, object)
     * @param varchar $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * Set type id
     * @param int $typeId
     */
    public function setTypeId($typeId)
    {
        $this->_typeId = $typeId;
    }

    /**
     * Set userId
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * Set destination type
     * @param varchar $destination
     */
    public function setDestination($destination)
    {
        $this->_destination = $destination;
    }

    /**
     * Set destination ID
     * @param int $destinationId
     */
    public function setDestinationId($destinationId)
    {
        $this->_destinationId = $destinationId;
    }

    /**
     * Set start timestamp
     * @param int $start
     */
    public function setStart($start)
    {
        $this->_start = $start;
    }

    /**
     * Set end timestamp
     * @param int $end
     */
    public function setEnd($end)
    {
        $this->_end = $end;
    }

    /**
     * Set build type
     * @param varchar $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }



    /*
     * Load object values
     * @param array $param Instanciation values
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
            trigger_error('Unable to save in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
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
            trigger_error('Unable to update in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
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
     * @param type $state
     * @param type $type
     * @param type $destination
     * @param type $destinationId
     * @param type $typeId
     * @return \class
     */
    public static function getAll($id = null, $to_array = false, $userId = null, $state = null, $type = null, $destination = null, $destinationId = null, $typeId = null)
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
            $where .= '(`'.static::$_sqlTable.'`.`state` IS NULL OR `'.static::$_sqlTable.'`.`state` NOT LIKE "%end%")';
        } else {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.`state` = :state';
            $args[':state'] = $state;
        }


        if ($type) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.type = :type';
            $args[':type'] = $type;
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

        if ($destination) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.destination = :destination';
            $args[':destination'] = $destination;
        }

        if ($destinationId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.destinationId = :destinationId';
            $args[':destinationId'] = $destinationId;
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

    /**
     *
     * @param type $type
     * @param type $userId
     * @param type $destination
     * @param type $destinationId
     * @return type
     */
    public static function getTimeEndBuild($type, $userId, $destination, $destinationId)
    {
        $end = 0;
        $array_builds = self::getAll('', '', $userId, '', $type, $destination, $destinationId);
        foreach ($array_builds as $Build)
        {
            if ($Build->getEnd() > $end) {
                $end = $Build->getEnd();
            }
        }
        return $end;
    }

    /**
     *
     * @param type $type
     * @param type $typeId
     * @param type $userId
     * @param type $destination
     * @param type $destinationId
     * @return type
     */
    public static function getQueueFor($type, $typeId, $userId, $destination, $destinationId)
    {
        $array_builds = self::getAll('', '', $userId, '', $type, $destination, $destinationId, $typeId);
        return count($array_builds);
    }
}