<?php
class Position extends Fly
{
    /**
     * X position
     * @var type int
     */
    protected $_x;
    
    /**
     * Y position
     * @var type int
     */
    protected $_y;
    
    /**
     * Position's zone
     * @var type string
     */
    protected $_zone;
    
    /**
     * Planet, space or asteroids
     * @var type string
     */
    protected $_category;
    
    /**
     * Depends on category
     * @var type string
     */
    protected $_type;
    
    /**
     * Define probabilities to find a planet, asteroids or space
     * @var type array
     */
    static private $_categoriesProbabilities;
    
    /**
     * Define probabilities for each categories
     * @var type array
     */
    static private $_typesProbabilities;

    static private $_types;

    static private $_categories;

    protected static $_sqlTable = TABLE_POSITIONS;

    protected $_searchResults;

    protected $_searchProbabilities;


    private function _chooseCategory()
    {
        $nb = mt_rand(0, 100);
        $total = 0;

        foreach (self::$_categoriesProbabilities as $category => $probability)
        {
            if ($nb >= $total && $nb < $total + $probability)
            {
                return $category;
            }
            $total += $probability;
        }
    }
    
    private function _chooseType()
    {
        return 1;
    }
    
    public function getCategory($full = false)
    {
        if (empty($this->_category)) {
            $this->_category = $this->_chooseCategory();
        }
        if ($full) {
            return self::$_categories[$this->_category];
        }
        return $this->_category;
    }
    
    public function getType()
    {
        if (empty($this->_type)) {
            $this->_type = $this->_chooseType();
        }
        return $this->_type;
    }

    public function getX()
    {
        return $this->_x;
    }

    public function getY()
    {
        return $this->_y;
    }

