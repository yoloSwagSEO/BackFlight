<?php
class Notification extends Fly
{
    protected $_id;
    protected $_userId;
    protected $_date;
    protected $_importance;
    protected $_into;
    protected $_intoId;
    protected $_type;
    protected $_typeId;
    protected $_action;
    protected $_actionType;
    protected $_actionId;
    protected $_actionSub;
    protected $_read = NOTIFICATION_UNREAD;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_NOTIFICATIONS;


    public function getUserId()
    {
        return $this->_userId;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function getImportance()
    {
        return $this->_importance;
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

    public function getTypeId()
    {
        return $this->_typeId;
    }

    public function getAction()
    {
        return $this->_action;
    }

    public function getActionType()
    {
        return $this->_actionType;
    }

    public function getActionId()
    {
        return $this->_actionId;
    }

    public function getActionSub()
    {
        return $this->_actionSub;
    }


    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setImportance($importance)
    {
        $this->_importance = $importance;
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

    public function setTypeId($typeId)
    {
        $this->_typeId = $typeId;
    }

    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function setActionType($actionType)
    {
        $this->_actionType = $actionType;
    }

    public function setActionId($actionId)
    {
        $this->_actionId = $actionId;
    }

    public function setActionSub($actionSub)
    {
        $this->_actionSub = $actionSub;
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
            $this->_date = $param['date'];
            $this->_importance = $param['importance'];
            $this->_into = $param['into'];
            $this->_intoId = $param['intoId'];
            $this->_type = $param['type'];
            $this->_typeId = $param['typeId'];
            $this->_action = $param['action'];
            $this->_actionType = $param['actionType'];
            $this->_actionId = $param['actionId'];
            $this->_actionSub = $param['actionSub'];
            $this->_read = $param['read'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        if (empty($this->_userId)) {
            $this->_userId = $_SESSION['User'];
        }
        if (empty($this->_date)) {
            $this->_date = time();
        }
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :userId, :date, :importance, :into, :intoId, :type, :typeId, :action, :actionType, :actionId, :actionSub, :read)');
        $args = array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':date' => $this->_date,
            ':importance' => $this->_importance,
            ':into' => $this->_into,
            ':intoId' => $this->_intoId,
            ':type' => $this->_type,
            ':typeId' => $this->_typeId,
            ':action' => $this->_action,
            ':actionType' => $this->_actionType,
            ':actionId' => $this->_actionId,
            ':actionSub' => $this->_actionSub,
            ':read' => $this->_read,
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
        if (empty($this->_userId)) {
            $this->_userId = $_SESSION['User'];
        }
        if (empty($this->_date)) {
            $this->_date = time();
        }
        $sql = FlyPDO::get();
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `userId` = :userId, `date` = :date, `importance` = :importance, `into` = :into, `intoId` = :intoId, `type` = :type, `typeId` = :typeId, `action` = :action, `actionType` = :actionType, `actionId` = :actionId, `actionSub` = :actionSub, `read` = :read WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':date' => $this->_date,
            ':importance' => $this->_importance,
            ':into' => $this->_into,
            ':intoId' => $this->_intoId,
            ':type' => $this->_type,
            ':typeId' => $this->_typeId,
            ':action' => $this->_action,
            ':actionType' => $this->_actionType,
            ':actionId' => $this->_actionId,
            ':actionSub' => $this->_actionSub,
            ':read' => $this->_read
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

    public static function getAll($id = null, $to_array = false, $read = null, $userId = null)
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

        if ($read) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where = ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.read = :read';
            $args[':read'] = $read;
        }

        if ($userId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where = ' AND ';
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

    public function renderTitle()
    {
        return $this->_type.' : '.$this->_typeId.'('.$this->_actionType.' '.$this->_action.')';
    }
}