<?php


                //
                // GLOBAL
                //
/**
 * Game speed
 */
define('GAME_SPEED', 20);

/**
 * Position distance
 */
define('POSITION_LENGHT', 100);



                //
                // SHIP
                //

/**
 * How much faster than normal flight jumps are
 */
define('SHIP_JUMP_SPEED_FACTOR', 5);

/**
 * Quantity of energy used by a ship for one distance unit
 */
define('SHIP_ENERGY_USE', .3);

/**
 * Quantity of fuel burnt by a ship for one distance unit
 */
define('SHIP_FUEL_USE', .2);

/**
 * Ship's loading tolerance
 */
define('SHIP_LOAD_TOLERANCE', 1.1);

/**
 * Quantity of fuel on ship creation
 */
define('SHIP_START_FUEL', 50);

/**
 * Maximal energy for a basic ship
 */
define('SHIP_START_ENERGYMAX', 100);

/**
 * Energy gain per hour
 */
define('SHIP_START_ENERGY_GAIN', 100);

/**
 * Max fuel for a basic ship
 */
define('SHIP_START_FUELMAX', 100);

/**
 * Max power for a basic ship
 */
define('SHIP_START_POWERMAX', 100);

/**
 * Speed of a basic ship
 */
define('SHIP_START_SPEED', 10);

/**
 * Quantity of techs on ship creation
 */
define('SHIP_START_TECHS', 200);
/**
 * Quantity of energy on ship creation
 */
define('SHIP_START_ENERGY', 100);

/**
 * Quantity of power on ship creation
 */
define('SHIP_START_POWER', 70);

/**
 * Max loading for a basic ship
 */
define('SHIP_START_LOADMAX', 1000);

define('SHIP_FLIGHT_FORWARD_PROBA', 0.9);

define('SHIP_JUMP_FORWARD_PROBA', 0.2);


define('FLIGHT_PROBA_ASTEROIDS_HIT_FLIGHT', 0.2);

define('FLIGHT_PROBA_ASTEROIDS_HIT_SEARCH', 0.30);

                    //
                    // POSITION
                    //

Position::setCategoriesProbabilities(array('space' => 70, 'asteroids' => 20, 'planet' => 10));

Position::setTypesProbabilities(array());

Position::setCategories(array('space' => 'Espace', 'asteroids' => 'Astéroïdes', 'planet' => 'Planète'));

/**
 * Limit for searching a clean place for new users
 */
define('POSITION_DEEP_SEARCH_LIMIT', 700);

define('POSITION_DEEP_SEARCH_LIMIT_Y', 50);

/**
 * An empty destination
 */
define('DESTINATION_EMPTY', 1);

/**
 * A normal destination
 */
define('DESTINATION_NORMAL', 2);

                    //
                    // POSITION SEARCHES
                    //

/**
 * Probability to find something on fast search
 */
define('POSITION_PROBA_FAST', .3);

/**
 * Probability to fond something during search with probes
 */
define('POSITION_PROBA_PROBES', .95);

/**
 * Probability to find fuel
 */
define('POSITION_PROBA_FUEL', .70);

/**
 * Probability to find techs
 */
define('POSITION_PROBA_TECHS', .30);

/**
 * Time for a position to become "rich" again
 */
define('POSITION_SEARCH_REGENERATION', 24*3600*2);

/**
 * Number of search after which position is "poor"
 */
define('POSITION_SEARCH_POOR', 10);

/**
 * Number of search after which a position is "normal"
 */
define('POSITION_SEARCH_NORMAL', 3);

/**
 * Probability to find something on "poor" positions
 */
define('POSITION_SEARCH_POOR_PROBA', .2);

/**
 * Probability to find something on "normal" position
 */
define('POSITION_SEARCH_NORMAL_PROBA', .5);

/**
 * Minimal quantity of fuel found during sucessful search
 */
define('POSITION_SEARCH_FUEL_QUANTITY', 30);

/**
 * Minimal quantity of techs found during sucessful search
 */
define('POSITION_SEARCH_TECHS_QUANTITY', 80);


/**
 * First ship start position X
 */
define('POSITION_START_X', 800);

/**
 * First ship start position Y
 */
define('POSITION_START_Y', 0);

                    //
                    // RESSOURCES
                    //

/**
 * Weight of one unit of fuel
 */
define('FUEL_WEIGHT', 3);

/**
 * Weight of one unit of tech
 */
define('TECHS_WEIGHT', 1.4);
