<?php
class ShipModule extends Fly
{
    protected $_id;
    protected $_shipId;
    protected $_moduleId;
    protected $_moduleOrder;
    protected $_moduleEnabled;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_SHIPS_MODULES;


    public function getShipId()
    {
        return $this->_shipId;
    }

    public function getModuleId()
    {
        return $this->_moduleId;
    }

    public function getModuleOrder()
    {
        return $this->_moduleOrder;
    }

    public function getModuleEnabled()
    {
        return $this->_moduleEnabled;
    }



    public function setShipId($shipId)
    {
        $this->_shipId = $shipId;
    }

    public function setModuleId($moduleId)
    {
        $this->_moduleId = $moduleId;
    }

    public function setModuleOrder($moduleOrder)
    {
        $this->_moduleOrder = $moduleOrder;
    }

    public function setModuleEnabled($moduleEnabled)
    {
        $this->_moduleEnabled = $moduleEnabled;
    }



    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_shipId = $param['shipId'];
            $this->_moduleId = $param['moduleId'];
            $this->_moduleOrder = $param['moduleOrder'];
            $this->_moduleEnabled = $param['moduleEnabled'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :shipId, :moduleId, :moduleOrder, :moduleEnabled)');
        $args = array(
            ':id' => $this->_id,
            ':shipId' => $this->_shipId,
            ':moduleId' => $this->_moduleId,
            ':moduleOrder' => $this->_moduleOrder,
            ':moduleEnabled' => $this->_moduleEnabled
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `shipId` = :shipId, `moduleId` = :moduleId, `moduleOrder` = :moduleOrder, `moduleEnabled` = :moduleEnabled WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':shipId' => $this->_shipId,
            ':moduleId' => $this->_moduleId,
            ':moduleOrder' => $this->_moduleOrder,
            ':moduleEnabled' => $this->_moduleEnabled
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

    public static function getAll($id = null, $to_array = false, $shipId = null, $moduleId = null, $moduleEnabled = null)
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

        if ($moduleId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.moduleId = :moduleId';
            $args[':moduleId'] = $moduleId;
        }
        
        if ($moduleEnabled !== null) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.moduleEnabled = :moduleEnabled';
            $args[':moduleEnabled'] = $moduleEnabled;
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