    public function searchResults()
    {
        return $this->_searchResults;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setCategory($category)
    {
        $this->_category = $category;
    }

    public function setX($x)
    {
        $this->_x = $x;
    }

    public function setY($y)
    {
        $this->_y = $y;
    }

    public function getSearchProbability($type)
    {
        if (empty($this->_searchProbabilities)) {
            $this->_calculateSearchProbabilities();
        }
        return $this->_searchProbabilities[$type];
    }

    private function _calculateSearchProbabilities()
    {
        $array = array('fuel' => 0, 'techs' => 0);
        if (!empty($this->_searchResults)) {
            foreach ($this->_searchResults as $result)
            {
                $array[$result]++;
            }
        }

        foreach ($array as $type => $results)
        {
            if ($results > POSITION_SEARCH_POOR) {
                $this->_searchProbabilities[$type] = POSITION_SEARCH_POOR_PROBA;
            } else if ($results > POSITION_SEARCH_NORMAL) {
                $this->_searchProbabilities[$type] = POSITION_SEARCH_NORMAL_PROBA;
            } else {
                $this->_searchProbabilities[$type] = 1;
            }
        }
    }

    public function searchRessources($type)
    {
        $proba = POSITION_PROBA_FAST;
        if ($type == 'probes') {
            $proba = POSITION_PROBA_PROBES;
        }

        $fuelProba = $this->getSearchProbability('fuel');
        $techsProba = $this->getSearchProbability('techs');

        $foundFuel = $proba * $fuelProba * POSITION_PROBA_FUEL * 100;
        $foundTechs = $proba * $techsProba * POSITION_PROBA_TECHS * 100;

        $rand = rand(0, 100);
        if ($rand <= $foundFuel) {
            return array('fuel', POSITION_SEARCH_FUEL_QUANTITY);
        } else if ($rand <= $foundFuel + $foundTechs) {
                return array('techs', POSITION_SEARCH_TECHS_QUANTITY);
        }
        
        return array();
    }


    /**
     * Get a destination
     * @param int $type 'DESTINATION_EMPTY' to get empty destination
     * @return \Position
     */
    public function determineDestination($type = DESTINATION_NORMAL)
    {
        if ($type == DESTINATION_EMPTY) {
            $position = self::getClearPosition($this->_x, $this->_y, $this->_id);
            var_dump($position);
            return $position;
        }
        // TODO : determine destination for "normal" search
    }

    /**
     * Get distance between two positions
     * @param type $depX
     * @param type $depY
     * @param type $arrX
     * @param type $arrY
     * @return type
     */
    public static function calculateDistance($depX, $depY, $arrX, $arrY)
    {
        $diffX = abs($depX - $arrX);
        $diffY = abs($depY - $arrY);

        if (!$diffX) {
            return $diffY * POSITION_LENGHT;
        }

        if (!$diffY) {
            return $diffX * POSITION_LENGHT;
        }

        return sqrt(pow($diffX, 2) + pow($diffY, 2)) * POSITION_LENGHT;
    }
    
    /**
     * 
     * @param array $probabilities
     */
    public static function setCategoriesProbabilities(array $probabilities)
    {        self::$_categoriesProbabilities = $probabilities;
    }
    
    /**
     * 
     * @param array $probabilities
     */
    public static function setTypesProbabilities(array $probabilities)
    {
        self::$_typesProbabilities = $probabilities;
    }

    public static function setTypes(array $types)
    {
        self::$_types = $types;
    }

    public static function setCategories(array $categories)
    {
        self::$_categories = $categories;
    }

    /**
     * Return a "clear" position for new players : a position without anyone settled
     * @param int $x
     * @param int $y
     * @return \Position
     */
    public static function getClearPosition($startX = POSITION_START_X, $startY = POSITION_START_Y)
    {
        $rand = rand(0,1);
        if ($rand == 0) {
            $rand = -1;
        }
        for ($x = $startX; $x > POSITION_DEEP_SEARCH_LIMIT; $x--) {
            for ($y = $startY; sqrt(pow($startY - $y, 2)) < POSITION_DEEP_SEARCH_LIMIT_Y; $y = $y + $rand)
            {
                // Detect if ship will move forward
                $move_forward = rand(1,10);
                if ($move_forward == 1) {
                    break;
                }
                if (($x != $startX) || ($y != $startY)) {
                    if (Position::isEmpty($x, $y)) {
                        $Position = new Position($x, $y);
                        if (!$Position->isSql()) {
                            $Position->setX($x);
                            $Position->setY($y);
                            $Position->setCategory($Position->_chooseCategory());
                            $Position->setType($Position->_chooseType());
                            $Position->save();
                        }

                        return $Position;
                    }
                }
            }
        }
    }

    /**
     * Check if position is empty
     * @param type $x
     * @param type $y
     * @return boolean true if it's empty, false otherwise
     */
    protected function isEmpty($x, $y)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT * FROM '.self::$_sqlTable.' WHERE x = :y AND y = :y');
        if ($req->execute(array(
            ':x' => $x,
            ':y' => $y
        ))) {
            while ($row = $req->fetch())
            {
                return !Ship::isOn($row['id']);
            }
        } else {
            var_dump($req->errorInfo());
        }
        return true;
    }

    protected static function get($id, $param=null)
    {
        // Position is instancied with X and Y values
        if (!empty($param[1])) {
            $array = self::getAll(true, '', $param[0], $param[1]);

        // Position is instancied with ID value
        } else {
            $array = self::getAll(true, $id);
        }
        
        if (!empty($array)) {
            return array_shift($array);
        }
    }

    public static function getAll($toArray = false, $id = null, $x = null, $y = null, $userId = null)
    {
        $where = '';
        $args = array();
        $join = '';
        $join_select = '';

        if ($id) {
            $where = 'WHERE id = :id';
            $args[':id'] = $id;
        }

        if ($x) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `x` = :x';
            $args[':x'] = $x;
        }

