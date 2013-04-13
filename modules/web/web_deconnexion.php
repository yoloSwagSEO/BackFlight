<?php
if (isConnected()) {
    $User->deconnexion();
    header('location: ../');
    exit;
}
?>
