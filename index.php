<?php
// Start engine...
require_once 'includes/init.php';

if (isset($_GET['connexion'])) {
    if (empty($_POST)) {
        include_once 'modules/web/web_connexion_form.php';
    } else {
        include_once 'modules/web/web_connexion.php';
    }
} else {
    // Loading home
    include_once 'modules/web/web_home.php';
}

?>
