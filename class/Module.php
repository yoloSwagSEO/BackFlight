<?php
class Module extends Fly
{
    protected $_id;
    protected $_name;
    protected $_tag;
    protected $_intro;
    protected $_description;
    protected $_weight;
    protected $_time;
    protected $_power;
    protected $_energy;
    protected $_energyGain;
    protected $_shieldGain;
    protected $_load;
    protected $_fuel;
    protected $_techs;
    protected $_speed;
    protected $_shield;
    protected $_search;
    protected $_attack;
    protected $_weapons;
    protected $_defense;
    protected $_costEnergy;
    protected $_costTechs;
    protected $_costFuel;
    protected $_module;

    protected $_operation;
    protected $_type;

    protected $_buildEnd;
    protected $_buildQuantity;

    /**
     * Default SQL table
     * @var string
     */
    protected static $_sqlTable = TABLE_MODULES;


    public function getName()
    {
        return $this->_name;
    }

    public function getIntro()
    {
        return $this->_intro;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getWeight()
    {
        return $this->_weight;
    }

    public function getPower()
    {
        return $this->_power;
    }

    public function getEnergy()
    {
        return $this->_energy;
    }

    public function getLoad()
    {
        return $this->_load;
    }

    public function getFuel()
    {
        return $this->_fuel;
    }

    public function getTechs()
    {
        return $this->_techs;
    }

    public function getSpeed()
    {
        return $this->_speed;
    }

    public function getShield()
    {
        return $this->_shield;
    }

    public function getSearch()
    {
        return $this->_search;
    }

    public function getAttack()
    {
        return $this->_attack;
    }

    public function getWeapons()
    {
        return $this->_weapons;
    }

    public function getDefense()
    {
        return $this->_defense;
    }

    public function getCostEnergy()
    {
        return $this->_costEnergy;
    }

    public function getCostTechs()
    {
        return $this->_costTechs;
    }

    public function getCostFuel()
    {
        return $this->_costFuel;
    }

    public function getOperation()
    {
        return $this->operation;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getTime()
    {
        return $this->_time / GAME_SPEED;
    }

    public function getBuildEnd()
    {
        return $this->_buildEnd;
    }

    public function getBuildQuantity()
    {
        return $this->_buildQuantity;
    }

    public function getShieldGain()
    {
        return $this->_shieldGain;
    }

    public function getEnergyGain()
    {
        return $this->_energyGain;
    }

    public function getModule()
    {
        return $this->_module;
    }



    public function setIntro($intro)
    {
        $this->_intro = $intro;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function setWeight($weight)
    {
        $this->_weight = $weight;
    }

    public function setPower($power)
    {
        $this->_power = $power;
    }

    public function setEnergy($energy)
    {
        $this->_energy = $energy;
    }

    public function setEnergyGain($energyGain)
    {
        $this->_energyGain = $energyGain;
    }

    public function setShieldGain($shieldGain)
    {
        $this->_shieldGain = $shieldGain;
    }

    public function setLoad($load)
    {
        $this->_load = $load;
    }

    public function setFuel($fuel)
    {
        $this->_fuel = $fuel;
    }

    public function setTechs($techs)
    {
        $this->_techs = $techs;
    }

    public function setSpeed($speed)
    {
        $this->_speed = $speed;
    }

    public function setShield($shield)
    {
        $this->_shield = $shield;
    }

    public function setSearch($search)
    {
        $this->_search = $search;
    }

    public function setAttack($attack)
    {
        $this->_attack = $attack;
    }

    public function setWeapons($weapons)
    {
        $this->_weapons = $weapons;
    }

    public function setDefense($defense)
    {
        $this->_defense = $defense;
    }

    public function setCostEnergy($costEnergy)
    {
        $this->_costEnergy = $costEnergy;
    }

    public function setCostTechs($costTechs)
    {
        $this->_costTechs = $costTechs;
    }

    public function setCostFuel($costFuel)
    {
        $this->_costFuel = $costFuel;
    }

    public function setOperation($operation)
    {
        $this->_operation = $operation;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setTime($time)
    {
        $this->_time = $time;
    }

    public function isBuilding()
    {
        if ($this->_buildEnd > time()) {
            return true;
        }
    }

    public function setModule($module)
    {
        $this->_module = $module;
    }


    /*
     * Load object values
     * @param array $param Instanciation values
     */
    protected function _load($param)
    {
        if($param) {
            $this->_id = $param['id'];
            $this->_name = $param['name'];
            $this->_intro = $param['intro'];
            $this->_description = $param['description'];
            $this->_weight = $param['weight'];
            $this->_power = $param['power'];
            $this->_energy = $param['energy'];
            $this->_energyGain = $param['energyGain'];
            $this->_load = $param['load'];
            $this->_fuel = $param['fuel'];
            $this->_techs = $param['techs'];
            $this->_speed = $param['speed'];
            $this->_shield = $param['shield'];
            $this->_shieldGain = $param['shieldGain'];
            $this->_search = $param['search'];
            $this->_attack = $param['attack'];
            $this->_weapons = $param['weapons'];
            $this->_defense = $param['defense'];
            $this->_costEnergy = $param['costEnergy'];
            $this->_costTechs = $param['costTechs'];
            $this->_costFuel = $param['costFuel'];
            $this->_type = $param['type'];
            $this->_operation = $param['operation'];
            $this->_time = $param['time'];
            $this->_module = $param['module'];

            if (!empty($param['buildEnd'])) {
                $this->_buildEnd = $param['buildEnd'];
                $this->_buildQuantity = $param['buildQuantity'];
            }
            $this->_sql = true;
        }
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.static::$_sqlTable.'` VALUES (:id, :name, :intro, :description, :type, :operation, :time, :weight, :power, :energy, :energyGain, :load, :fuel, :techs, :speed, :shield, :shieldGain, :search, :attack, :weapons, :defense, :module, :costEnergy, :costTechs, :costFuel)');
        $args = array(
            ':id' => $this->_id,
            ':name' => $this->_name,
            ':intro' => $this->_intro,
            ':description' => $this->_description,
            ':type' => $this->_type,
            ':operation' => $this->_operation,
            ':time' => $this->_time,
            ':weight' => $this->_weight,
            ':power' => $this->_power,
            ':energy' => $this->_energy,
            ':energyGain' => $this->_energyGain,
            ':load' => $this->_load,
            ':fuel' => $this->_fuel,
            ':techs' => $this->_techs,
            ':speed' => $this->_speed,
            ':shield' => $this->_shield,
            ':shieldGain' => $this->_shieldGain,
            ':search' => $this->_search,
            ':attack' => $this->_attack,
            ':weapons' => $this->_weapons,
            ':defense' => $this->_defense,
            ':module' => $this->_module,
            ':costEnergy' => $this->_costEnergy,
            ':costTechs' => $this->_costTechs,
            ':costFuel' => $this->_costFuel
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
        $req = $sql->prepare('UPDATE `'.static::$_sqlTable.'` SET `name` = :name, `intro` = :intro, `description` = :description, `type` = :type, `operation` = :operation, `time` = :time, `weight` = :weight, `power` = :power, `energy` = :energy, `energyGain` = :energyGain, `load` = :load, `fuel` = :fuel, `techs` = :techs, `speed` = :speed, `shield` = :shield, `shieldGain` = :shieldGain, `search` = :search, `attack` = :attack, `weapons` = :weapons, `defense` = :defense, `module` = :module, `costEnergy` = :costEnergy, `costTechs` = :costTechs, `costFuel` = :costFuel WHERE id = :id');
        $args = array(
            ':id' => $this->_id,
            ':name' => $this->_name,
            ':intro' => $this->_intro,
            ':description' => $this->_description,
            ':type' => $this->_type,
            ':operation' => $this->_operation,
            ':time' => $this->_time,
            ':weight' => $this->_weight,
            ':power' => $this->_power,
            ':energy' => $this->_energy,
            ':energyGain' => $this->_energyGain,
            ':load' => $this->_load,
            ':fuel' => $this->_fuel,
            ':techs' => $this->_techs,
            ':speed' => $this->_speed,
            ':shield' => $this->_shield,
            ':shieldGain' => $this->_shieldGain,
            ':search' => $this->_search,
            ':attack' => $this->_attack,
            ':weapons' => $this->_weapons,
            ':defense' => $this->_defense,
            ':module' => $this->_module,
            ':costEnergy' => $this->_costEnergy,
            ':costTechs' => $this->_costTechs,
            ':costFuel' => $this->_costFuel
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

        if ($id) {
            if (empty($where)) {
                $where = ' WHERE ';
            }
            $where .= '`'.static::$_sqlTable.'`.id = :id';
            $args[':id'] = $id;
        }

        $add = '';
        if ($userId) {
            $args[':userIdM'] = $userId;
            $add = 'AND builds.userId = :userIdM';
        }

        $array = array();
        $sql = FlyPDO::get();
        $req = $sql->prepare('
                    SELECT `'.static::$_sqlTable.'`.*, builds.end buildEnd
                        FROM `'.static::$_sqlTable.'`
                LEFT JOIN `'.TABLE_BUILDS.'` builds
                    ON builds.type = "module" AND builds.typeId = `'.static::$_sqlTable.'`.id AND (builds.state IS NULL OR builds.state NOT LIKE "%end%") '.$add.'
                '.$where.'
                    ORDER BY id');

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

                

                if (empty($param['buildEndSeen'][$row['buildEnd']])) {
                    if (!empty($row['buildEnd'])) {
                        if ($row['buildEnd'] > $param['buildEnd']) {
                            $param['buildEnd'] = $row['buildEnd'];
                        }
                    }
                    if (empty($param['buildQuantity'])) {
                        $param['buildQuantity'] = 0;
                    }
                    $param['buildQuantity']++;
                    $param['buildEndSeen'][$row['buildEnd']] = true;
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

    public function getIcon()
    {
        if ($this->_type == 'load') {
            return '&#xe0a1;';
        } else if ($this->_type == 'power') {
            return '&#xe0d1;';
        } else if ($this->_type == 'energy') {
            return '&#xe0b0;';
        } else if ($this->_type == 'shield') {
            return '&#xe0af;';
        } else if ($this->_type == 'speed') {
            return '&#xe09f;';
        } else if ($this->_type == 'module') {
            return '&#xe102;';
        } else {
            return '&#xe0f6;';
        }
    }
}