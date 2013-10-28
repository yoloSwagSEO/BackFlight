<?php
class Conversation extends Fly
{
    protected $_id;
    protected $_date;
    protected $_subject;
    protected $_tag;
    protected $_users;
    protected $_usersPseudos;
    protected $_usersDate;
    protected $_messages;


    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_CONVERSATIONS;

    /**
     * Get conversation date
     * @return int
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Get conversation tag
     * @return string
     */
    public function getTag()
    {
        return $this->_tag;
    }

    /**
     * Get conversation subject
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * Get conversation messages
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
    }


    /**
     * Set conversation timestamp
     * @param int $date
     */
    public function setDate($date)
    {
        $this->_date = $date;
    }

    /**
     * Set conversation subject
     * @param string $subject
     */
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
                $this->_usersPseudos = $param['usersPseudos'];
                $this->_usersDates = $param['usersDates'];
            }

            if (!empty($param['messages'])) {
                foreach ($param['messages'] as $date => $array_messages)
                {
                    foreach ($array_messages as $id => $param_message)
                    $this->_messages[$date][$id] = new Message($param_message);
                }
                ksort($this->_messages);
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

    public static function get($id, $args = null)
    {
        // $args[1] is userId
        if (!empty($args[1])) {
            $array = static::getAll($id, true, $args[1]);
        } else {
            $array = static::getAll($id, true);
        }
        return array_shift($array);
    }

    /**
     *
     * @param type $id
     * @param type $to_array
     * @param type $userId
     * @return \class
     */
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
            $args[':userId2'] = $userId;
            $join_add .= 'INNER JOIN `'.TABLE_CONVERSATIONS_USERS.'` cUser ON cUser.userId = :userId AND cUser.conversationId = `'.static::$_sqlTable.'`.id
                    LEFT JOIN `'.TABLE_CONVERSATIONS_READ.'` cRead
                        ON (cRead.messageId = cMessages.id AND cRead.userId = :userId2)';
            $select_add .= ', cRead.messageId messageReadId';
        }

        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, convUsers.userId userId, cMessages.date messageDate, cMessages.userFrom messageUserFrom, cMessages.content messageContent, cMessages.id messageId,
                        users.pseudo userPseudo, users2.pseudo usersPseudos, users2.id usersId, convUsers.date userDate
                    '.$select_add.'
                            FROM `'.static::$_sqlTable.'`
                    INNER JOIN `'.TABLE_CONVERSATIONS_USERS.'` convUsers
                        ON convUsers.conversationId = `'.static::$_sqlTable.'`.id
                    INNER JOIN `'.TABLE_MESSAGES.'` cMessages
                        ON cMessages.conversationId = `'.static::$_sqlTable.'`.id
                    INNER JOIN `'.TABLE_USERS.'` users
                        ON cMessages.userFrom = users.id
                    INNER JOIN `'.TABLE_USERS.'` users2
                        ON convUsers.userId = users2.id
                    '.$join_add.'
                '.$where.'
                    ORDER BY cMessages.date');

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

                if (!empty($row['usersId'])) {
                    if (empty($param['users'])) {
                        $param['usersId'] = array();
                        $param['usersPseudos'] = array();
                        $param['users_seen'] = array();
                        $param['users_date'] = array();
                    }

                    if (empty($param['users_seen'][$row['usersId']])) {
                        $param['users'][$row['usersId']] = $row['usersId'];
                        $param['usersPseudos'][$row['usersId']] = $row['usersPseudos'];
                        $param['users_seen'][$row['usersId']] = true;
                        $param['usersDates'][$row['usersPseudos']] = $row['userDate'];
                    }
                }

                if (!empty($row['messageId'])) {
                    if (empty($param['messages_seen'][$row['messageId']])) {
                        $param['messages'][$row['messageDate']][$row['messageId']] = array('id' => $row['messageId'], 'conversationId' => $row['id'], 'userFrom' => $row['messageUserFrom'], 'userPseudo' => $row['userPseudo'], 'date' => $row['messageDate'], 'content' => $row['messageContent']);
                        $param['messages_seen'][$row['messageId']] = true;
                        if (!empty($row['messageReadId'])) {
                            if ($row['messageReadId'] == $row['messageId']) {
                                $param['messages'][$row['messageDate']][$row['messageId']]['read'] = true;
                            }
                        }
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

    /**
     * Add an user to this conversation
     * @param int $userId userId
     * @return boolean
     */
    public function addUser($userId)
    {
        if (empty($this->_users[$userId])) {
            $sql = FlyPDO::get();
            $req = $sql->prepare('INSERT INTO `'.TABLE_CONVERSATIONS_USERS.'` VALUES("", :conversationId, :userId, :time)');
            if ($req->execute(array(
                ':conversationId' => $this->_id,
                ':userId' => $userId,
                ':time' => time()
            ))) {
                return true;
            } else {
                var_dump($req->errorInfo());
                trigger_error('Unable to add user to conversation', E_USER_ERROR);
            }
        }
    }

    /**
     * Get conversation's users
     * @param boolean $full si true, récupère les pseudos
     * @return array
     */
    public function getUsers($full = false)
    {
        if ($full) {
            return $this->_usersPseudos;
        }
        return $this->_users;
    }

    /**
     * Get conversations's user add date
     * @return array
     */
    public function getUsersDate()
    {
        return $this->_usersDates;
    }

    /**
     * Is conversation read for user
     * @return boolean
     */
    public function isRead()
    {
        foreach ($this->_messages as $messages)
        {
            foreach ($messages as $Message)
            {
                if (!$Message->isRead()) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get last message date
     * @return int
     */
    public function getLastDate()
    {
        end($this->_messages);
        return key($this->_messages);
    }
}