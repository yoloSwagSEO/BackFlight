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


    /**
     * Get a destination
     * @param int $type 'DESTINATION_EMPTY' to get empty destination
     * @return \Position
     */
    public function determineDestination($type = DESTINATION_NORMAL)
    {
        if ($type == DESTINATION_EMPTY) {
            return self::getClearPosition($this->_x, $this->_y);
        }
        // TODO : determine destination for "normal" search
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
    public static function getClearPosition($x = 1, $y = 1)
    {
        for ($x; $x < POSITION_DEEP_SEARCH_LIMIT; $x++) {
            for ($y; $y < POSITION_DEEP_SEARCH_LIMIT; $y++)
            {
                var_dump($x, $y);
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

    /**
     * Check if position is empty
     * @param type $x
     * @param type $y
     * @return boolean true if it's empty, false otherwise
     */
    protected function isEmpty($x, $y)
    {
        var_dump('Check empty');
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
        if (!empty($param[2])) {
            $array = self::getAll(true, '', $param[1], $param[2]);

        // Position is instancied with ID value
        } else {
            $array = self::getAll(true, $id);
        }
        
        if (!empty($array)) {
            return array_shift($array);
        }
    }

    public static function getAll($toArray = false, $id = null, $x = null, $y = null)
    {
        $where = '';
        $args = array();

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

        $sql = FlyPDO::get();
        $req = $sql->prepare('SELECT * FROM `'.self::$_sqlTable.'` '.$where);
        if ($req->execute($args)) {
            $array = array();
            while ($row = $req->fetch()) {
                if ($toArray) {
                    $array[$row['id']] = $row;
                } else {
                    $array[$row['id']] = new Position($row);
                }
            }
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
            $this->_id = $sql->lastInsertId();
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
            $this->_sql = true;
        }
    }
    
}