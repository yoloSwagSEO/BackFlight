<?php
title('Create player');

$player_exists = false;

$User = new User();
$pseudo_ok = $User->setPseudo('Player');
$mail_ok = $User->setMail('player@backflight.fr');
$User->setPassword('Fly, you fools!');

if ($pseudo_ok == true && $mail_ok === true) {
    $User->save();
} else {
    $player_exists = true;
}

head();
?>
<div class="row">
    <div class="columns large-8">
        <h3>Création d'un joueur</h3>
        <?php if ($player_exists) { ?>
            Le joueur existe déjà !
        <?php } else { ?>
            Le joueur a été créé !
        <?php } ?>
    </div>
</div>
<?php
foot();
?>
