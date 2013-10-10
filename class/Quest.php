<?php
class Quest extends Fly
{
    protected $_id;
    protected $_name;
    protected $_intro;
    protected $_description;
    protected $_positionId;
    protected $_questType;
    protected $_state;
    protected $_userQuestId;
    protected $_userStepId;
    protected $_steps = array();


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_QUESTS;


    public function getName()
    {
        return $this->_name;
    }

    public function getIntro()
    {
        return $this->_intro;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getPositionId()
    {
        return $this->_positionId;
    }

    public function getQuestType()
    {
        return $this->_questType;
    }

    public function getSteps()
    {
        return $this->_steps;
    }

    public function getStep($stepId)
    {
        if (!empty($this->_steps[$stepId])) {
            return $this->_steps[$stepId];
        }
    }

    public function getState()
    {
        return $this->_state;
    }



    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setIntro($intro)
    {
        $this->_intro = $intro;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function setPositionId($positionId)
    {
        $this->_positionId = $positionId;
    }

    public function setQuestType($questType)
    {
        $this->_questType = $questType;
    }

    /**
     * Check if player has started this quest
     * @return boolean
     */
    public function isStartedByPlayer()
    {
        if ($this->_userQuestId) {
            if ($this->_state != 'end') {
                return true;
            }
        }
    }

    public function start($userId)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.TABLE_USERS_QUESTS.'` VALUES("", :userId, :questId, "")');
        if ($req->execute(array(
            ':userId' => $userId,
            ':questId' => $this->_id
        ))) {
            return true;
        }
    }


    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_name = $param['name'];
            $this->_intro = $param['intro'];
            $this->_description = $param['description'];
            $this->_positionId = $param['positionId'];
            $this->_questType = $param['questType'];
            $this->_sql = true;
            if (!empty($param['userQuestId'])) {
                $this->_state = $param['state'];
                $this->_userQuestId = $param['userQuestId'];
            }

