<?php
class Ship extends Fly
{
    /**
     * Ship owner's ID
     * @var int
     */
    protected $_userId;

    /**
     * Type of thip : master / battle / cargo / station
     * @var string
     */
    protected $_type;

    /**
     * Ship model's ID
     * @var int
     */
    protected $_model;

    /**
     * Position's ID
     * @var int
     */
    protected $_positionId;

    /**
     * State of the ship : land, flying, etc
     * @var string
     */
    protected $_state;

    protected static $_sqlTable = TABLE_SHIPS;

    public static function get($id)
    {
        if (is_numeric($id)) {
            return self::getAll($id);
        }
    }
    
    protected function _load($param)
    {
        if (!empty($param)) {
            $this->_id = $param['id'];
            $this->_userId = $param['userId'];
            $this->_type = $param['type'];
            $this->_model = $param['model'];
            $this->_positionId = $param['positionId'];
            $this->_state = $param['state'];
            $this->_sql = true;
        }
    }
    
    protected function _create()
    {
        $sql = FlyPDo::get();
        $req = $sql->prepare('INSERT INTO `'.self::$_sqlTable.'` VALUES("", :userId, :type, :model, :positionId, :state)');
        if ($req->execute(array(
            ':userId' => $this->_userId,
            ':type' => $this->_type,
            ':model' => $this->_type,
            ':positionId' => $this->_positionId,
            ':state' => $this->_state
        ))) {
            return $sql->lastInsertId();
        }
    }
    
    protected function _update()
    {
        
    }

    public function setPosition(Position $Position)
    {
        $this->_positionId = $Position->getId();
    }

    /**
     *
     * @param type $id
     * @param type $toArray
     * @param type $playerId
     * @param type $type
     * @param type $position
     */
    public static function getAll($id, $toArray=false, $playerId=null, $type=null, $position=null)
    {
        $where = '';
        $args = array();
        
        if ($id) {
            $where = 'WHERE id = :id';
            $args[':id'] = $id;
        }
        
        if ($playerId) {
            $where = 'WHERE `playerId` = :playerId';
            $args[':playerId'] = $playerId;
        }

        if ($type) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `type` = :type';
            $args[':type'] = $type;
        }

        if ($position) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `positionId` = :position';
            $args[':position'] = $position;
        }   
        
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT * FROM `'.self::$_sqlTable.'` '.$where);
        if ($req->execute($args)) {
            $array = array();
            while ($row = $req->fetch()) {
                if ($toArray) {
                    $array[$row['id']] = $row;
                } else {
                    $array[$row['id']] = new Ship($row);
                }
            }
        }
    }

    /**
     * Check if anybody is at given position
     * @param int $positionId
     * @return boolean
     */
    public static function isOn($positionId)
    {
        $array = self::getAll('', true, '', 'master', $positionId);
        if (!empty($array)) {
            return true;
        }
        return false;
    }
}