<?php
define('SQL_DSN', 'mysql:host=localhost;dbname=backflight');
define('SQL_USER', 'root');
define('SQL_PASS', '');

/**
 * Base path of the game
 */
define('PATH', 'http://localhost/BackFlight/');

/**
 * For testing : drop all tables, recreate game datas, etc
 */
define('ENABLE_SCRIPTS', true);

/**
 * Set to true and game will automatically create missing datas (models, modules, quests, etc)
 */
define('GAME_AUTOCREATE_DATAS', true);

/**
 * The key to sign in during closed alpha
 */
define('KEY_ALPHA', '1234');

/**
 * The analytics stats
 */
define('SCRIPT_STATS', '<!-- Here goes your analytics code -->');
?>
