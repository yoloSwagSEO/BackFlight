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

define('FUEL_WEIGHT', 3);

define('TECHS_WEIGHT', 1.4);

define('POSITION_PROBA_FAST', .3);

define('POSITION_PROBA_PROBES', .95);

define('POSITION_PROBA_FUEL', .70);

define('POSITION_PROBA_TECHS', .30);

define('RESSOURCES_SEARCH_FUEL_QUANTITY', 30);

define('RESSOURCES_SEARCH_TECHS_QUANTITY', 80);

define('POSITION_SEARCH_REGENERATION', 24*3600*2);

define('POSITION_SEARCH_POOR', 10);

define('POSITION_SEARCH_NORMAL', 3);

define('POSITION_SEARCH_POOR_PROBA', .2);

define('POSITION_SEARCH_NORMAL_PROBA', .5);