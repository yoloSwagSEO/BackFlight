<?php
class QuestStep extends Fly
{
    protected $_id;
    protected $_questId;
    protected $_stepName;
    protected $_stepDescription;
    protected $_stepPositionId;
    protected $_stepNb;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_QUESTSTEPS;


    public function getQuestId()
    {
        return $this->_questId;
    }

    public function getStepName()
    {
        return $this->_stepName;
    }

    public function getStepDescription()
    {
        return $this->_stepDescription;
    }

    public function getStepPositionId()
    {
        return $this->_stepPositionId;
    }

    public function getStepNb()
    {
        return $this->_stepNb;
    }



    public function setQuestId($questId)
    {
        $this->_questId = $questId;
    }

    public function setStepName($stepName)
    {
        $this->_stepName = $stepName;
    }

    public function setStepDescription($stepDescription)
    {
        $this->_stepDescription = $stepDescription;
    }

    public function setStepPositionId($stepPositionId)
    {
        $this->_stepPositionId = $stepPositionId;
    }

    public function setStepNb($stepNb)
    {
        $this->_stepNb = $stepNb;
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
            $this->_stepName = $param['stepName'];
            $this->_stepDescription = $param['stepDescription'];
            $this->_stepPositionId = $param['stepPositionId'];
            $this->_stepNb = $param['stepNb'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :questId, :stepName, :stepDescription, :stepPositionId, :stepNb)');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepName' => $this->_stepName,
            ':stepDescription' => $this->_stepDescription,
            ':stepPositionId' => $this->_stepPositionId,
            ':stepNb' => $this->_stepNb
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `questId` = :questId, `stepName` = :stepName, `stepDescription` = :stepDescription, `stepPositionId` = :stepPositionId, `stepNb` = :stepNb WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepName' => $this->_stepName,
            ':stepDescription' => $this->_stepDescription,
            ':stepPositionId' => $this->_stepPositionId,
            ':stepNb' => $this->_stepNb
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