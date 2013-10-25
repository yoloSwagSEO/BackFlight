<?php
class Object extends Fly
{
    protected $_id;
    protected $_objectName;
    protected $_objectDescription;
    protected $_objectType;
    protected $_objectAttackType;
    protected $_objectAttackPower;
    protected $_objectRange;
    protected $_objectSpeed;
    protected $_objectWeight;
    protected $_objectCostTechs;
    protected $_objectCostFuel;
    protected $_objectCostEnergy;
    protected $_objectLaunchFuel;
    protected $_objectLaunchEnergy;

    protected $_objectTime;
    protected $_buildEnd;
    protected $_buildQuantity;


    /**
     * Default SQL table for this class
     * @var string
     */
    protected static $_sqlTable = TABLE_OBJECTS;


    public function getObjectName()
    {
        return $this->_objectName;
    }

    public function getObjectDescription()
    {
        return $this->_objectDescription;
    }

    public function getObjectType()
    {
        return $this->_objectType;
    }

    public function getObjectAttackType()
    {
        return $this->_objectAttackType;
    }

    public function getObjectAttackPower()
    {
        return $this->_objectAttackPower;
    }

    public function getObjectRange()
    {
        return $this->_objectRange;
    }

    public function getObjectSpeed()
    {
        return $this->_objectSpeed * GAME_SPEED;
    }

    public function getObjectWeight()
    {
        return $this->_objectWeight;
    }

    public function getObjectCostTechs()
    {
        return $this->_objectCostTechs;
    }

    public function getObjectCostFuel()
    {
        return $this->_objectCostFuel;
    }

    public function getObjectCostEnergy()
    {
        return $this->_objectCostEnergy;
    }

    public function getObjectLaunchFuel()
    {
        return $this->_objectLaunchFuel;
    }

    public function getObjectLaunchEnergy()
    {
        return $this->_objectLaunchEnergy;
    }
    
    public function getBuildEnd()
    {
        return $this->_buildEnd;
    }

    public function getBuildQuantity()
    {
        return $this->_buildQuantity;
    }

    public function isBuilding()
    {
        if ($this->_buildEnd > time()) {
            return true;
        }
    }

    public function getObjectTime()
    {
        return $this->_objectTime / GAME_SPEED;
    }




    public function setObjectName($objectName)
    {
        $this->_objectName = $objectName;
    }

    public function setObjectDescription($objectDescription)
    {
        $this->_objectDescription = $objectDescription;
    }

    public function setObjectType($objectType)
    {
        $this->_objectType = $objectType;
    }

    public function setObjectAttackType($objectAttackType)
    {
        $this->_objectAttackType = $objectAttackType;
    }

    public function setObjectAttackPower($objectAttackPower)
    {
        $this->_objectAttackPower = $objectAttackPower;
    }

    public function setObjectRange($objectRange)
    {
        $this->_objectRange = $objectRange;
    }

    public function setObjectSpeed($objectSpeed)
    {
        $this->_objectSpeed = $objectSpeed;
    }

    public function setObjectWeight($objectWeight)
    {
        $this->_objectWeight = $objectWeight;
    }

    public function setObjectCostTechs($objectCostTechs)
    {
        $this->_objectCostTechs = $objectCostTechs;
    }

    public function setObjectCostFuel($objectCostFuel)
    {
        $this->_objectCostFuel = $objectCostFuel;
    }

    public function setObjectCostEnergy($objectCostEnergy)
    {
        $this->_objectCostEnergy = $objectCostEnergy;
    }

    public function setObjectLaunchFuel($objectLaunchFuel)
    {
        $this->_objectLaunchFuel = $objectLaunchFuel;
    }

    public function setObjectLaunchEnergy($objectLaunchEnergy)
    {
        $this->_objectLaunchEnergy = $objectLaunchEnergy;
    }

    public function setObjectTime($objectTime)
    {
        $this->_objectTime = $objectTime;
    }


