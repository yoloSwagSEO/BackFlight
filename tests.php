<?php
// Start engine...
require_once 'includes/init.php';

if (!isConnected()) {
    header('location: '.PATH);
    exit;
}

if (!empty($_GET['test'])) {
    $test = $_GET['test'];
    if ($test == 'searches') {
        include_once 'modules/tests/test_searches.php';
    }
}
?>
