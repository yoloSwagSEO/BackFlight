<?php
class Ressource extends Fly
{
    protected $_id;
    protected $_userId;
    protected $_into;
    protected $_intoId;
    protected $_type;
    protected $_quantity;
    protected $_quality = 1;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_RESSOURCES;


    public function getUserId()
    {
        return $this->_userId;
    }

    public function getInto()
    {
        return $this->_into;
    }

    public function getIntoId()
    {
        return $this->_intoId;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getQuantity()
    {
        return $this->_quantity;
    }

    public function getQuality()
    {
        return $this->_quality;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function setInto($into)
    {
        $this->_into = $into;
    }

    public function setIntoId($intoId)
    {
        $this->_intoId = $intoId;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
    }

    public function setQuality($quality)
    {
        $this->_quality = $quality;
    }



    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_userId = $param['userId'];
            $this->_into = $param['into'];
            $this->_intoId = $param['intoId'];
            $this->_type = $param['type'];
            $this->_quantity = $param['quantity'];
            $this->_quality = $param['quality'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :userId, :into, :intoId, :type, :quantity, :quality)');
        $args = array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':into' => $this->_into,
            ':intoId' => $this->_intoId,
            ':type' => $this->_type,
            ':quantity' => $this->_quantity,
            ':quality' => $this->_quality
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `userId` = :userId, `into` = :into, `intoId` = :intoId, `type` = :type, `quantity` = :quantity, `quality` = :quality WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':into' => $this->_into,
            ':intoId' => $this->_intoId,
            ':type' => $this->_type,
            ':quantity' => $this->_quantity,
            ':quality' => $this->_quality
        );
        if ($req->execute($args)) {
            return $this->_id;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Mise à jour impossible in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }

    public static function get($id, $args = null)
    {
        if (!empty($args[2])) {
            if (is_string($args[0])) {
                $array = static::getAll('', true, '', $args[1], $args[2], $args[0]);
            }
        }
        if (empty($array)) {
            $array = static::getAll($id, true);
        }
        return array_shift($array);
    }

    public static function getAll($id = null, $to_array = false, $userId = null, $intoType = null, $intoId = null, $type = null)
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

        if ($intoType) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.`into` = :into';
            $args[':into'] = $intoType;
        }

        if ($intoId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.intoId = :intoId';
            $args[':intoId'] = $intoId;
        }

        if ($type) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.`type` = :type';
            $args[':type'] = $type;
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