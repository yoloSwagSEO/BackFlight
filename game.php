<?php
// Start engine...
require_once 'includes/init.php';

if (!empty($_GET['module'])) {
    $module = $_GET['module'];

    if ($module === 'overview') {
        include_once 'modules/game/overview/overview.php';
    } else if ($module === 'observatory') {
        if (empty($_GET['action'])) {
            include_once 'modules/game/observatory/observatory_home.php';
        } else if ($_GET['action'] == 'fast') {
            include_once 'modules/game/observatory/observatory_fast.php';
        }
    } else if ($module === 'fly') {
        if (!empty($_GET['to'])) {
            $to = $_GET['to'];
            if ($to == 'space') {
                include_once 'modules/game/fly/fly_space.php';
            } 
        }
    }
}

?>