    /*
     * Load object values
     * @param array $param
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_objectName = $param['objectName'];
            $this->_objectDescription = $param['objectDescription'];
            $this->_objectType = $param['objectType'];
            $this->_objectAttackType = $param['objectAttackType'];
            $this->_objectAttackPower = $param['objectAttackPower'];
            $this->_objectRange = $param['objectRange'];
            $this->_objectSpeed = $param['objectSpeed'];
            $this->_objectWeight = $param['objectWeight'];
            $this->_objectCostTechs = $param['objectCostTechs'];
            $this->_objectCostFuel = $param['objectCostFuel'];
            $this->_objectCostEnergy = $param['objectCostEnergy'];
            $this->_objectLaunchFuel = $param['objectLaunchFuel'];
            $this->_objectLaunchEnergy = $param['objectLaunchEnergy'];
            $this->_objectTime = $param['objectTime'];

            if (!empty($param['buildEnd'])) {
                $this->_buildEnd = $param['buildEnd'];
                $this->_buildQuantity = $param['buildQuantity'];
            }
            
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :objectName, :objectDescription, :objectType, :objectTime, :objectAttackType, :objectAttackPower, :objectRange, :objectSpeed, :objectWeight, :objectCostTechs, :objectCostFuel, :objectCostEnergy, :objectLaunchFuel, :objectLaunchEnergy)');
        $args = array(
            ':id' => $this->_id,
            ':objectName' => $this->_objectName,
            ':objectDescription' => $this->_objectDescription,
            ':objectType' => $this->_objectType,
            ':objectTime' => $this->_objectTime,
            ':objectAttackType' => $this->_objectAttackType,
            ':objectAttackPower' => $this->_objectAttackPower,
            ':objectRange' => $this->_objectRange,
            ':objectSpeed' => $this->_objectSpeed,
            ':objectWeight' => $this->_objectWeight,
            ':objectCostTechs' => $this->_objectCostTechs,
            ':objectCostFuel' => $this->_objectCostFuel,
            ':objectCostEnergy' => $this->_objectCostEnergy,
            ':objectLaunchFuel' => $this->_objectLaunchFuel,
            ':objectLaunchEnergy' => $this->_objectLaunchEnergy
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `objectName` = :objectName, `objectDescription` = :objectDescription, `objectTime` = :objectTime, `objectType` = :objectType, `objectAttackType` = :objectAttackType, `objectAttackPower` = :objectAttackPower, `objectRange` = :objectRange, `objectSpeed` = :objectSpeed, `objectWeight` = :objectWeight, `objectCostTechs` = :objectCostTechs, `objectCostFuel` = :objectCostFuel, `objectCostEnergy` = :objectCostEnergy, `objectLaunchFuel` = :objectLaunchFuel, `objectLaunchEnergy` = :objectLaunchEnergy WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':objectName' => $this->_objectName,
            ':objectDescription' => $this->_objectDescription,
            ':objectType' => $this->_objectType,
            ':objectTime' => $this->_objectTime,
            ':objectAttackType' => $this->_objectAttackType,
            ':objectAttackPower' => $this->_objectAttackPower,
            ':objectRange' => $this->_objectRange,
            ':objectSpeed' => $this->_objectSpeed,
            ':objectWeight' => $this->_objectWeight,
            ':objectCostTechs' => $this->_objectCostTechs,
            ':objectCostFuel' => $this->_objectCostFuel,
            ':objectCostEnergy' => $this->_objectCostEnergy,
            ':objectLaunchFuel' => $this->_objectLaunchFuel,
            ':objectLaunchEnergy' => $this->_objectLaunchEnergy
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

        $add = '';
        if ($userId) {
            $args[':userIdM'] = $userId;
            $add = 'AND builds.userId = :userIdM';
        }


        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, builds.end buildEnd
                        FROM `'.static::$_sqlTable.'`
                    LEFT JOIN `'.TABLE_BUILDS.'` builds
                    ON builds.type = "object" AND builds.typeId = `'.static::$_sqlTable.'`.id AND (builds.state IS NULL OR builds.state NOT LIKE "%end%") '.$add.'
                '.$where.'
                    ORDER BY id');

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


                if (!empty($row['buildEnd'])) {
                }
                if (empty($param['buildEndSeen'][$row['buildEnd']])) {
                    if (!empty($row['buildEnd'])) {
                        if ($row['buildEnd'] > $param['buildEnd']) {
                            $param['buildEnd'] = $row['buildEnd'];
                        }
                    }
                    if (empty($param['buildQuantity'])) {
                        $param['buildQuantity'] = 0;
                    }
                    $param['buildQuantity']++;
                    $param['buildEndSeen'][$row['buildEnd']] = true;
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
            trigger_error('Unable to load in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }
}