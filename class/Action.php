<?php
class Action extends Fly
{
    protected $_id;
    protected $_user;
    protected $_type;
    protected $_from;
    protected $_toY;
    protected $_fromX;
    protected $_fromY;
    protected $_to;
    protected $_toX;
    protected $_start;
    protected $_end;
    protected $_state;
    protected $_ships;
    protected $_duration;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_ACTIONS;


    public function getUser()
    {
        return $this->_user;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getFrom()
    {
        return $this->_from;
    }

    public function getTo()
    {
        return $this->_to;
    }

    public function getStart()
    {
        return $this->_start;
    }

    public function getEnd()
    {
        return $this->_end;
    }

    public function getState()
    {
        return $this->_state;
    }

    public function getShips()
    {
        return $this->_ships;
    }

    public function getDuration()
    {
        return $this->_duration;
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setFrom($from)
    {
        $this->_from = $from;
    }

    public function setTo($to)
    {
        $this->_to = $to;
    }

    public function setStart($start)
    {
        $this->_start = $start;
    }

    public function setEnd($end)
    {
        $this->_end = $end;
    }

    public function setState($state)
    {
        $this->_state = $state;
    }

    public function setDuration($duration)
    {
        $this->_duration = $duration;
    }


    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_user = $param['user'];
            $this->_type = $param['type'];
            $this->_from = $param['from'];
            $this->_fromX = $param['fromX'];
            $this->_fromY = $param['fromY'];
            $this->_toX = $param['toX'];
            $this->_toY = $param['toY'];
            $this->_to = $param['to'];
            $this->_start = $param['start'];
            $this->_duration = $param['duration'];
            $this->_end = $param['end'];
            $this->_state = $param['state'];
            if (!empty($param['ships'])) {
                $this->_ships = $param['ships'];
            }
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :user, :type, :from, :to, :start, :duration, :end, :state)');
        $args = array(
            ':id' => $this->_id,
            ':user' => $this->_user,
            ':type' => $this->_type,
            ':from' => $this->_from,
            ':to' => $this->_to,
            ':start' => $this->_start,
            ':duration' => $this->_duration,
            ':end' => $this->_end,
            ':state' => $this->_state
        );
        if ($req->execute($args)) {
            return $sql->lastInsertId();
        } else {
            var_dump($req->errorInfo());
            trigger_error('Enregistrement impossible in '.__FILE__.' on line '.__LINE__.' ! ', E_USER_ERROR);
        }
    }

    /**
     * Starting to move
     */
    public function start()
    {
        $this->setStart(time());
        $this->setEnd(time() + $this->_duration);
        $this->setState('current');
        return $this->save();
    }

    public function land()
    {
        foreach ($this->_ships as $shipId => $null)
        {
            $Ship = new Ship($shipId);
            $Ship->setState('arrived');
            $Ship->setPosition(new Position($this->_to));
            $Ship->save();
        }
        $this->setState('arrived');
        $this->save();
    }

    public function countRemainingTime()
    {
        return $this->_end - time();
    }

    protected function _update()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `user` = :user, `type` = :type, `from` = :from, `to` = :to, `start` = :start, `end` = :end, `duration` = :duration, `state` = :state WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':user' => $this->_user,
            ':type' => $this->_type,
            ':from' => $this->_from,
            ':to' => $this->_to,
            ':start' => $this->_start,
            ':duration' => $this->_duration,
            ':end' => $this->_end,
            ':state' => $this->_state,
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

    public static function getAll($id = null, $to_array = false, $userId = null, $state = null)
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
            $where .= '`'.static::$_sqlTable.'`.user = :userId';
            $args[':userId'] = $userId;
        }

        if ($state) {
            if (empty($where)) {
                $where = ' WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= '`'.static::$_sqlTable.'`.`state` = :state';
            $args[':state'] = $state;
        }

        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, posFrom.x fromX, posFrom.y fromY, posTo.x toX, posto.y toY, fleets.shipId ship FROM `'.static::$_sqlTable.'`
                        LEFT JOIN `'.TABLE_POSITIONS.'` posFrom
                            ON posFrom.id = `'.static::$_sqlTable.'`.from
                        LEFT JOIN `'.TABLE_POSITIONS.'` posTo
                            ON posTo.id = `'.static::$_sqlTable.'`.to
                        LEFT JOIN `'.TABLE_FLEETS.'` fleets
                            ON fleets.moveId = `'.static::$_sqlTable.'`.id
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

                $param['ships'][$row['ship']] = true;

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