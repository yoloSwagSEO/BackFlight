<?php
class Quest extends Fly
{
    protected $_id;
    protected $_name;
    protected $_intro;
    protected $_description;
    protected $_positionId;
    protected $_questType;


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

    public static function get($id)
    {
        $array = static::getAll($id, true);
        return array_shift($array);
    }

    public static function getAll($id = null, $to_array = false, $positionId = null)
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

        if ($positionId) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.positionId = :positionId';
            $args[':positionId'] = $positionId;
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
}