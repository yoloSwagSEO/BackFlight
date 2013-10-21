<?php
$ObjectWeapon = new Object($_POST['object_id']);
if (!$ObjectWeapon->isSql()) {
    exit('Unknown object');
}

if (!$MasterShipPlayer->hasObjectAvailable('weapon', $ObjectWeapon->getId())) {
    exit('No object on board');
}

$quantity = $MasterShipPlayer->getObject('weapons', $ObjectWeapon->getId());
if (!$quantity >= $_POST['quantity']) {
    exit('Not so much objects onboard');
}


title('Lancement d\'une attaque');
head();


?>

<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">        
        <h3>Lancement d'une attaque</h3>
        <p>
            <strong><?php echo $ObjectWeapon->getObjectType()?> :</strong> <?php echo $ObjectWeapon->getObjectName()?><br />
        </p>
        <form action="weapons/use" method="post" class="custom">
            Mode de ciblage :
            <label for="attack_auto"><input name="attack_auto" id="attack_auto" type="radio" style="display:none;" CHECKED><span class="custom radio checked"></span>Automatique</label>
            <label for="attack_user"><input name="attack_user" id="attack_user" type="radio" disabled style="display:none;"><span class="custom radio"></span>Fixe</label>

            <input type='hidden' name="object_id" value="<?php echo $ObjectWeapon->getId()?>" />
            <input type='hidden' name="quantity" value="<?php echo $_POST['quantity']?>" />
            <input class="button alert" type="submit" value="Lancer l'attaque" name="attack_launch" />
        </form>
    </div>
</div>
<?php
foot();
?>