<?php 
if (User::_isPseudoValid($_POST['pseudo'])) {
    $User = new User($_POST['pseudo'], 'pseudo');
	if ($User->isSql()) {
            if ($User->connexion($_POST['password'])) {
                header('location: overview');
                exit;
            } else {
                $_SESSION['error_connexion'] = true;
                header('location: '.PATH);
                exit;
            }
	}
        $_SESSION['error_connexion'] = true;
        header('location:'.PATH);
        exit;

} else {
    $_SESSION['error_connexion'] = true;
        header('location: '.PATH);
    exit;
}