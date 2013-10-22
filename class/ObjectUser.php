<?php
class ObjectUser extends Object
{
    protected $_id;
    protected $_objectType;
    protected $_objectModel;
    protected $_objectUserId;
    protected $_objectFrom;
    protected $_objectFromX;
    protected $_objectFromY;
    protected $_objectFromId;
    protected $_objectTo;
    protected $_objectToId;
    protected $_objectStart;
    protected $_objectState;

    protected $_positionShipX;
    protected $_positionShipY;


    /**
     * Default SQL table for this class
     * @var string
     */
    protected static $_sqlTable = TABLE_OBJECTUSERS;


    public function getObjectType()
    {
        return $this->_objectType;
    }

    public function getObjectModel()
    {
        return $this->_objectModel;
    }

    public function getObjectUserId()
    {
        return $this->_objectUserId;
    }

    public function getObjectFrom()
    {
        return $this->_objectFrom;
    }

    public function getObjectFromId()
    {
        return $this->_objectFromId;
    }

    public function getObjectFromX()
    {
        return $this->_objectFromX;
    }

    public function getObjectFromY()
    {
        return $this->_objectFromY;
    }

    public function getObjectTo()
    {
        return $this->_objectTo;
    }

    public function getObjectToId()
    {
        return $this->_objectToId;
    }

    public function getObjectStart()
    {
        return $this->_objectStart;
    }

    public function getObjectState()
    {
        return $this->_objectState;
    }

    public function getPositionShipX()
    {
        return $this->_positionShipX;
    }

    public function getPositionShipY()
    {
        return $this->_positionShipY;
    }



    public function setObjectType($objectType)
    {
        $this->_objectType = $objectType;
    }

    public function setObjectModel($objectModel)
    {
        $this->_objectModel = $objectModel;
    }

    public function setObjectUserId($objectUserId)
    {
        $this->_objectUserId = $objectUserId;
    }

    public function setObjectFrom($objectFrom)
    {
        $this->_objectFrom = $objectFrom;
    }

    public function setObjectFromId($objectFromId)
    {
        $this->_objectFromId = $objectFromId;
    }

    public function setObjectTo($objectTo)
    {
        $this->_objectTo = $objectTo;
    }

    public function setObjectToId($objectToId)
    {
        $this->_objectToId = $objectToId;
    }

    public function setObjectStart($objectStart)
    {
        $this->_objectStart = $objectStart;
    }

    public function setObjectState($objectState)
    {
        $this->_objectState = $objectState;
    }



    /*
     * Load object values
     * @param array $param
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_objectType = $param['objectType'];
            $this->_objectModel = $param['objectModel'];
            $this->_objectUserId = $param['objectUserId'];
            $this->_objectFrom = $param['objectFrom'];
            $this->_objectFromId = $param['objectFromId'];
            $this->_objectFromX = $param['positionFromX'];
            $this->_objectFromY = $param['positionFromY'];
            $this->_objectTo = $param['objectTo'];
            $this->_objectToId = $param['objectToId'];

            $this->_objectName = $param['objectName'];
            $this->_objectDescription = $param['objectDescription'];
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

            if ($this->_objectTo == 'ship') {
                $this->_positionShipX = $param['positionShipX'];
                $this->_positionShipY = $param['positionShipY'];
            }

            $this->_objectStart = $param['objectStart'];
            $this->_objectState = $param['objectState'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :objectType, :objectModel, :objectUserId, :objectFrom, :objectFromId, :objectTo, :objectToId, :objectStart, :objectState)');
        $args = array(
            ':id' => $this->_id,
            ':objectType' => $this->_objectType,
            ':objectModel' => $this->_objectModel,
            ':objectUserId' => $this->_objectUserId,
            ':objectFrom' => $this->_objectFrom,
            ':objectFromId' => $this->_objectFromId,
            ':objectTo' => $this->_objectTo,
            ':objectToId' => $this->_objectToId,
            ':objectStart' => $this->_objectStart,
            ':objectState' => $this->_objectState
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `objectType` = :objectType, `objectModel` = :objectModel, `objectUserId` = :objectUserId, `objectFrom` = :objectFrom, `objectFromId` = :objectFromId, `objectTo` = :objectTo, `objectToId` = :objectToId, `objectStart` = :objectStart, `objectState` = :objectState WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':objectType' => $this->_objectType,
            ':objectModel' => $this->_objectModel,
            ':objectUserId' => $this->_objectUserId,
            ':objectFrom' => $this->_objectFrom,
            ':objectFromId' => $this->_objectFromId,
            ':objectTo' => $this->_objectTo,
            ':objectToId' => $this->_objectToId,
            ':objectStart' => $this->_objectStart,
            ':objectState' => $this->_objectState
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
        $join_add = '';
        $select_add = '';

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
                $where .= ' AND';
            }

            $select_add = ', usersTo.id userId, posShip.x positionShipX, posShip.y positionShipY, pos.x positionFromX, pos.y positionFromY,
                obj.objectRange, obj.objectSpeed, obj.objectName, obj.objectDescription, obj.objectAttackType, obj.objectAttackPower,
                obj.objectWeight, obj.objectCostTechs, obj.objectCostFuel, obj.objectCostEnergy, obj.objectLaunchFuel, obj.objectLaunchEnergy, obj.objectTime';


            $join_add .= '
                LEFT JOIN `'.TABLE_SHIPS.'` shipsTo
                    ON `'.static::$_sqlTable.'`.objectTo = "ship" AND shipsTo.id = `'.static::$_sqlTable.'`.objectToId
                        
                LEFT JOIN `'.TABLE_USERS.'` usersTo
                    ON (usersTo.id = shipsTo.userId)

                LEFT JOIN `'.TABLE_POSITIONS.'` posShip
                    ON shipsTo.positionId = posShip.id
                    
                LEFT JOIN `'.TABLE_POSITIONS.'` pos
                    ON `'.static::$_sqlTable.'`.objectFromId = pos.id

                INNER JOIN `'.TABLE_OBJECTS.'` obj
                    ON `'.static::$_sqlTable.'`.objectModel = obj.id';
            
            $where .= '(usersTo.id = :userId OR objectUserId = :userId2)';
            $args[':userId'] = $userId;
            $args[':userId2'] = $userId;
        }


        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.* '.$select_add.'
                        FROM `'.static::$_sqlTable.'`
                        '.$join_add.'

                        '.$where);

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
            trigger_error('Unable to load in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }

    public function destroy()
    {
        $this->delete();
    }
}