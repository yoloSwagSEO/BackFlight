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
        } else if (!empty($_GET['x']) && !empty($_GET['y'])) {
            include_once 'modules/game/fly/fly_position.php';
        }
    } else if ($module == 'positions') {
        include_once 'modules/game/positions/positions_known.php';
    } else if ($module == 'search') {
        include_once 'modules/game/search/search_search.php';
    } else if ($module == 'ship') {
        include_once 'modules/game/ship/ship_overview.php';
    }
}

?>
