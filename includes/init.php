<?php
// Setting encoding
header('Content-Type: text/html; charset=utf-8');

// Starting sessions
session_start();

// For includes
define('ROOT_DIR', dirname(__FILE__).'/../');

// Error reporting
error_reporting(E_ALL & ~E_STRICT);

// Autoloading classes
function __autoload($name)
{
    include_once ROOT_DIR.'class/'.$name.'.php';
}

// Loading configuration
require_once 'config/system.php';

// Loading tables
require_once 'config/tables.php';

// Loading main functions
require_once 'includes/functions.php';

// Loading template functions
require_once 'includes/functions_template.php';

// Game configuration
require_once 'config/game.php';


include_once 'includes/game_verif.php';
if (!empty($_SESSION['User'])) {
    $User = new User($_SESSION['User']);
    if ($User->isConnected()) {
        include_once 'includes/player_load_verif.php';
        include_once 'includes/player_load.php';
    }
} else {
    $User = new User();
}

?>
