<?php
class Move extends Fly
{
    protected $_id;
    protected $_user;
    protected $_type;
    protected $_from;
    protected $_to;
    protected $_start;
    protected $_end;
    protected $_state;
    protected $_duration;


    /**
     * La table par défaut utilisée par la classe.
     * @var string
     */
    protected static $_sqlTable = TABLE_MOVES;


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
            $this->_to = $param['to'];
            $this->_start = $param['start'];
            $this->_duration = $param['duration'];
            $this->_end = $param['end'];
            $this->_state = $param['state'];
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
        $this->setState('flying');
        $this->save();
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