<?php 
if (User::_isPseudoValid($_POST['pseudo'])) {
    $User = new User($_POST['pseudo'], 'pseudo');
	if ($User->isSql()) {
            if ($User->connexion($_POST['password'])) {
                header('location: overview');
                exit;
            } else {
                header('location: '.$_SERVER['PHP_SELF']);
                exit;
            }
	}
        header('location: '.$_SERVER['PHP_SELF']);
        exit;

} else {
    header('location: '.$_SERVER['PHP_SELF']);
    exit;
}