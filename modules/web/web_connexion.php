<?php 
if (User::_isPseudoValid($_POST['pseudo'])) {
    $User = new User($_POST['pseudo'], 'pseudo');
	if ($User->isSql()) {
            if ($User->connexion($_POST['password'])) {
                header('location: index.php');
                exit;
            } else {
                header('location: index.php');
                exit;
            }
	}
	header('location: index.php');
	exit;

} else {
    header('location: index.php');
    exit;
}