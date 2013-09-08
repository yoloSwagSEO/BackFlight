<?php
class Ship extends Fly
{
    
    public function get($id)
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
    
    public function getAll($id, $toArray=false, $playerId=null, $type=null)
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
        
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT * FROM `'.TABLE_SHIPS.'` '.$where);
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
}