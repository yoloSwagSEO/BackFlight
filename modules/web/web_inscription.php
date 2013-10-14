<?php
$_SESSION['pseudo'] = @$_POST['pseudo'];
$_SESSION['email'] = @$_POST['email'];
$_SESSION['clef'] = @$_POST['clef'];
$_SESSION['password'] = @$_POST['password'];

if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['clef']) && !empty($_POST['password'])) {
    $User = new User();
    // Check if pseudo is valid
    $setPseudo =  $User->setPseudo($_POST['pseudo']);
    $setMail = $User->setMail($_POST['email']);
    $User->setPassword($_POST['password']);

    if ($setPseudo !== true) {
        $_SESSION['errors']['inscription']['pseudo'] = $setPseudo;
    }

    if ($setMail !== true) {
        $_SESSION['errors']['inscription']['email'] = $setMail;
    }

    if ($_POST['clef'] !== KEY_ALPHA) {
        $setKey = false;
        $_SESSION['errors']['inscription']['key'] = 'invalid';
    } else {
        $setKey = true;
    }

    if ($setPseudo === true && $setMail === true && $setKey === true) {
        $User->save();

        header('location: '.PATH);
        $_SESSION['infos']['inscription'] = true;
        exit;
    } else {
        header('location: '.PATH.'inscription');
        exit;
    }


} else {
    
}



?>
