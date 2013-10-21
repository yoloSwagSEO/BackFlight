<?php
class Ship extends Model
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
     *
     * @var int
     */
    protected $_positionX;

    /**
     *
     * @var int
     */
    protected $_positionY;

    /**
     * The model's ship name
     * @var string (max 20 carac.)
     */
    protected $_modelName;

    /**
     * The model's ship category
     * @var string
     */
    protected $_modelCategory;

    /**
     * The model's ship type
     * @var string
     */
    protected $_modelType;

    /**
     *
     * @var int
     */
    protected $_load;

    /**
     *
     * @var int
     */
    protected $_energy;

    protected $_shield;

    /**
     *
     * @var int
     */
    protected $_fuel;

    protected $_techs;

    protected $_techsStart;

    protected $_fuelStart;

    protected $_modules = array();

    protected $_modulesEnabled = array();

    protected $_modulesEffects = array();

    protected $_objects = array();

    /**
     *
     * @var int
     */
    protected $_power;

    /**
     * Determine last time energy has been augmented
     * @var int
     */
    protected $_lastUpdate;

    /**
     * State of the ship : land, flying, etc
     * @var string
     */
    protected $_state;

    protected static $_sqlTable = TABLE_SHIPS;

    /**
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     *
     * @return int
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     *
     * @return string
     */
    public function getModelName()
    {
        return $this->_modelName;
    }

    /**
     *
     * @return string
     */
    public function getModelCategory()
    {
        return $this->_modelCategory;
    }

    /**
     *
     * @return string
     */
    public function getModelType()
    {
        return $this->_modelType;
    }

    /**
     *
     * @return int
     */
    public function getPositionId()
    {
        return $this->_positionId;
    }

    /**
     *
     * @return int
     */
    public function getPositionX()
    {
        return $this->_positionX;
    }

    /**
     *
     * @return int
     */
    public function getPositionY()
    {
        return $this->_positionY;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }

     public function getLoad()
    {
        return $this->_load;
    }

    public function getEnergy()
    {
        return $this->_energy;
    }

    public function getShield()
    {
        return $this->_shield;
    }

    public function getFuel()
    {
        return $this->_fuel;
    }

    public function getTechs()
    {
        return $this->_techs;
    }


    public function getPower()
    {
        return $this->_power;
    }

    public function getLastUpdate()
    {
        return $this->_lastUpdate;
    }

    public function getLastUpdateDiff()
    {
        return time() - $this->_lastUpdate;
    }

    public function getModules()
    {
        return $this->_modules;
    }

    public function getModulesEnabled()
    {
        return $this->_modulesEnabled;
    }

    /**
     * Determine time for search
     * @param string $type
     * @param string $positionType
     * @return type
     */
    public function getSearchTime($type, $positionType)
    {
        if ($positionType == 'asteroids') {
            $base_time = POSITION_SEARCH_TIME_ASTEROIDS;
        } else if ($positionType == 'planet') {
            $base_time = POSITION_SEARCH_TIME_PLANET;
        } else {
            $base_time = POSITION_SEARCH_TIME_SPACE;
        }


        if ($type == 'probes') {
            return 4 * $base_time / GAME_SPEED;
        }
        return $base_time / GAME_SPEED;
    }

    public function getSearchEnergy($type)
    {
        if ($type == 'probes') {
            return 6;
        }
        return 3;
    }

    public function getSearchFuel($type)
    {
        if ($type == 'probes') {
            return 0;
        }
        return 1;
    }

    public function getObjects($type = null)
    {
        if (!empty($this->_objects[$type])) {
            return $this->_objects[$type];
        }
        return array();
    }

    public function getObject($type, $id)
    {
        if (!empty($this->_objects[$type][$id])) {
            return $this->_objects[$type][$id];
        }
        return array();
    }


    /**
     * User ID
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * The ship's type
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * The model of the ship
     * @param int $model Model ID
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }


    /**
     * Set the position
     * @param Position $Position
     */
    public function setPosition(Position $Position)
    {
        $this->_positionId = $Position->getId();
    }

    /**
     * Set ship's state
     * @param string $state flying / land / base, etc
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    public function setLoad($load)
    {
        if ($load > $this->_loadMax*SHIP_LOAD_TOLERANCE) {
            $this->_load = $this->_loadMax*SHIP_LOAD_TOLERANCE;
        }
        $this->_load = $load;
    }

    /**
     * Set energy level
     * @param int $energy
     * @return type
     */
    public function setEnergy($energy)
    {
        if ($this->_energyMax) {
            if ($energy > $this->_energyMax) {
                return $this->_energy = $this->_energyMax;
            }
        }
        return $this->_energy = $energy;
    }

    public function setShield($shield)
    {
        if ($this->_shieldMax) {
            if ($shield > $this->_shieldMax) {
                return $this->_shield = $this->_shieldMax;
            }
        }
        return $this->_shield = $shield;
    }

    /**
     * Set fuel level 
     * @param int $fuel fuel level
     * @return boolean
     */
    public function setFuel($fuel)
    {
        $dif = $fuel - $this->_fuel;
        $max_load = $this->_getAvailableLoadFor('fuel');

        if ($dif > $max_load) {
            $fuel = $this->_fuel + $max_load;
        }

        if ($fuel > $this->_fuelMax) {
            return $this->_fuel = $this->_fuelMax;
        }
        return $this->_fuel = $fuel;
    }

    public function setTechs($techs)
    {
        $dif = $techs - $this->_techs;
        $max_load = $this->_getAvailableLoadFor('techs');

        if ($dif > $max_load) {
            $techs = $this->_techs + $max_load;
        }

        $this->_techs = $techs;
    }

    /**
     * Set ship's power
     * @param int $power power level
     * @return boolean r
     */
    public function setPower($power)
    {
        if ($power > $this->_powerMax && $this->_powerMax) {
            return $this->_power = $this->_powerMax;
        }
        return $this->_power = $power;
    }

    public function setLastUpdate($lastUpdate)
    {
        $this->_lastUpdate = $lastUpdate;
    }

    /**
     * Check if load > loadMax
     * @return boolean
     */
    public function isOverloaded()
    {
        if ($this->_load > $this->_loadMax) {
            return true;
        }
        return false;
    }

    /**
     * Update ship energy
     */
    public function updateEnergy()
    {
        $time = time();
        $diff = $time - $this->_lastUpdate;
        if ($this->_energy > $this->_energyMax) {
            $this->_energy = $this->_energyMax;
        }
        if ($diff > 0) {
            $gain = $this->_energyGain / 3600 * $diff * GAME_SPEED;
            $this->addEnergy($gain);
        }
    }
    
    /**
     * Update ship energy
     */
    public function updateShield()
    {
        $time = time();
        $diff = $time - $this->_lastUpdate;
        if ($this->_shield > $this->_shieldMax) {
            $this->_shield = $this->_shieldMax;
        }
        if ($diff > 0) {
            $gain = $this->_shieldGain / 3600 * $diff * GAME_SPEED;
            $this->addShield($gain);
        }
    }
    
    /**
     * Update ship power
     */
    public function updatePower()
    {
        $time = time();
        $diff = $time - $this->_lastUpdate;
        if ($diff > 0) {
            $gain = ($this->_energyGain / 10) / 3600  * $diff * GAME_SPEED;
            $this->addPower($gain);
        }
    }

    public function getFreeLoad()
    {
        return $this->_loadMax - $this->_load;
    }


    /**
     * Remove energy
     * @param int $energy
     * @return int
     */
    public function removeEnergy($energy)
    {
        return $this->setEnergy($this->_energy - $energy);
    }

    /**
     * 
     * @param type $shield
     * @return type Energy to remove because shield is empty
     */
    public function removeShield($shield)
    {
        $energy = $shield;
        if ($shield > $this->_shield) {
            $shield = $this->_shield;
        }
        $this->setShield($this->_shield - $shield);
        if ($energy - $shield > 0) {
            return $energy - $shield;
        }
    }

    public function emptyShield()
    {
        $this->_shield = 0;
    }

    public function addShield($shield)
    {
        return $this->setShield($this->_shield + $shield);
    }

    /**
     *
     * @param int $energy
     * @return type
     */
    public function addEnergy($energy)
    {
        return $this->setEnergy($this->_energy + $energy);        
    }

    /**
     * Get travel time
     * @param int $distance
     * @param string $type
     * @return type
     */
    public function calculateTravelTime($distance, $type=null)
    {
        return ceil($distance / $this->getSpeed($type));
    }

    public function calculateTravelEnergy($distance, $type=null)
    {
        return ceil($distance / POSITION_LENGHT * $this->getSpeed($type) * SHIP_ENERGY_USE);
    }

    public function calculateTravelFuel($distance, $type=null)
    {
        if ($type == 'jump') {
            return 1;
        }
        return ceil($distance / POSITION_LENGHT * $this->getSpeed($type) * SHIP_FUEL_USE);
    }

    protected function _getAvailableLoadFor($type)
    {
        $free_load = $this->getFreeLoad();

        if ($type == 'fuel') {
            $weight = FUEL_WEIGHT;
        } else {
            $weight = TECHS_WEIGHT;
        }

        return $free_load / $weight;
    }


    /**
     *
     * @param int $fuel
     * @return type
     */
    public function removeFuel($fuel)
    {
        return $this->setFuel($this->_fuel - $fuel);
    }

    /**
     *
     * @param int $fuel
     * @return int Fuel added
     */
    public function addFuel($fuel)
    {
        $previous_fuel = $this->_fuel;
        $this->setFuel($this->_fuel + $fuel);
        return $this->_fuel - $previous_fuel;
    }

    public function addTechs($techs)
    {
        $previous_techs = $this->_techs;
        $this->setTechs($this->_techs + $techs);
        return $this->_techs - $previous_techs;
    }

    public function removeTechs($techs)
    {
        return $this->setTechs($this->_techs - $techs);
    }

    /**
     * Calculate actual ship load
     * @return int
     */
    public function calculateLoad()
    {
        $this->_load = $this->_fuel * FUEL_WEIGHT + $this->_techs * TECHS_WEIGHT;

        foreach ($this->_modulesEnabled as $typeId => $quantity)
        {
            $weight = $this->_modulesEffects[$typeId]['weight'];
            $this->_load += $weight*$quantity;
        }
        
        foreach ($this->_modules as $typeId => $quantity)
        {
            $weight = $this->_modulesEffects[$typeId]['weight'];
            $this->_load += $weight*$quantity;
        }
        
        return $this->_load;
    }

    public function addPower($power)
    {
        $previous_power = $this->_power;
        $this->setPower($this->_power + $power);
        return $this->_power - $previous_power;
    }

    /**
     * Remove power
     * @param type $power
     * @param boolean $shield false to disable shield
     * @return type
     */
    public function removePower($power, $shield = true)
    {
        // If shield is enabled, we use it to absorb energy loss
        if ($this->_shield && $shield) {
            $power = $this->removeShield($power);
        }
        return $this->setPower($this->_power - $power);
        
    }


    public static function get($id, $args=null)
    {
        $array = array();

        if (is_numeric($id)) {
            $array = self::getAll($id, true);
        } else {
            if (!empty($args[1])) {
                // $param[0] : type / $param[1] player ID:
                $array = self::getAll('', true, $args[1], $args[0]);
            }
        }

        if (!empty($array)) {
            return array_shift($array);
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
            $this->_modelName = $param['modelName'];
            $this->_modelCategory = $param['modelCategory'];
            $this->_modelType = $param['modelType'];

            $this->_load = $param['load'];
            $this->_loadMax = $param['loadMax'];

            $this->_energy = $param['energy'];
            $this->_energyMax = $param['energyMax'];
            $this->_energyGain = $param['energyGain'];

            $this->_shield = $param['shield'];
            $this->_shieldGain = $param['shieldGain'];
            $this->_shieldMax = $param['shieldMax'];

            $this->_fuelMax = $param['fuelMax'];

            if (!empty($param['fuel'])) {
                $this->_fuel = $param['fuel'];
                $this->_fuelStart = $param['fuel'];

                if ($this->_fuel > $this->_fuelMax) {
                    $this->_fuel = $this->_fuelMax;
                }
            }

            if (!empty($param['techs'])) {
                $this->_techs = $param['techs'];
                $this->_techsStart = $param['techs'];
            }

            $this->_power = $param['power'];
            $this->_powerMax = $param['powerMax'];
            
            $this->_speed = $param['speed'];
            
            if (!empty($param['x'])) {
                $this->_positionX = $param['x'];
                $this->_positionY = $param['y'];
            }

            $this->_modulesMax = $param['modulesMax'];

            if (!empty($param['modules'])) {
                $this->_modules = $param['modules'];
            }

            if (!empty($param['modulesEffects'])) {
                $this->_modulesEffects = $param['modulesEffects'];
            }

            if (!empty($param['modulesEnabled'])) {
                $this->_modulesEnabled = $param['modulesEnabled'];
                $this->_calculateBonuses();
            }

            if (!empty($param['weapons'])) {
                $this->_objects['weapons'] = $param['weapons'];
            }



            $this->_lastUpdate = $param['lastUpdate'];
            $this->_state = $param['state'];

            $this->_sql = true;
        }
    }
    
    protected function _create()
    {
        if (!$this->_lastUpdate) {
            $this->_lastUpdate = time();
        }


        $sql = FlyPDo::get();
        $req = $sql->prepare('INSERT INTO `'.self::$_sqlTable.'` VALUES("", :userId, :type, :model, :positionId, :load, :energy, :shield, :power, :lastUpdate, :state)');
        if ($req->execute(array(
            ':userId' => $this->_userId,
            ':type' => $this->_type,
            ':model' => $this->_model,
            ':positionId' => $this->_positionId,
            ':load' => $this->_load,
            ':energy' => $this->_energy,
            ':shield' => $this->_shield,
            ':lastUpdate' => $this->_lastUpdate,
            ':power' => $this->_power,
            ':state' => $this->_state
        ))) {
            if ($this->_fuel != $this->_fuelStart) {
                $RessourceFuel = new Ressource('fuel', 'ship', $this->_id);
                $RessourceFuel->setQuantity($this->_fuel);
                $RessourceFuel->save();
            }

            if ($this->_techs != $this->_techsStart) {
                $RessourceFuel = new Ressource('techs', 'ship', $this->_id);
                $RessourceFuel->setQuantity($this->_techs);
                $RessourceFuel->save();
            }
            return $sql->lastInsertId();
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to create ship', E_USER_ERROR);
        }
    }
    
    protected function _update()
    {
        $this->calculateLoad();


        $sql = FlyPDo::get();
        $req = $sql->prepare('UPDATE `'.self::$_sqlTable.'` 
            SET `userId` = :userId, `type` = :type, `model` = :model, `positionId` = :positionId, `load` = :load, `energy` = :energy, `shield` = :shield, `power` = :power, `lastUpdate` = :lastUpdate, `state` = :state WHERE `'.self::$_sqlTable.'` .id = :id');
        if ($req->execute(array(
            ':id' => $this->_id,
            ':userId' => $this->_userId,
            ':type' => $this->_type,
            ':model' => $this->_model,
            ':positionId' => $this->_positionId,
            ':load' => $this->_load,
            ':energy' => $this->_energy,
            ':shield' => $this->_shield,
            ':power' => $this->_power,
            ':lastUpdate' => $this->_lastUpdate,
            ':state' => $this->_state
        ))) {
            if ($this->_fuel != $this->_fuelStart) {
                $RessourceFuel = new Ressource('fuel', 'ship', $this->_id);
                $RessourceFuel->setQuantity($this->_fuel);
                $RessourceFuel->save();
            }

            if ($this->_techs != $this->_techsStart) {
                $RessourceFuel = new Ressource('techs', 'ship', $this->_id);
                $RessourceFuel->setQuantity($this->_techs);
                $RessourceFuel->save();                
            }

            return $this->_id;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Enregistrement impossible !', E_USER_ERROR);
        }
    }


    /**
     *
     * @param int $id
     * @param boolean $toArray
     * @param int $playerId
     * @param string $type
     * @param int $position
     */
    public static function getAll($id, $toArray=false, $userId=null, $type=null, $position=null)
    {
        $where = '';
        $args = array();
        $array = array();
        
        if ($id) {
            $where = 'WHERE `'.self::$_sqlTable.'`.id = :id';
            $args[':id'] = $id;
        }
        
        if ($userId) {
            $where = 'WHERE `'.self::$_sqlTable.'`.`userId` = :userId';
            $args[':userId'] = $userId;
        }

        if ($type) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `'.self::$_sqlTable.'`.`type` = :type';
            $args[':type'] = $type;
        }

        if ($position) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `'.self::$_sqlTable.'`.`positionId` = :position';
            $args[':position'] = $position;
        }   
        
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT `'.self::$_sqlTable.'`.*, pos.x, pos.y, res.quantity ressourceQuantity, res.type ressourceType,
                mod.name modelName, mod.type modelType, mod.category modelCategory, mod.loadMax, mod.energyMax, mod.energyGain, mod.fuelMax, 
                mod.powerMax, mod.speed, mod.modulesMax, mod.shieldMax, mod.shieldGain, smodu.typeId, smodu.typeEnabled, smodu.id shipObjectId,
                smodu.type shipObjectType,
                
                modu.operation moduleOperation,modu.weight moduleWeight, modu.power modulePower, modu.energy moduleEnergy, modu.load moduleLoad,
                modu.fuel moduleFuel, modu.techs moduleTechs, modu.speed moduleSpeed, modu.shield moduleShield, modu.search moduleSearch,
                modu.attack moduleAttack, modu.weapons moduleWeapon, modu.defense moduleDefense, modu.energyGain moduleEnergyGain,
                modu.shieldGain moduleShieldGain, modu.module moduleModule,
                
                weapon.objectName, weapon.objectDescription, weapon.objectType, weapon.objectAttackType, weapon.objectAttackPower,
                weapon.objectRange, weapon.objectSpeed, weapon.objectWeight, weapon.objectCostFuel, weapon.objectCostTechs, weapon.objectCostEnergy,
                weapon.objectLaunchFuel, weapon.objectLaunchEnergy
            FROM `'.self::$_sqlTable.'`
            LEFT JOIN `'.TABLE_POSITIONS.'` pos
                ON `'.self::$_sqlTable.'`.positionId =  pos.id
                    
            LEFT JOIN `'.TABLE_MODELS.'` `mod`
                ON `'.self::$_sqlTable.'`.model = `mod`.id

            LEFT JOIN `'.TABLE_RESSOURCES.'` res
                ON `'.self::$_sqlTable.'`.id = res.intoId AND `into` = "ship"

            LEFT JOIN `'.TABLE_SHIPS_OBJECTS.'` smodu
                ON smodu.shipId = `'.self::$_sqlTable.'`.id
                    
            LEFT JOIN `'.TABLE_SHIPS_OBJECTS.'` sweapon
                ON sweapon.shipId = `'.self::$_sqlTable.'`.id AND sweapon.type = "weapon"

            LEFT JOIN `'.TABLE_OBJECTS.'` weapon
                ON sweapon.typeId = weapon.id

            LEFT JOIN `'.TABLE_MODULES.'` modu
                ON modu.id = smodu.typeId
        '.$where);
        if ($req->execute($args)) {
            $current = 0;
            $loaded = false;
            $param = array();
            $class = get_called_class();
            while ($row = $req->fetch())
            {
                
                if ($current != $row['id'] && $current != '') {
                    if ($toArray) {
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

                
                if (!empty($row['ressourceType'])) {
                    $param[$row['ressourceType']] = $row['ressourceQuantity'];
                }

                if (!empty($row['typeId'])) {
                    if ($row['shipObjectType'] == 'module') {
                        if (empty($param['shipModule'][$row['shipObjectId']])) {
                            if (empty($param['modules'][$row['typeId']])) {
                                $param['modules'][$row['typeId']] = 0;
                            }
                            if (!empty($row['typeEnabled'])) {
                                if (empty($param['modulesEnabled'][$row['typeId']])) {
                                    $param['modulesEnabled'][$row['typeId']] = 0;
                                }
                                $param['modulesEnabled'][$row['typeId']]++;
                            } else {
                                $param['modules'][$row['typeId']]++;
                            }
                            $param['shipModule'][$row['shipObjectId']] = true;

                            // Loading module effects
                            if (empty($param['modulesEffects'])) {
                                $param['modulesEffects'] = array();
                            }
                            $param['modulesEffects'][$row['typeId']]['weight'] = $row['moduleWeight'];
                            $param['modulesEffects'][$row['typeId']]['operation'] = $row['moduleOperation'];
                            $param['modulesEffects'][$row['typeId']]['power'] = $row['modulePower'];
                            $param['modulesEffects'][$row['typeId']]['energy'] = $row['moduleEnergy'];
                            $param['modulesEffects'][$row['typeId']]['load'] = $row['moduleLoad'];
                            $param['modulesEffects'][$row['typeId']]['fuel'] = $row['moduleFuel'];
                            $param['modulesEffects'][$row['typeId']]['techs'] = $row['moduleTechs'];
                            $param['modulesEffects'][$row['typeId']]['speed'] = $row['moduleSpeed'];
                            $param['modulesEffects'][$row['typeId']]['shield'] = $row['moduleShield'];
                            $param['modulesEffects'][$row['typeId']]['search'] = $row['moduleSearch'];
                            $param['modulesEffects'][$row['typeId']]['attack'] = $row['moduleAttack'];
                            $param['modulesEffects'][$row['typeId']]['weapons'] = $row['moduleWeapon'];
                            $param['modulesEffects'][$row['typeId']]['defense'] = $row['moduleDefense'];
                            $param['modulesEffects'][$row['typeId']]['energyGain'] = $row['moduleEnergyGain'];
                            $param['modulesEffects'][$row['typeId']]['shieldGain'] = $row['moduleShieldGain'];
                            $param['modulesEffects'][$row['typeId']]['module'] = $row['moduleModule'];
                        }
                    } else if ($row['shipObjectType'] == 'object') {
                        if (empty($param['shipWeapon'][$row['shipObjectId']])) {
                            if (empty($param['weapons'][$row['typeId']])) {
                                $param['weapons'][$row['typeId']] = 0;
                            }
                            $param['weapons'][$row['typeId']]++;
                            $param['shipWeapon'][$row['shipObjectId']] = true;
                        }
                    }
                }

            }
            if (!empty($param)) {
                if ($toArray) {
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

    public function hasTouchAsteroids($type)
    {
        if ($type == 'flight') {
            $proba = FLIGHT_PROBA_ASTEROIDS_HIT_FLIGHT;
        } else if ($type == 'search') {
            $proba = FLIGHT_PROBA_ASTEROIDS_HIT_SEARCH;
        }

        $rand = rand(0,100);
        if ($rand <= $proba * 100) {
            return true;
        }
        return false;
    }

    public function getAsteroidsDamages($type)
    {
        return 5;
    }

    /**
     * Check if ship is busy
     * @return boolean
     */
    public function isBusy()
    {
        if ($this->_state == 'arrived' || $this->_state == '' || $this->_state == 'space') {
            return false;
        }
        return true;
    }

    public function getModulesEnabledNumber()
    {
        $number = 0;
        foreach ($this->_modulesEnabled as $quantity)
        {
            $number += $quantity;
        }
        return $number;
    }

    public function getModulesNumber()
    {
        $number = 0;
        foreach ($this->_modules as $quantity)
        {
            $number += $quantity;
        }
        return $number;
    }

    /**
     * Add a module to the ship
     * @param int $typeId
     * @return boolean
     */
    public function addObject($type, $typeId)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.TABLE_SHIPS_OBJECTS.'` VALUES("", :shipId, :type, :typeId, :typeOrder, "")');
        if ($req->execute(array(
            ':shipId' => $this->_id,
            ':type' => $type,
            ':typeId' => $typeId,
            ':typeOrder' => 1
        ))) {
            if (empty($this->_modules[$typeId])) {
                $this->_modules[$typeId] = 0;
            }
            $this->_modules[$typeId]++;
            return true;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to add module to ship', E_USER_ERROR);
        }
    }

    public function hasObjectAvailable($type, $typeId)
    {
        if ($type == 'module') {
            if (!empty($this->_modules[$typeId])) {
                return true;
            }
        } else if ($type == 'weapon') {
            if (!empty($this->_objects['weapons'][$typeId])) {
                return true;
            }
        }
    }

    public function hasObjectEnabled($type, $typeId)
    {
        if ($type == 'module') {
            if (!empty($this->_modulesEnabled[$typeId])) {
                return true;
            }
        }
    }

    public function enableObject($type, $typeId)
    {
        if ($type == 'module') {
            if ($this->hasObjectAvailable($type, $typeId)) {
                $ShipObject = array_shift(ShipObject::getAll('', '', $this->_id, 'module', $typeId, '0'));
                $ShipObject->setTypeEnabled(1);
                $ShipObject->save();
                $this->_modules[$typeId]--;
                if (empty($this->_modulesEnabled[$typeId])) {
                    $this->_modulesEnabled[$typeId] = 0;
                }
                $this->_modulesEnabled[$typeId]++;
            }
        }
    }
    
    public function disableObject($type, $typeId)
    {
        if ($type == 'module') {
            if ($this->hasobjectEnabled($type, $typeId)) {
                $ShipModule = array_shift(ShipObject::getAll('', '', $this->_id, 'module', $typeId, 1));
                $ShipModule->setTypeEnabled('0');
                $ShipModule->save();
                $this->_modulesEnabled[$typeId]--;
                if (empty($this->_modules[$typeId])) {
                    $this->_modules[$typeId] = 0;
                }
                $this->_modules[$typeId]++;
            }
        }
    }

    protected function _calculateBonuses()
    {
        foreach ($this->_modulesEnabled as $typeId => $quantity)
        {
            $moduleEffects = $this->_modulesEffects[$typeId];
            $operation = $moduleEffects['operation'];
            for ($i = 0; $i < $quantity; $i++)
            {
                foreach ($moduleEffects as $effect => $value)
                {
                    if (!empty($value)) {
                        if ($effect != 'operation' && $effect != 'weight') {
                            if (!empty($value)) {
                                $propertyName = '_'.$effect;
                                if ($effect == 'module') {
                                    $propertyName .= 's';
                                }
                                if ($effect != 'speed' && $effect != 'energyGain' && $effect != 'shieldGain') {
                                    $propertyName .= 'Max';
                                }
                                if ($operation == 'multiply') {
                                    $this->$propertyName *= $value;
                                } else {
                                    $this->$propertyName += $value;
                                }
                            }
                        } else if ($effect == 'weight') {
                            $this->_load += $value;
                        }
                    }
                }
            }
        }
    }
}