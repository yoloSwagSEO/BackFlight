<?php
// Start engine...
require_once 'includes/init.php';

if (!empty($_GET['module'])) {
    $module = $_GET['module'];

    if ($module == 'overview') {
        include_once 'modules/game/overview/overview.php';
    } else if ($module == 'observatory') {
        include_once 'modules/game/observatory/observatory_home.php';
    }
}

?>