        if ($y) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' `y` = :y';
            $args[':y'] = $y;
        }

        if ($userId) {
            if (empty($where)) {
                $where = 'WHERE ';
            } else {
                $where .= ' AND ';
            }
            $where .= ' posus.`userId` = :userId';
            $args[':userId'] = $userId;
            $join = 'LEFT JOIN  `'.TABLE_USERS_POSITIONS.'` posus ON posus.`positionId` = id';
            $join_select = '';
        }

        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT * '.$join_select.', posearch.result searchResult FROM `'.self::$_sqlTable.'`
            '.$join.'
                LEFT JOIN (SELECT date, result, positionId FROM `'.TABLE_POSITIONS_SEARCHES.'` WHERE `date` > "'.(time() - POSITION_SEARCH_REGENERATION).'" ORDER BY date DESC) posearch
                    ON `'.self::$_sqlTable.'`.id = posearch.positionId
        '.$where);
        if ($req->execute($args)) {
            $array = array();
            $current = 0;
            $loaded = false;
            $param = array();
            $class = get_called_class();
            while ($row = $req->fetch()) {
                // Nécessaire aux jointures (pour médias ou autres)
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

                // A partir d'ici, on charge les paramètres supplémentaires (par exemple conversion pour les médias)
                if (!empty($row['searchResult'])) {
                    if (empty($param['searchResults'])) {
                        $param['searchResults'] = array();
                    }
                    $param['searchResults'][] = $row['searchResult'];
                }

            }
            if (!empty($param)) {
                if ($toArray) {
                    $array[$current] = $param;
                } else {
                    $array[$current] = new $class($param);
                }
            }
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to get positions', E_USER_ERROR);
        }
        return $array;
    }

    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO '.self::$_sqlTable.' VALUES ("", :x, :y, :zone, :category, :type)');
        if ($req->execute(array(
            ':x' => $this->_x,
            ':y' => $this->_y,
            ':zone' => $this->_zone,
            ':category' => $this->_category,
            ':type' => $this->_type
        ))) {
            return $sql->lastInsertId();
        } else {
            var_dump($req->errorInfo());
        }
    }

    protected function _update()
    {

    }

    protected function _load($param)
    {
        if (!empty($param)) {
            $this->_id = $param['id'];
            $this->_category = $param['category'];
            $this->_type = $param['type'];
            $this->_x= $param['x'];
            $this->_y = $param['y'];
            $this->_zone = $param['zone'];
            if (!empty($param['searchResults'])) {
                $this->_searchResults = $param['searchResults'];
            }
            $this->_sql = true;
        }
    }

    /**
     * Save known position for user
     * @param int $userId
     * @param int $positionId
     * @return boolean
     */
    public static function addUserPosition($userId, $positionId)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT userId FROM `'.TABLE_USERS_POSITIONS.'` WHERE userId = :userId AND positionId = :positionId');
        if ($req->execute(array(
            ':userId' => $userId,
            ':positionId' => $positionId
        ))) {
            while ($row = $req->fetch())
            {
                return;
            }
            $req = $sql->prepare('INSERT INTO `'.TABLE_USERS_POSITIONS.'` VALUES(:userId, :positionId)');
            if ($req->execute(array(
                ':userId' => $userId,
                ':positionId' => $positionId
            ))) {
                return true;
            }
        }
    }

    /**
     * Add search position
     * @param int $positionId
     * @param int $userId
     * @param int $date
     * @param string $result
     * @return boolean
     */
    public static function addPositionSearch($positionId, $userId, $date, $result)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO `'.TABLE_POSITIONS_SEARCHES.'` VALUES(:positionId, :userId, :date, :result)');
        if ($req->execute(array(
            ':positionId' => $positionId,
            ':userId' => $userId,
            ':date' => $date,
            ':result' => $result
        ))) {
            return true;
        } else {
            var_dump($req->errorInfo());
            trigger_error('Unable to add position search', E_USER_ERROR);
        }
    }

    public static function getKnownFor($userId)
    {
        return self::getAll(false, '', '', '', $userId);
    }

    public function isKnownBy($userId)
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT userId from `'.TABLE_USERS_POSITIONS.'` WHERE positionId = :positionId AND userId = :userId LIMIT 1');
        if ($req->execute(array(
            ':positionId' => $this->_id,
            ':userId' => $userId
        ))) {
            while ($row = $req->fetch())
            {
                return true;
            }
        }
        return false;
    }

    public function getDistanceFromEarth()
    {
        return $this->calculateDistance($this->_x, $this->_y, 0, 0);
    }
}