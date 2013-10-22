<?php
include_once 'modules/game/weapons/weapons_check_post.php';

title('Lancement d\'une attaque');
head();

$range = 0;

foreach ($array_weapons_use as $ObjectWeapon)
{
    if (empty($range)) {
        $range = $ObjectWeapon->getObjectRange();
    } else {
        if ($range > $ObjectWeapon->getObjectRange()) {
            $range = $ObjectWeapon->getObjectRange();
        }
    }
}

$array_ships_front = Ship::getShips($MasterShipPlayer->getPositionX(), $MasterShipPlayer->getPositionY(), $range, $User->getId(), 'front');
$array_ships_behind = Ship::getShips($MasterShipPlayer->getPositionX(), $MasterShipPlayer->getPositionY(), $range, $User->getId(), 'behind');

$nb_ships_front = count($array_ships_front);
$nb_ships_behind = count($array_ships_behind);


$front_disabled = '';
if ($nb_ships_front < 1) {
    $front_disabled = 'disabled';
}

$behind_disabled = '';
if ($nb_ships_behind < 1) {
    $behind_disabled = 'disabled';
}


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
                <div class="large-4 columns">
                    <strong>Direction :</strong>
                    <p>
                        <label>
                            <input name="launch_direction" type="radio" style="display:none;" <?php echo $front_disabled;?> value="front">
                            <span class="custom radio"></span>
                            <span data-tooltip title="<?php echo $nb_ships_front?> vaisseau(x) à cibler" class="has-tip">Vers l'avant</span>
                        </label>
                        <label>
                            <input name="launch_direction"  type="radio" style="display:none;" <?php echo $behind_disabled;?> value="behind">
                            <span class="custom radio"></span>
                            <span data-tooltip title="<?php echo $nb_ships_behind?> vaisseau(x) à cibler" class="has-tip">Vers l'arrière</span>
                        </label>
                    </p>
                </div>
                <div class="large-4 columns">
                    <strong>Type d'envoi :</strong>
                    <p>
                        <label>
                            <input name="launch_mode" type="radio" style="display:none;" checked value="all">
                            <span class="custom radio checked"></span>
                            <span class="has-tip" data-tooltip title="Toutes les torpilles partent en même temps">Groupé</span>
                        </label>
                        <label>
                            <input name="launch_mode" type="radio" style="display:none;" value="wave">
                            <span class="custom radio"></span>
                            <span class="has-tip" data-tooltip title="Les torpilles sont envoyées une à une">Par vagues</span>
                        </label>
                    </p>
                </div>
                <div class="large-4 columns">
                    <strong>Mode de ciblage :</strong>
                    <p>
                        <label for="attack_auto">
                            <input name="attack_mode" type="radio" style="display:none;" checked value="auto">
                            <span class="custom radio checked"></span>
                            <span class="has-tip" data-tooltip title="Les torpilles ciblent un des vaisseaux à portée">Automatique</span>
                        </label>
                        <label for="attack_user">
                            <input name="attack_mode" type="radio" disabled style="display:none;" value="user">
                            <span class="custom radio"></span>
                            <span class="has-tip" data-tooltip title="Les torpilles ciblent le vaisseau indiqué">Fixe</span>
                        </label>
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