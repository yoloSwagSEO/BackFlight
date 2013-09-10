<?php
class Ship extends Fly
{
    protected static $_sqlTable = TABLE_SHIPS;

    public static function get($id)
    {
        if (is_numeric($id)) {
            return self::getAll($id);
        }
    }
    
    protected function _load()
    {
        
    }
    
    protected function _create()
    {
        
    }
    
    protected function _update()
    {
        
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