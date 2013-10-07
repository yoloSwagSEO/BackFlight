<?php
class QuestGain extends Fly
{
    protected $_id;
    protected $_questId;
    protected $_stepId;
    protected $_gainType;
    protected $_gainQuantity;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_QUESTGAINS;


    public function getQuestId()
    {
        return $this->_questId;
    }

    public function getStepId()
    {
        return $this->_stepId;
    }

    public function getGainType()
    {
        return $this->_gainType;
    }

    public function getGainQuantity()
    {
        return $this->_gainQuantity;
    }



    public function setQuestId($questId)
    {
        $this->_questId = $questId;
    }

    public function setStepId($stepId)
    {
        $this->_stepId = $stepId;
    }

    public function setGainType($gainType)
    {
        $this->_gainType = $gainType;
    }

    public function setGainQuantity($gainQuantity)
    {
        $this->_gainQuantity = $gainQuantity;
    }



    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_questId = $param['questId'];
            $this->_stepId = $param['stepId'];
            $this->_gainType = $param['gainType'];
            $this->_gainQuantity = $param['gainQuantity'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :questId, :stepId, :gainType, :gainQuantity)');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepId' => $this->_stepId,
            ':gainType' => $this->_gainType,
            ':gainQuantity' => $this->_gainQuantity
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `questId` = :questId, `stepId` = :stepId, `gainType` = :gainType, `gainQuantity` = :gainQuantity WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepId' => $this->_stepId,
            ':gainType' => $this->_gainType,
            ':gainQuantity' => $this->_gainQuantity
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

    public static function getAll($id = null, $to_array = false)
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