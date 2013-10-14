<?php
class Model extends Fly
{
    protected $_id;
    protected $_name;
    protected $_user;
    protected $_category;
    protected $_type;
    protected $_loadMax;
    protected $_energyMax;
    protected $_energyGain;
    protected $_fuelMax;
    protected $_powerMax;
    protected $_speed;
    protected $_modulesMax;
    protected $_shieldMax;
    protected $_shieldGain;


    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_MODELS;


    public function getName()
    {
        return $this->_name;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function getCategory()
    {
        return $this->_category;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getLoadMax()
    {
        return $this->_loadMax;
    }

    public function getEnergyMax()
    {
        return $this->_energyMax;
    }

    public function getEnergyGain()
    {
        return $this->_energyGain;
    }

    public function getFuelMax()
    {
        return $this->_fuelMax;
    }

    public function getPowerMax()
    {
        return $this->_powerMax;
    }

    public function getSpeed($type = null)
    {
        if ($type === 'jump') {
            return $this->_speed * SHIP_JUMP_SPEED_FACTOR;
        }
        return $this->_speed;
    }
    
    public function getModulesMax()
    {
        return $this->_modulesMax;
    }

    public function getShieldMax()
    {
        return $this->_shieldMax;
    }

    public function getShieldGain()
    {
        return $this->_shieldGain;
    }



    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function setCategory($category)
    {
        $this->_category = $category;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setLoadMax($loadMax)
    {
        $this->_loadMax = $loadMax;
    }

    public function setEnergyMax($energyMax)
    {
        $this->_energyMax = $energyMax;
    }

    public function setEnergyGain($energyGain)
    {
        $this->_energyGain = $energyGain;
    }

    public function setFuelMax($fuelMax)
    {
        $this->_fuelMax = $fuelMax;
    }

    public function setPowerMax($powerMax)
    {
        $this->_powerMax = $powerMax;
    }

    public function setSpeed($speed)
    {
        $this->_speed = $speed;
    }
    
    public function setModulesMax($modulesMax)
    {
        $this->_modulesMax = $modulesMax;
    }

    public function setShieldMax($shieldMax)
    {
        $this->_shieldMax = $shieldMax;
    }

    public function setShieldGain($shieldGain)
    {
        $this->_shieldGain = $shieldGain;
    }



    /*
     * Charge les valeurs de l'objet
     * @param array $param Le tableau avec les valeurs nécessaire à l'instanciation de l'objet
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_name = $param['name'];
            $this->_user = $param['user'];
            $this->_category = $param['category'];
            $this->_type = $param['type'];
            $this->_modulesMax = $param['modulesMax'];
            $this->_loadMax = $param['loadMax'];
            $this->_energyMax = $param['energyMax'];
            $this->_energyMax = $param['energyGain'];
            $this->_fuelMax = $param['fuelMax'];
            $this->_powerMax = $param['powerMax'];
            $this->_speed = $param['speed'];
            $this->_shieldMax = $param['shieldMax'];
            $this->_shieldGain = $param['shieldGain'];
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :name, :user, :category, :type, :modulesMax, :loadMax, :energyMax, :energyGain, :shieldMax, :shieldGain, :fuelMax, :powerMax, :speed)');
        $args = array(
            ':id' => $this->_id,
            ':name' => $this->_name,
            ':user' => $this->_user,
            ':category' => $this->_category,
            ':type' => $this->_type,
            ':modulesMax' => $this->_modulesMax,
            ':loadMax' => $this->_loadMax,
            ':energyMax' => $this->_energyMax,
            ':energyGain' => $this->_energyGain,
            ':shieldMax' => $this->_shieldMax,
            ':shieldGain' => $this->_shieldGain,
            ':fuelMax' => $this->_fuelMax,
            ':powerMax' => $this->_powerMax,
            ':speed' => $this->_speed
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `name` = :name, `user` = :user, `category` = :category, `type` = :type, `modulesMax` = :modulesMax, `loadMax` = :loadMax, `energyMax` = :energyMax, `energyGain` = :energyGain, `shieldMax` = :shieldMax, `shieldGain` = :shieldGain,`fuelMax` = :fuelMax, `powerMax` = :powerMax, `speed` = :speed WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':name' => $this->_name,
            ':user' => $this->_user,
            ':category' => $this->_category,
            ':type' => $this->_type,
            ':modulesMax' => $this->_modulesMax,
            ':loadMax' => $this->_loadMax,
            ':energyMax' => $this->_energyMax,
            ':energyGain' => $this->_energyGain,
            ':energyGain' => $this->_energyGain,
            ':shieldMax' => $this->_shieldMax,
            ':fuelMax' => $this->_fuelMax,
            ':powerMax' => $this->_powerMax,
            ':speed' => $this->_speed
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