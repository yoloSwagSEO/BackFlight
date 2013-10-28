<?php
// Start engine...
require_once 'includes/init.php';

if (!isConnected()) {
    header('location: '.PATH);
    exit;
}


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
        } else if (isset($_GET['x']) && isset($_GET['y'])) {
            include_once 'modules/game/fly/fly_position.php';
        }
    } else if ($module == 'positions') {
        include_once 'modules/game/positions/positions_known.php';
    } else if ($module == 'search') {
        include_once 'modules/game/search/search_search.php';
    } else if ($module == 'ship') {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'repair') {
                include_once 'modules/game/ship/ship_repair.php';
            } else if ($action == 'weapons') {
                include_once 'modules/game/ship/ship_overview.php';
            }
        } else {
        include_once 'modules/game/ship/ship_overview.php';
        }
    } else if ($module == 'modules') {
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'build') {
                include_once 'modules/game/modules/module_build.php';
            } else if ($action == 'enable') {
                include_once 'modules/game/modules/module_enable.php';
            } else if ($action == 'disable') {
                include_once 'modules/game/modules/module_disable.php';
            }
        }
    } else if ($module == 'quests') {
        if (empty($_GET['questId'])) {
            include_once 'modules/game/quests/quests_home.php';
        } else {
            if (empty($_POST)) {
                include_once 'modules/game/quests/quest_view.php';
            } else {
                include_once 'modules/game/quests/quest_start.php';
            }
        }
    } else if ($module == 'notifications') {
        if (!empty($_GET['read'])) {
            include_once 'modules/game/notifications/notification_read.php';
        } else {
            include_once 'modules/game/notifications/notifications_home.php';
        }
    } else if ($module == 'messages') {
        if (isset($_GET['add'])) {
            if (!empty($_POST)) {
                include_once 'modules/game/messages/message_add.php';
            } else {
                include_once 'modules/game/messages/message_add_form.php';
            }
        } else if (isset($_GET['add_player']) && !empty($_POST)) {
            include_once 'modules/game/messages/message_add_player.php';
        } else if (!empty($_GET['conversation'])) {
            include_once 'modules/game/messages/message_view.php';
        } else if (!empty($_POST['messageId']) && isset($_GET['read'])) {
            include_once 'modules/game/messages/message_read.php';
        } else {
            include_once 'modules/game/messages/messages_home.php';
        }
    } else if ($module == 'ranks') {
        include_once 'modules/game/ranks/ranks_global.php';
        
    } else if ($module == 'weapons') {
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'build') {
                include_once 'modules/game/weapons/weapon_build.php';
            } else if ($action == 'use' && empty($_POST['attack_launch'])) {
                include_once 'modules/game/weapons/weapon_use.php';
            } else if ($action == 'use' && !empty($_POST['attack_launch'])) {
                include_once 'modules/game/weapons/weapon_launch.php';
            }
        }

	} else if ($module == 'drop') {
		include_once 'modules/game/drop/drop_drop.php';
    } else {
        trigger_error('Unknown module', E_USER_ERROR);
    }
} else {
    trigger_error('No module defined', E_USER_ERROR);
}

?>
