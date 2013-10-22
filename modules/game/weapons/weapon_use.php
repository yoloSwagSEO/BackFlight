<?php
include_once 'modules/game/weapons/weapons_check_post.php';

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
                <div class="large-4 columns">
                    <strong>Direction :</strong>
                    <p>
                        <label for="launch_front"><input name="launch_direction" id="launch_front" type="radio" style="display:none;" checked value="front"><span class="custom radio checked"></span>Vers l'avant</label>
                        <label for="launch_behind"><input name="launch_direction" id="launch_behind" type="radio" style="display:none;" value="behind"><span class="custom radio"></span>Vers l'arrière</label>
                    </p>
                </div>
                <div class="large-4 columns">
                    <strong>Type d'envoi :</strong>
                    <p>
                        <label for="launch_all"><input name="launch_mode" id="launch_all" type="radio" style="display:none;" checked value="all"><span class="custom radio checked"></span>Groupé</label>
                        <label for="launch_wave"><input name="launch_mode" id="launch_wave" type="radio" style="display:none;" value="wave"><span class="custom radio"></span>Par vagues</label>
                    </p>
                </div>
                <div class="large-4 columns">
                    <strong>Mode de ciblage :</strong>
                    <p>
                        <label for="attack_auto"><input name="attack_mode" id="attack_auto" type="radio" style="display:none;" checked value="auto"><span class="custom radio checked"></span>Automatique</label>
                        <label for="attack_user"><input name="attack_mode" id="attack_user" type="radio" disabled style="display:none;" value="user"><span class="custom radio"></span>Fixe</label>
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