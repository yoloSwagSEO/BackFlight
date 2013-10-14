<?php
class QuestRequirement extends Fly
{
    protected $_id;
    protected $_questId;
    protected $_stepId;
    protected $_requirementType;
    protected $_requirementQuantity;
    protected $_requirementValue;
    protected $_requirementValueUser;


    /**
     * Default SQL table
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

    public function getRequirementValueUser()
    {
        return $this->_requirementValueUser;
    }

    public function getRequirementQuantity()
    {
        return $this->_requirementQuantity;
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

    public function setRequirementQuantity($requirementQuantity)
    {
        $this->_requirementQuantity = $requirementQuantity;
    }



    /*
     * Load object values
     * @param array $param Instanciation values
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_questId = $param['questId'];
            $this->_stepId = $param['stepId'];
            $this->_requirementType = $param['requirementType'];
            $this->_requirementValue = $param['requirementValue'];
            $this->_requirementQuantity = $param['requirementQuantity'];
            if (!empty($param['userRequirement'])) {
                $this->_requirementValueUser = $param['userRequirement'];
            }
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :questId, :stepId, :requirementType, :requirementValue, :requirementQuantity)');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepId' => $this->_stepId,
            ':requirementType' => $this->_requirementType,
            ':requirementValue' => $this->_requirementValue,
            ':requirementQuantity' => $this->_requirementQuantity
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `questId` = :questId, `stepId` = :stepId, `requirementType` = :requirementType, `requirementValue` = :requirementValue, `requirementQuantity` = :requirementQuantity WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':questId' => $this->_questId,
            ':stepId' => $this->_stepId,
            ':requirementType' => $this->_requirementType,
            ':requirementValue' => $this->_requirementValue,
            ':requirementQuantity' => $this->_requirementQuantity
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
            trigger_error('Unable to load from SQL', E_USER_ERROR);
        }
    }

    /**
     * Check if user has complete this requirement
     * @return boolean
     */
    public function isDone()
    {
        if ($this->_requirementQuantity <= $this->_requirementValueUser) {
            return true;
        }
    }


    /**
     *
     * @param int $requirementQuantity
     * @param int $userId
     */
    public function addUserStepRequirement($requirementQuantity, $userId)
    {
        if (empty($this->_requirementValueUser)) {
            $this->_createUserStepRequirement($requirementQuantity, $userId);
        } else {
            $requirementQuantity = $this->_requirementValueUser + $requirementQuantity;
            $this->_updateUserStepRequirement($requirementQuantity, $userId);
        }

        $this->_requirementValueUser = $requirementQuantity;

        // If requirement is OK
        if ($this->isDone()) {
            $Notification = new Notification();
            $Notification->setType(TABLE_QUESTS);
            $Notification->setTypeId($this->getQuestId());
            $Notification->setImportance('NOTIFICATION_IMPORTANCE_LOW');
            $Notification->setAction('requirement_ok');
            $Notification->setActionId($this->_id);
            $Notification->setActionType($this->_id);
            $Notification->save();
        }
    }

    /**
     * Create a requirement step for an user
     * @param int $requirementQuantity
     * @param int $userId
     */
    protected function _createUserStepRequirement($requirementQuantity, $userId)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.TABLE_USERS_QUESTS_REQUIREMENTS.'` VALUES("", :userId, :requirementId, :requirementQuantity)');
        if (!$req->execute(array(
            ':userId' => $userId,
            ':requirementId' => $this->_id,
            ':requirementQuantity' => $requirementQuantity
        ))) {
            var_dump($req->errorInfo());
            trigger_error('Unable to save userStepRequirement', E_USER_ERROR);
        }
    }

    /**
     * Update an existing requirement step for an user
     * @param int $requirementQuantity
     * @param int $userId
     */
    protected function _updateUserStepRequirement($requirementQuantity, $userId)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('UPDATE `'.TABLE_USERS_QUESTS_REQUIREMENTS.'` SET requirementQuantity = :requirementQuantity WHERE userId = :userId AND requirementId = :requirementId');
        if (!$req->execute(array(
            ':userId' => $userId,
            ':requirementId' => $this->_id,
            ':requirementQuantity' => $requirementQuantity
        ))) {
            var_dump($req->errorInfo());
            trigger_error('Unable to save userStepRequirement', E_USER_ERROR);
        }
    }
}