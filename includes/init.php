<?php
$script_start_microtime = time() + microtime();

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

// Loading form functions
require_once 'includes/functions_form.php';

// Game configuration
require_once 'config/game.php';

// Check game
include_once 'includes/game_verif.php';

// Load game values (eg. ranks)
include_once 'includes/game_load.php';

profile('Before user');
if (!empty($_SESSION['User'])) {
    $User = new User($_SESSION['User']);
    if ($User->isConnected() && $User->isSql()) {
        include_once 'includes/player_load_verif.php';
        include_once 'includes/player_load.php';
    } else {
        session_destroy();
        header('location: '.PATH);
    }
} else {
    $User = new User();
}

profile('User loaded');

?>
