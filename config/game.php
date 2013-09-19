<?php
Position::setCategoriesProbabilities(array('space' => 70, 'asteroids' => 20, 'planet' => 10));

Position::setTypesProbabilities(array());

Position::setCategories(array('space' => 'Espace', 'asteroids' => 'Astéroïdes', 'planet' => 'Planète'));

define('POSITION_DEEP_SEARCH_LIMIT', 500);

define('DESTINATION_EMPTY', 1);

define('DESTINATION_NORMAL', 2);

define('SHIP_LOAD_TOLERANCE', 1.1);

define('GAME_SPEED', 20);

define('POSITION_LENGHT', 100);

define('SHIP_JUMP_SPEED_FACTOR', 5);

define('SHIP_ENERGY_USE', .3);

define('SHIP_FUEL_USE', .2);