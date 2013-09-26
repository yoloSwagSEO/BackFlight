<?php
require_once 'includes/init.php';
if (empty($_GET['script'])) {
    include_once 'modules/scripts/scripts_home.php';
} else {
    $script = $_GET['script'];
    if ($script == 'create-player') {
        include_once 'modules/scripts/script_create_player.php';
    } else if ($script == 'start-over') {
        include_once 'modules/scripts/script_start_over.php';
    }
}
?>
