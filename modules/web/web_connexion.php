<?php 
if (User::_isPseudoValid($_POST['pseudo'])) {
    $User = new User($_POST['pseudo'], 'pseudo');
	if ($User->isSql()) {
            if ($User->connexion($_POST['password'])) {
                header('location: ../');
                exit;
            } else {
                header('location: ../');
                exit;
            }
	}
        header('location: ../');
        exit;

} else {
    header('location: ../');
    exit;
}