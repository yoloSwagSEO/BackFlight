<?php
class Message extends Fly
{
    protected $_id;
    protected $_conversationId;
    protected $_userFrom;
    protected $_userPseudo;
    protected $_date;
    protected $_content;
    protected $_read;


    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_MESSAGES;


    public function getConversationId()
    {
        return $this->_conversationId;
    }

    public function getUserFrom($full = false)
    {
        if ($full) {
            return $this->_userPseudo;
        }
        return $this->_userFrom;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function getSubject()
    {
        return $this->_subject;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function getRead()
    {
        return $this->_read;
    }



    public function setConversationId($conversationId)
    {
        $this->_conversationId = $conversationId;
    }

    public function setUserFrom($userFrom)
    {
        $this->_userFrom = $userFrom;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }




    /*
     * Load object values
     * @param array $param Instanciation values
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_conversationId = $param['conversationId'];
            $this->_userFrom = $param['userFrom'];
            $this->_userPseudo = $param['userPseudo'];
            $this->_date = $param['date'];
            $this->_content = $param['content'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :conversationId, :userFrom, :date, :content)');
        $args = array(
            ':id' => $this->_id,
            ':conversationId' => $this->_conversationId,
            ':userFrom' => $this->_userFrom,
            ':date' => $this->_date,
            ':content' => $this->_content
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `conversationId` = :conversationId, `userFrom` = :userFrom, `date` = :date, `content` = :content WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':conversationId' => $this->_conversationId,
            ':userFrom' => $this->_userFrom,
            ':date' => $this->_date,
            ':content' => $this->_content
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
}