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


    private function _chooseCategory()
    {
        $nb = mt_rand(0, 100);
        $total = 0;
        foreach (self::$_probabilities as $category => $probability)
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
        
    }
    
    public function getCategory()
    {
        if (empty($this->_category)) {
            $this->_category = $this->_chooseCategory();
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
    
    protected function _create()
    {
        $sql = FlyPDO::get();
        $req = $sql->prepare('INSERT INTO '.TABLE_POSITIONS.' VALUES ("", :x, :y, :zone, :category, :type)');
        if ($req->execute(array(
            ':x' => $this->_x, 
            ':y' => $this->_y, 
            ':zone' => $this->_zone,
            ':type' => $this->_type
        ))) {
            $this->_id = $sql->lastInsertId();
        }
    }
    
    protected function _update()
    {
        
    }
    
    /**
     * 
     * @param array $probabilities
     */
    public static function setCategoriesProbabilities(array $probabilities)
    {
        self::$_categoriesProbabilities = $probabilities;
    }
    
    /**
     * 
     * @param array $probabilities
     */
    public static function setTypesProbabilities(array $probabilities)
    {
        self::$_typesProbabilities = $probabilities;
    }
}