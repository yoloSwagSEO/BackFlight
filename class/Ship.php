<?php
class Ship extends Model
{
    /**
     * Ship owner's ID
     * @var int
     */
    protected $_userId;

    /**
     * Type of thip : master / battle / cargo / station
     * @var string
     */
    protected $_type;

    /**
     * Ship model's ID
     * @var int
     */
    protected $_model;

    /**
     * Position's ID
     * @var int
     */
    protected $_positionId;
    
    /**
     *
     * @var int
     */
    protected $_positionX;

    /**
     *
     * @var int
     */
    protected $_positionY;

    /**
     * The model's ship name
     * @var string (max 20 carac.)
     */
    protected $_modelName;

    /**
     * The model's ship category
     * @var string
     */
    protected $_modelCategory;

    /**
     * The model's ship type
     * @var string
     */
    protected $_modelType;

    /**
     *
     * @var int
     */
    protected $_load;

    /**
     *
     * @var int
     */
    protected $_energy;

    /**
     *
     * @var int
     */
    protected $_fuel;

    /**
     *
     * @var int
     */
    protected $_power;

    /**
     * Determine last time energy has been augmented
     * @var int
     */
    protected $_lastUpdate;

    /**
     * State of the ship : land, flying, etc
     * @var string
     */
    protected $_state;

    protected static $_sqlTable = TABLE_SHIPS;


    /**
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     *
     * @return int
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     *
     * @return string
     */
    public function getModelName()
    {
        return $this->_modelName;
    }

    /**
     *
     * @return string
     */
    public function getModelCategory()
    {
        return $this->_modelCategory;
    }

    /**
     *
     * @return string
     */
    public function getModelType()
    {
        return $this->_modelType;
    }

    /**
     *
     * @return int
     */
    public function getPositionId()
    {
        return $this->_positionId;
    }

    /**
     *
     * @return int
     */
    public function getPositionX()
    {
        return $this->_positionX;
    }

    /**
     *
     * @return int
     */
    public function getPositionY()
    {
        return $this->_positionY;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }

     public function getLoad()
    {
        return $this->_load;
    }

    public function getEnergy()
    {
        return $this->_energy;
    }

    public function getFuel()
    {
        return $this->_fuel;
    }

    public function getPower()
    {
        return $this->_power;
    }

    public function getLastUpdate()
    {
        return $this->_lastUpdate;
    }


    /**
     * User ID
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * The ship's type
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * The model of the ship
     * @param int $model Model ID
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }


    /**
     * Set the position
     * @param Position $Position
     */
    public function setPosition(Position $Position)
    {
        $this->_positionId = $Position->getId();
    }

    /**
     * Set ship's state
     * @param string $state flying / land / base, etc
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    public function setLoad($load)
    {
        if ($load > $this->_loadMax*SHIP_LOAD_TOLERANCE) {
            $this->_load = $this->_loadMax*SHIP_LOAD_TOLERANCE;
        }
        $this->_load = $load;
    }

    /**
     * Set energy level
     * @param int $energy
     * @return type
     */
    public function setEnergy($energy)
    {
        if ($energy > $this->_energyMax) {
            return $this->_energy = $this->_energyMax;
        }
        return $this->_energy = $energy;
    }

    /**
     * Set fuel level
     * @param int $fuel fuel level
     * @return boolean
     */
    public function setFuel($fuel)
    {
        if ($fuel > $this->_fuelMax) {
            return $this->_fuel = $this->_fuelMax;
        }
        return $this->_fuel = $fuel;
    }

    /**
     * Set ship's power
     * @param int $power power level
     * @return boolean r
     */
    public function setPower($power)
    {
        if ($power > $this->_powerMax) {
            return $this->_power = $this->_powerMax;
        }
        return $this->_power = $power;
    }

    public function setLastUpdate($lastUpdate)
    {
        $this->_lastUpdate = $lastUpdate;
    }

    /**
     * Check if load > loadMax
     * @return boolean
     */
    public function isOverloaded()
    {
        if ($this->_load > $this->_loadMax) {
            return true;
        }
        return false;
    }

    /**
     * Update ship energy
     */
    public function updateEnergy()
    {
        $time = time();
        $diff = $time - $this->_lastUpdate;
        if ($diff > 0) {
            $gain = $this->_energyGain / 3600 * $diff;
            $this->setEnergy($this->_energy + $gain);
            $this->setLastUpdate($time);
            $this->save();
        }
    }


    public static function get($id, $args=null)
    {
        $array = array();

        if (is_numeric($id)) {
            $array = self::getAll($id, true);
        } else {
            if (!empty($args[1])) {
                // $param[0] : type / $param[1] player ID:
                $array = self::getAll('', true, $args[1], $args[0]);
            }
        }

        if (!empty($array)) {
            return array_shift($array);
        }
    }
    
