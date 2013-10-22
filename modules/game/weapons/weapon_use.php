<?php
if (empty($_POST['object_quantity'])) {
    exit('No quantities passed');
}

$array_weapons = Object::getAll('', '', $User->getId());

$array_weapons_post = $_POST['object_quantity'];
$array_weapons_use = array();
$type = '';
foreach ($array_weapons_post as $objectId => $quantity)
{
    if (empty($array_weapons[$objectId])) {
        exit('Unknown object');
    }

    $ObjectWeapon = $array_weapons[$objectId];

    if (empty($type)) {
        $type = $ObjectWeapon->getObjectType();
    } else {
        if ($type != $ObjectWeapon->getObjectType()) {
            exit('Can\'t use torpedoes and mines together');
        }
    }


    // Check for availability
    if (!$MasterShipPlayer->hasObjectAvailable('weapon', $ObjectWeapon->getId())) {
        exit('No object on board');
    }

    $quantity = $MasterShipPlayer->getObject('weapons', $ObjectWeapon->getId());
    if (!$quantity >= $array_weapons_post[$ObjectWeapon->getId()]) {
        exit('Not so much objects onboard');
    }

    $array_weapons_use[$ObjectWeapon->getId()] = $ObjectWeapon;
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
        <form action="weapons/use" method="post" class="custom">
            <ul class="inline-list">
            <?php
            foreach ($array_weapons_use as $ObjectWeapon)
            {
                $quantity = $array_weapons_post[$ObjectWeapon->getId()];
                ?>
                <li>
                    <span class="radius secondary label" style="padding: 8px; display: block"><?php echo $quantity?> x <?php echo $ObjectWeapon->getObjectName()?></span>                    
                    <input type='hidden' name="object_quantity[<?php echo $ObjectWeapon->getId()?>]" value="<?php echo $quantity ?>" />
                </li>
                <?php
            }
            ?>
            </ul>
            <?php
            if ($type == 'torpedo') {
            ?>
            <div class="row">
                <div class="large-6 columns">
                    <strong>Mode de ciblage :</strong>
                    <p>
                        <label for="attack_auto"><input name="attack_auto" id="attack_auto" type="radio" style="display:none;" checked><span class="custom radio checked"></span>Automatique</label>
                        <label for="attack_user"><input name="attack_user" id="attack_user" type="radio" disabled style="display:none;"><span class="custom radio"></span>Fixe</label>
                    </p>
                </div>
                <div class="large-6 columns">
                    <strong>Type d'envoi :</strong>
                    <p>
                        <label for="launch_all"><input name="launch_all" id="launch_all" type="radio" style="display:none;" checked><span class="custom radio checked"></span>Groupé</label>
                        <label for="launch_wave"><input name="launch_wave" id="launch_wave" type="radio" disabled style="display:none;"><span class="custom radio"></span>Par vagues</label>
                    </p>
                </div>
            </div>
            <?php
            }
            ?>
            <input class="button alert" type="submit" value="Lancer l'attaque" name="attack_launch" />
        </form>
    </div>
</div>
<?php
foot();
?>