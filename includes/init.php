<?php
// Setting encoding
header('Content-Type: text/html; charset=utf-8');

// Starting sessions
session_start();

define('ROOT_DIR', dirname(__FILE__).'/../');

// Autoloading classes
function __autoload($name)
{
    include_once ROOT_DIR.'class/'.$name.'.php';
}

// Loading configuration
require_once 'config/system.php';

// Loading main functions
require_once 'includes/functions.php';

// Loading template functions
require_once 'includes/functions_template.php';

?>
