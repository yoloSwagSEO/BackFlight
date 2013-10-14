<?php
class Conversation extends Fly
{
    protected $_id;
    protected $_date;
    protected $_subject;
    protected $_tag;
    protected $_users;
    protected $_messages;


    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_CONVERSATIONS;


    public function getDate()
    {
        return $this->_date;
    }

    public function getTag()
    {
        return $this->_tag;
    }

    public function getSubject()
    {
        return $this->_subject;
    }

    public function getMessages()
    {
        return $this->_messages;
    }



    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }



    /*
     * Load object values
     * @param array $param Instanciation values
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_date = $param['date'];
            $this->_subject = $param['subject'];
            $this->_sql = true;

            if (!empty($param['users'])) {
                $this->_users = $param['users'];
            }

            if (!empty($param['messages'])) {
                foreach ($param['messages'] as $id => $param_message)
                $this->_messages[$id] = new Message($param_message);
            }
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :subject, :date)');
        $args = array(
            ':id' => $this->_id,
            ':subject' => $this->_subject,
            ':date' => $this->_date
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `date` = :date AND `subject` = :subject WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':subject' => $this->_subject,
            ':date' => $this->_date
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

    public static function getAll($id = null, $to_array = false, $userId = null)
    {
        $where = '';
        $args = array();
        $select_add = '';
        $join_add = '';

        if ($id) {
            if (empty($where)) {
                $where = ' WHERE ';
            }
            $where .= '`'.static::$_sqlTable.'`.id = :id';
            $args[':id'] = $id;
        }

        if ($userId) {
            $args[':userId'] = $userId;
            $join_add .= 'INNER JOIN `'.TABLE_CONVERSATIONS_USERS.'` cUser ON cUser.userId = :userId';
        }

        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, convUsers.userId userId, cMessages.date messageDate, cMessages.userFrom messageUserFrom, cMessages.content messageContent, cMessages.id messageId,
                        users.pseudo userPseudo
                    '.$select_add.'
                            FROM `'.static::$_sqlTable.'`
                    '.$join_add.'
                    LEFT JOIN `'.TABLE_CONVERSATIONS_USERS.'` convUsers
                        ON convUsers.conversationId = `'.static::$_sqlTable.'`.id
                    LEFT JOIN `'.TABLE_MESSAGES.'` cMessages
                        ON cMessages.conversationId = `'.static::$_sqlTable.'`.id
                    LEFT JOIN `'.TABLE_USERS.'` users
                        ON cMessages.userFrom = users.id
                '.$where);

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

                if (!empty($row['userId'])) {
                    $param['users'][$row['userId']] = $row['userId'];
                }


                if (!empty($row['messageId'])) {
                    if (empty($param['messages_seen'][$row['messageId']])) {
                        $param['messages'][$row['messageId']] = array('id' => $row['messageId'], 'conversationId' => $row['id'], 'userFrom' => $row['messageUserFrom'], 'userPseudo' => $row['userPseudo'], 'date' => $row['messageDate'], 'content' => $row['messageContent']);
                        $param['messages_seen'][$row['messageId']] = true;
                    }
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

    public function addUser($userId)
    {
        if (empty($this->_users[$userId])) {
            $sql = FlyPDO::get();
            $req = $sql->prepare('INSERT INTO `'.TABLE_CONVERSATIONS_USERS.'` VALUES("", :conversationId, :userId)');
            if ($req->execute(array(
                ':conversationId' => $this->_id,
                ':userId' => $userId
            ))) {
                return true;
            } else {
                var_dump($req->errorInfo());
                trigger_error('Unable to add user to conversation', E_USER_ERROR);
            }
        }
    }
}