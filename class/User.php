<?php
class User extends Fly
{
    private $_pseudo;
    private $_password;
    private $_rank;
    private $_mail;
    private $_connected = false;

    protected static $_sqlTable = TABLE_USERS;

    public function setPseudo($pseudo)
    {
        if (self::_isPseudoValid($pseudo)) {
            if (self::_isPseudoAvailable($pseudo)) {
                $this->_pseudo = $pseudo;
                return true;
            } else {
                return 'unavailable';
            }
        } else {
            return 'invalid';
        }
    }

    public function setMail($mail)
    {
        if (self::_isMailValid($mail)) {
            if (self::_isMailAvailable($mail)) {
                $this->_mail = $mail;
                return true;
            } else {
                return 'unavailable';
            }
        } else {
            return 'invalid';
        }
    }

    public function getPseudo()
    {
        return $this->_pseudo;
    }

    public function getMail()
    {
        return $this->_mail;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getRank()
    {
        return $this->_rank;
    }

    public function setPassword($password)
    {
        $this->_password = self::_generatePassword($password);
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setRank($rank)
    {
        $this->_rank = $rank;
    }

    public function connexion($password)
    {
        if ($this->_checkPassword($password)) {
            $_SESSION['User'] = $this->_id;
            $this->_connected = true;
            session_regenerate_id();
            return true;
        }
    }

    public function deconnexion()
    {
        session_destroy();
        session_start();
    }

    public function isConnected()
    {
        return $this->_connected;
    }

    protected function _load($param)
    {
        if (!empty($param)) {
            $this->_sql = true;
            $this->_id = $param['id'];
            $this->_pseudo = $param['pseudo'];
            $this->_password = $param['password'];
            $this->_mail = $param['mail'];

            $this->_rank = $param['rank'];
            
            if (!empty($_SESSION['User'])) {
                if ($_SESSION['User'] == $this->_id) {
                    $this->_connected = true;
                }
            }
        }
    }

    protected function _create()
    {
        if (empty($this->_pseudo) || empty($this->_password) || empty($this->_mail)) {
            trigger_error('Missings values (pseudo, password, mail) for creating an user!', E_USER_ERROR);
        }
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO '.self::$_sqlTable.' VALUES ("", :pseudo, :password, :mail, :rank)');
        if ($req->execute(array(':pseudo' => $this->_pseudo, ':password' => $this->_password, ':rank' => $this->_rank, ':mail' => $this->_mail))) {
            return $sql->lastInsertId();
        } else {
            exit('Create User failed in '.__FILE__.' on line '.__LINE__.' ! '.var_dump($req->errorInfo()));
        }
    }

    protected function _update()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `pseudo` = :pseudo, `password` = :password, `mail` = :mail, `rank` = :rank WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':pseudo' => $this->_pseudo,
            ':password' => $this->_password,
            ':mail' => $this->_mail,
            ':rank' => $this->_rank
        );
        if ($req->execute($args)) {
            return $this->_id;
        } else {
            exit('Update User failed in '.__FILE__.' on line '.__LINE__.' ! '.var_dump($req->errorInfo()));
        }
    }

    public static function get($id, $args)
    {
        // Loading from pseudo
        if (!empty($args)) {
            $pseudo = $args[0];
            $array = self::getAll(true, null, $pseudo);

        // Loading from ID
        } else {
            $array = self::getAll(true, $id);
        }

        if (empty($args)) {
            if (!empty($array[$id])) {
                return $array[$id];
            }
        } else {
            return array_shift($array);
        }
    }

    public static function getAll($to_array, $id = null, $pseudo = null, $rank = null)
    {
        $sql = FlyPDO::get();
        $array_users = array();
        $where = '';
        $cond = false;
        $args = array();
        if (!empty($id) || !empty($pseudo) || !empty($rank)) {
            $where = 'WHERE';
            if (!empty($pseudo)) {
                if ($cond) {
                    $where .= ',';
                }
                $where .= ' pseudo = :pseudo';
                $args[':pseudo'] = $pseudo;
            }
            if (!empty($id)) {
                if ($cond) {
                    $where .= ',';
                }
                $where .= ' u.id = :id';
                $args[':id'] = $id;
            }
            if (!empty($rank)) {
                if ($cond) {
                    $where .= ',';
                }
                $where .= ' u.rank = :rank';
                $args[':rank'] = $rank;
            }

        }
        $req = $sql->prepare('
            SELECT u.* FROM '.self::$_sqlTable.' u
            '.$where.'
            ORDER BY pseudo');
        
        if ($req->execute($args)) {
            while ($row = $req->fetch())
            {
                if ($to_array) {
                    $array_users[$row['id']] = $row;
                } else {
                    $array_users[$row['id']] = new User($row);
                }
            }
        } else {
            var_dump($req->errorInfo());
        }

        return $array_users;
    }
    
    /**
     * Check pseudo validity
     * @param type $value
     * @return boolean
     */
    public static function _isPseudoValid($value)
    {
        $regex = '#^([a-zA-Z0-9]{3,12})$#Usi';
        if (preg_match($regex, $value)) {
            return true;
        } else {
            return false;
        }
    }

    // TODO : mail check
    public static function _isMailValid($value)
    {
        $value = true;
        return true;
    }

    /**
     * Check pseudo availabilty
     * @param string $pseudo Pseudo to test
     * @return boolean
     */
    public static function _isPseudoAvailable($pseudo)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT pseudo FROM `'.static::$_sqlTable.'` WHERE pseudo = :pseudo');
        if ($req->execute(array(':pseudo' => $pseudo))) {
            while ($row = $req->fetch())
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Check mail availability
     * @param string $mail Mail to test
     * @return boolean
     */
    public static function _isMailAvailable($mail) {
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT mail FROM `'.static::$_sqlTable.'` WHERE mail = :mail');
        if ($req->execute(array(':mail' => $mail))) {
            while ($row = $req->fetch())
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Generate encrypted password
     * @param string $password Password to encrypt
     * @return string Encrypted password
     */
    public static function _generatePassword($password)
    {
        return Bcrypt::hashPassword($password);
    }

    /**
     * Check if given password match the encrypted one
     * @param string $password Password to test
     * @return boolean
     */
    private function _checkPassword($password)
    {
        return Bcrypt::checkPassword($password, $this->_password);
    }
}
