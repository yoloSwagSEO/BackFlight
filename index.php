<?php
// Start engine...
require_once 'includes/init.php';

if (isset($_GET['connexion'])) {
    if (empty($_POST)) {
        include_once 'modules/web/web_connexion_form.php';
    } else {
        include_once 'modules/web/web_connexion.php';
    }
} else if (isset($_GET['deconnexion'])) {
    include_once 'modules/web/web_deconnexion.php';
    
} else {
    // Loading home
    if ($User->isConnected()) {
        header('location: overview');
        exit;
    } else {
        include_once 'modules/web/web_home.php';
    }
}

?>
