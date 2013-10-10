<?php
class QuestRequirement extends Fly
{
    protected $_id;
    protected $_questId;
    protected $_stepId;
    protected $_requirementType;
    protected $_requirementValue;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_QUESTREQUIREMENTS;


    public function getQuestId()
    {
        return $this->_questId;
    }

    public function getStepId()
    {
        return $this->_stepId;
    }

    public function getRequirementType()
    {
        return $this->_requirementType;
    }

    public function getRequirementValue()
    {
        return $this->_requirementValue;
    }



    public function setQuestId($questId)
    {
        $this->_questId = $questId;
    }

    public function setStepId($stepId)
    {
        $this->_stepId = $stepId;
    }

    public function setRequirementType($requirementType)
    {
        $this->_requirementType = $requirementType;
    }

    public function setRequirementValue($requirementValue)
    {
        $this->_requirementValue = $requirementValue;
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
            $this->_requirementType = $param['requirementType'];
            $this->_requirementValue = $param['requirementValue'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :questId, :stepId, :requirementType, :requirementValue)');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepId' => $this->_stepId,
            ':requirementType' => $this->_requirementType,
            ':requirementValue' => $this->_requirementValue
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `questId` = :questId, `stepId` = :stepId, `requirementType` = :requirementType, `requirementValue` = :requirementValue WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepId' => $this->_stepId,
            ':requirementType' => $this->_requirementType,
            ':requirementValue' => $this->_requirementValue
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