    protected function _load($param)
    {
        if (!empty($param)) {
            $this->_id = $param['id'];
            $this->_userId = $param['userId'];
            $this->_type = $param['type'];
            $this->_model = $param['model'];
            $this->_positionId = $param['positionId'];
            $this->_modelName = $param['modelName'];
            $this->_modelCategory = $param['modelCategory'];
            $this->_modelType = $param['modelType'];

            $this->_load = $param['load'];
            $this->_loadMax = $param['loadMax'];

            $this->_energy = $param['energy'];
            $this->_energyMax = $param['energyMax'];
            $this->_energyGain = $param['energyGain'];

            $this->_fuel = $param['fuel'];
            $this->_fuelMax = $param['fuelMax'];

            $this->_power = $param['power'];
            $this->_powerMax = $param['powerMax'];
            
            $this->_speed = $param['speed'];
            
            if (!empty($param['x'])) {
                $this->_positionX = $param['x'];
                $this->_positionY = $param['y'];
            }


            $this->_lastUpdate = $param['lastUpdate'];
            $this->_state = $param['state'];

            $this->_sql = true;
        }
    }
    
    protected function _create()
    {
        $sql = FlyPDo::get();
        $req = $sql->prepare('INSERT INTO `'.self::$_sqlTable.'` VALUES("", :userId, :type, :model, :positionId, :load, :energy, :fuel, :power, :state)');
        if ($req->execute(array(
            ':userId' => $this->_userId,
            ':type' => $this->_type,
            ':model' => $this->_model,
            ':positionId' => $this->_positionId,
            ':load' => $this->_load,
            ':energy' => $this->_energy,
            ':fuel' => $this->_fuel,
            ':power' => $this->_power,
            ':state' => $this->_state
        ))) {
            return $sql->lastInsertId();
        }
    }
    
    protected function _update()
    {
        $sql = FlyPDo::get();
        $req = $sql->prepare('UPDATE `'.self::$_sqlTable.'` 
            SET `userId` = :userId, `type` = :type, `model` = :model, `positionId` = :positionId, `load` = :load, `energy` = :energy, `fuel` = :fuel, `power` = :power, `lastUpdate` = :lastUpdate, `state` = :state');
        if ($req->execute(array(
            ':userId' => $this->_userId,
            ':type' => $this->_type,
            ':model' => $this->_model,
            ':positionId' => $this->_positionId,
            ':load' => $this->_load,
            ':energy' => $this->_energy,
            ':fuel' => $this->_fuel,
            ':power' => $this->_power,
            ':lastUpdate' => $this->_lastUpdate,
            ':state' => $this->_state
        ))) {
            return $this->_id;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Enregistrement impossible !', E_USER_ERROR);
        }
    }


    /**
     *
     * @param type $id
     * @param type $toArray
     * @param type $playerId
     * @param type $type
     * @param type $position
     */
    public static function getAll($id, $toArray=false, $userId=null, $type=null, $position=null)
    {
        $where = '';
        $args = array();
        
        if ($id) {
            $where = 'WHERE `'.self::$_sqlTable.'`.id = :id';
            $args[':id'] = $id;
        }
        
        if ($userId) {
            $where = 'WHERE `'.self::$_sqlTable.'`.`userId` = :userId';
            $args[':userId'] = $userId;
        }

        if ($type) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `'.self::$_sqlTable.'`.`type` = :type';
            $args[':type'] = $type;
        }

        if ($position) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `'.self::$_sqlTable.'`.`positionId` = :position';
            $args[':position'] = $position;
        }   
        
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT `'.self::$_sqlTable.'`.*, pos.x, pos.y, 
                mod.name modelName, mod.type modelType, mod.category modelCategory, mod.loadMax, mod.energyMax, mod.energyGain, mod.fuelMax, mod.powerMax, mod.speed
            FROM `'.self::$_sqlTable.'`
            LEFT JOIN `'.TABLE_POSITIONS.'` pos
                ON `'.self::$_sqlTable.'`.positionId =  pos.id
            LEFT JOIN `'.TABLE_MODELS.'` `mod`
                ON `'.self::$_sqlTable.'`.model = `mod`.id
        '.$where);
        if ($req->execute($args)) {
            $current = 0;
            $loaded = false;
            $param = array();
            $class = get_called_class();
            while ($row = $req->fetch())
            {
                // Nécessaire aux jointures (pour médias ou autres)
                if ($current != $row['id'] && $current != '') {
                    if ($toArray) {
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
                if ($toArray) {
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

    /**
     * Check if anybody is at given position
     * @param int $positionId
     * @return boolean
     */
    public static function isOn($positionId)
    {
        $array = self::getAll('', true, '', 'master', $positionId);
        if (!empty($array)) {
            return true;
        }
        return false;
    }
}