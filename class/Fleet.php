<?php
class Fleet extends Fly
{
    protected $_userId;
    protected $_ships;
    protected $_moveId;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_FLEETS;


    public function getUserId()
    {
        return $this->_userId;
    }

    public function getShips()
    {
        return $this->_ships;
    }

    public function getMoveId()
    {
        return $this->_moveId;
    }



    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }


    public function setMoveId($moveId)
    {
        $this->_moveId = $moveId;
    }

    public function addShip($shipId)
    {
        $this->_ships[$shipId] = true;
    }

    public function takeOff($energy)
    {
        foreach ($this->_ships as $shipId => $value)
        {
            $Ship = new Ship($shipId);
            $Ship->setState('flying');
            $Ship->removeEnergy($energy);
            $Ship->save();
        }
    }



    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_userId = $param['userId'];
            $this->_ships = $param['ships'];
            $this->_moveId = $param['moveId'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:moveId, :userId, :shipId)');

        foreach ($this->_ships as $shipId)
        {
            $args = array(
                ':userId' => $this->_userId,
                ':shipId' => $shipId,
                ':moveId' => $this->_moveId
            );
            if (!$req->execute($args)) {
                var_dump($req->errorInfo());
                trigger_error('Enregistrement impossible in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
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
                // Nécessaire aux jointures (pour médias ou autres)
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

                // A partir d'ici, on charge les paramètres supplémentaires (par exemple conversion pour les médias)
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
            trigger_error('Chargement impossible', E_USER_ERROR);
        }
    }
}