            if (!empty($param['steps'])) {
                foreach ($param['steps'] as $stepId => $array_step)
                {
                    $array_step['id'] = $stepId;
                    $this->_steps[$stepId] = new QuestStep($array_step);
                }
            }
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :name, :intro, :description, :positionId, :questType)');
        $args = array(
            ':id' => $this->_id,
            ':name' => $this->_name,
            ':intro' => $this->_intro,
            ':description' => $this->_description,
            ':positionId' => $this->_positionId,
            ':questType' => $this->_questType
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `name` = :name, `intro` = :intro, `description` = :description, `positionId` = :positionId, `questType` = :questType WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':name' => $this->_name,
            ':intro' => $this->_intro,
            ':description' => $this->_description,
            ':positionId' => $this->_positionId,
            ':questType' => $this->_questType
        );
        if ($req->execute($args)) {
            return $this->_id;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Mise à jour impossible in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }

    public static function get($id, $args)
    {
        // $args[1] is userId
        if (!empty($args[1])) {
            $array = static::getAll($id, true, '', $args[1]);
        } else {
            $array = static::getAll($id, true);
        }
        return array_shift($array);
    }

    public static function getAll($id = null, $to_array = false, $positionId = null, $userId = null)
    {
        $where = '';
        $args = array();
        $join_req = '';
        $join_select = '';

        if ($id) {
            if (empty($where)) {
                $where = ' WHERE ';
            }
            $where .= '`'.static::$_sqlTable.'`.id = :id';
            $args[':id'] = $id;
        }

        if ($positionId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.positionId = :positionId';
            $args[':positionId'] = $positionId;
        }

        if ($userId) {
            // User quests
            $args[':userId'] = $userId;            
            $join_req .= ' INNER JOIN `'.TABLE_USERS_QUESTS.'` uQuest ON uQuest.userId = :userId AND uQuest.questId = `'.static::$_sqlTable.'`.id';
            $join_select .= ', uQuest.id userQuestId, uQuest.questState userQuestState';

            // User steps
            $args[':userId2'] = $userId;
            $join_req .= ' LEFT JOIN `'.TABLE_USERS_QUESTS_STEPS.'` uQuestStep ON uQuestStep.stepId = qStep.id AND uQuestStep.userId = :userId';
            $join_select .= ', uQuestStep.stepId userQuestStepId, uQuestStep.date userQuestStepDate';

            // User requirements
            $args[':userId2'] = $userId;
            $join_req .= ' LEFT JOIN `'.TABLE_USERS_QUESTS_REQUIREMENTS.'` uQuestRequirement ON uQuestRequirement.requirementId = qRequirement.id AND uQuestRequirement.userId = :userId';
            $join_select .= ', uQuestRequirement.requirementId uQuestRequirementId, uQuestRequirement.requirementQuantity uQuestRequirementQuantity ';
        }

        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, qStep.id stepId, qStep.stepName, qStep.stepPositionId, qStep.stepNb, qStep.stepDescription,
                        qRequirement.requirementType, qRequirement.requirementValue, qRequirement.stepId qRequirementStepId, qRequirement.id qRequirementId,
                        qGain.gainOperation, qGain.gainType, qGain.gainQuantity, qGain.stepId qGainStepId
                        '.$join_select.'
                    FROM `'.static::$_sqlTable.'`
                    INNER JOIN `'.TABLE_QUESTSTEPS.'` qStep
                        ON qStep.questId = `'.static::$_sqlTable.'`.id

                    INNER JOIN `'.TABLE_QUESTREQUIREMENTS.'` qRequirement
                        ON qRequirement.stepId = qStep.id

                    LEFT JOIN `'.TABLE_QUESTGAINS.'` qGain
                        ON qGain.stepId = qStep.id
                '.$join_req.'
                '.$where);


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
                if (!empty($row['userQuestId'])) {
                    $param['state'] = $row['userQuestState'];
                }

                if (!empty($row['uQuestStepId'])) {
                    if ($param['userQuestStep'] < $row['uQuestStepId']) {
                        $param['userQuestStep'] = $row['uQuestStepId'];
                    }
                }

                if (!empty($row['stepNb'])) {
                    if (empty($param['steps_seen'][$row['stepNb']])) {
                        $param['steps'][$row['stepId']] = array('stepName' => $row['stepName'], 'questId' => $row['id'], 'stepDescription' => $row['stepDescription'], 'stepNb' => $row['stepPositionId'], 'stepPositionId' => $row['stepNb']);
                        if (!empty($row['userQuestStepId'])) {
                            $param['steps'][$row['stepId']]['done'] = $row['userQuestStepDate'];
                        }
                        $param['steps_seen'][$row['stepId']] = true;
                    }
                }

                if (!empty($row['qRequirementStepId'])) {
                    $param['steps'][$row['stepId']]['requirements'][$row['qRequirementId']] = array('id' => $row['qRequirementId'], 'questId' => $row['id'], 'stepId' => $row['stepId'], 'requirementType' => $row['requirementType'], 'requirementValue' => 'requirementValue');
                }

                // User requirements
                if (!empty($row['uQuestRequirementId'])) {
                    if (empty($param['uRequirements_seen'][$row['uQuestRequirementId']])) {
                        $param['steps'][$row['stepId']]['user_requirements'][$row['uQuestRequirementId']] = $row['uQuestRequirementQuantity'];
                        $param['uRequirements_seen'][$row['uQuestRequirementId']] = true;
                    }
                }

                if (!empty($row['qGainStepId'])) {
                    $param['steps'][$row['stepId']]['gains'][$row['gainType']] = array('operation' => $row['gainOperation'], 'quantity' => $row['gainQuantity']);
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
            trigger_error('Chargement impossible', E_USER_ERROR);
        }
    }

    /**
     * Check if anybody is at given position
     * @param int $positionId
     * @return boolean
     */
    public static function isOn($positionId)
    {
        $array = self::getAll('', true, $positionId);
        if (!empty($array)) {
            return true;
        }
        return false;
    }

    public function getCurrentStep()
    {
        if (!$this->_userStepId) {
            return key($this->_steps);
        } else {
            return $this->_userStepId;
        }
    }

    public static function addAction(&$array_quests_player, $type, $quantity, $userId)
    {
        foreach ($array_quests_player as $Quest)
        {
            $QuestStep = $Quest->getStep($Quest->getCurrentStep());
            $requirementId = $QuestStep->hasRequirement($type);
            if ($requirementId) {
                $QuestStep->addUserStepRequirement($requirementId, $quantity, $userId);
            }
        }
    }
}