<?php
class Rank extends Fly
{
    protected $_id;
    protected $_userId;
    protected $_userPseudo;
    protected $_date;
    protected $_distance;
    protected $_ressources;
    protected $_position;
    protected $_global;
    protected $_lastUpdate = null;


    protected static $_sqlTable = TABLE_RANKS;


    public function getUserId()
    {
        return $this->_userId;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function getDistance()
    {
        return $this->_distance;
    }

    public function getRessources()
    {
        return $this->_ressources;
    }

    public function getPosition()
    {
        return $this->_position;
    }

    public function getGlobal()
    {
        return $this->_global;
    }

    public function getUserPseudo()
    {
        return $this->_userPseudo;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setDistance($distance)
    {
        $this->_distance = $distance;
    }

    public function setRessources($ressources)
    {
        $this->_ressources = $ressources;
    }

    public function setPosition($position)
    {
        $this->_position = $position;
    }

    public function setGlobal($global)
    {
        $this->_global = $global;
    }


    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_userId = $param['userId'];
            $this->_userPseudo = $param['userPseudo'];
            $this->_date = $param['date'];
            $this->_distance = $param['distance'];
            $this->_ressources = $param['ressources'];
            $this->_position = $param['position'];
            $this->_global = $param['global'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :userId, :date, :distance, :ressources, :position, :global)');
        $args = array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':date' => $this->_date,
            ':distance' => $this->_distance,
            ':ressources' => $this->_ressources,
            ':position' => $this->_position,
            ':global' => $this->_global
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `userId` = :userId, `date` = :date, `distance` = :distance, `ressources` = :ressources, `position` = :position, `global` = :global WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':date' => $this->_date,
            ':distance' => $this->_distance,
            ':ressources' => $this->_ressources,
            ':position' => $this->_position,
            ':global' => $this->_global
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

    /**
     *
     * @param type $id
     * @param type $to_array
     * @param type $date
     * @param type $order
     * @return \class
     */
    public static function getAll($id = null, $to_array = false, $date = null, $order = 'global')
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
        
        if ($date) {
            if (empty($where)) {
                $where = ' WHERE ';
            }
            $where .= '`'.static::$_sqlTable.'`.date = :date';
            $args[':date'] = $date;
        }

        if ($order) {
            if ($order == 'global' || $order == 'ressources' || $order == 'distance' || $order == 'position') {
                $order = 'ORDER BY `'.$order.'` DESC';
            } else {
                $order = '';
            }
        }
        
        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, users.pseudo userPseudo FROM `'.static::$_sqlTable.'`
            INNER JOIN `'.TABLE_USERS.'` users
                ON users.id = `'.static::$_sqlTable.'`.userId
            '.$where.' '.$order);

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
            trigger_error('Unable to load', E_USER_ERROR);
        }
    }

    public function getLastUpdate()
    {
        if ($this->_lastUpdate != null) {
            return $this->_lastUpdate;
        }
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT `date` FROM `'.static::$_sqlTable.'` ORDER BY date DESC LIMIT 1');
        if ($req->execute()) {
            while ($row = $req->fetch())
            {
                return $row['date'];
            }
        }
        return 0;
    }


    public function updateRanks()
    {
        $time = time();
        $lastUpdate = $this->getLastUpdate();

        if ($time - $lastUpdate > 5 * 60) {


            $array_masterships = Ship::getAll('', '', '', 'master');
            $array_users_ressources = Position::getAllPositionSearches($lastUpdate, $time);
            $array_users_distances = Action::getAllDistances($lastUpdate, $time);

            $base_distance = Position::calculateDistance(800, 0, 0, 0);

            $array_ranks = Rank::getAll('', '', $lastUpdate);
            $array_users_ranks = array();


            foreach ($array_ranks as $Rank)
            {
                $array_users_ranks[$Rank->getUserId()] = $Rank;
            }

            foreach ($array_masterships as $MasterShip)
            {
                $position = $base_distance - Position::calculateDistance($MasterShip->getPositionX(), $MasterShip->getPositionY(), 0, 0);

                $RankUser = new Rank();
                $RankUser->setDate($time);

                $distance = 0;
                $ressources = 0;
                
                if (!empty($array_users_ranks[$MasterShip->getUserId()])) {
                    $RankUserPrevious = $array_users_ranks[$MasterShip->getUserId()];
                    $distance = $RankUserPrevious->getDistance();
                    $ressources = $RankUserPrevious->getRessources();
                }


                if (!empty($array_users_ressources[$MasterShip->getUserId()])) {
                    $ressources += $array_users_ressources[$MasterShip->getUserId()];
                }
                $RankUser->setRessources($ressources);

                if (!empty($array_users_distances[$MasterShip->getUserId()])) {
                    $distance += $array_users_distances[$MasterShip->getUserId()];
                }
                $RankUser->setDistance($distance);

                $RankUser->setPosition($position);

                $RankUser->setGlobal($this->_calculateGlobal($position, $distance, $ressources));
                $RankUser->setUserId($MasterShip->getUserId());
                $RankUser->save();
            }

            $this->_lastUpdate = $time;
        }




    }

    private function _calculateGlobal($position, $distance, $ressources)
    {
        return $position + $distance / 2 + $ressources / 3;
    }

    public static function getFor($array_ranks, $userId)
    {
        $i = 1;
        foreach ($array_ranks as $Rank)
        {
            if ($Rank->getUserId() == $userId) {
                return array('global' => $i);
            }
            $i++;
        }
    }
}