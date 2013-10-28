<?php
class Fleet extends Fly
{
    protected $_userId;
    protected $_ships;
    protected $_actionId;


    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_FLEETS;

    /**
     * Get userId
     * @return int userId
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Get fleet's ships
     * @return array
     */
    public function getShips()
    {
        return $this->_ships;
    }

    /**
     * Get fleet's actionId
     * @return int
     */
    public function getActionId()
    {
        return $this->_actionId;
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
     * Set acionId
     * @param int $actionId
     */
    public function setActionId($actionId)
    {
        $this->_actionId = $actionId;
    }

    /**
     * Add a ship to the fleet
     * @param int $shipId
     */
    public function addShip($shipId)
    {
        $this->_ships[$shipId] = true;
    }

    /**
     * Make all the fleet takeoff
     * @param int $energy
     * @param int $fuel
     */
    public function takeOff($energy, $fuel)
    {
        foreach ($this->_ships as $shipId => $value)
        {
            $Ship = new Ship($shipId);
            $Ship->setState('flying');
            $Ship->removeEnergy($energy);
            $Ship->removeFuel($fuel);
            $Ship->save();
        }
    }

    /**
     * Start the whole fleet
     * @param string $type the ships' states
     */
    public function start($type)
    {
        foreach ($this->_ships as $shipId => $value)
        {
            $Ship = new Ship($shipId);
            $Ship->setState($type);
            $Ship->save();
        }
    }


    /*
     * Load object values
     * @param array $param Instanciation values
     */
    protected function _load($param)
    {
        if($param) {
            $this->_userId = $param['userId'];
            $this->_ships = $param['ships'];
            $this->_actionId = $param['moveId'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:moveId, :userId, :shipId)');

        foreach ($this->_ships as $shipId => $null)
        {
            $args = array(
                ':userId' => $this->_userId,
                ':shipId' => $shipId,
                ':moveId' => $this->_actionId
            );
            if (!$req->execute($args)) {
                var_dump($req->errorInfo());
                trigger_error('Unable to save in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
            }
            
        }

    }


    protected function _update()
    {
        // TODO : fleets update
        exit('Not functionnal');
    }

    public static function get($id)
    {
        $array = static::getAll($id, true);
        return array_shift($array);
    }

    public static function getAll($id = null, $to_array = false, $userId = null)
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
                
                if ($current != $row['moveId'] && $current != '') {
                    if ($to_array) {
                        $array[$current] = $param;
                    } else {
                        $array[$current] = new $class($param);
                    }
                    $param = array();
                    $loaded = false;
                }

                $current = $row['moveId'];
                if (!$loaded) {
                    $loaded = true;
                    $param = $row;
                }

                
                $param['ships'][$row['shipId']] = $row['shipId'];

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