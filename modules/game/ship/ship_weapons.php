<?php
$array_objects = Object::getAll('', '', $User->getId());

$array_weapons = $MasterShipPlayer->getObjects('weapons');
$array_weapons_user = array();
foreach ($array_weapons as $objectId => $quantity)
{
    $ObjectWeapon = $array_objects[$objectId];
    $array_weapons_user[$ObjectWeapon->getObjectType()][$objectId] = $quantity;
}


?>
<div class="panel armes">
    <h4>Armes disponibles</h4>
    <div class="row">
        <?php
        foreach ($array_weapons_user as $type => $array_weapons_type)
        {
            if (!empty($array_weapons_type)) {
                ?>
            <div class="columns large-12">
                <form action="weapons/use" method="post">
                <fieldset>
                    <legend><?php echo $type ?></legend>
                    <div class="row">
                    <?php
                    foreach ($array_weapons_type as $objectId => $quantity)
                    {
                        if ($quantity != 0) {
                            $ObjectWeapon = $array_objects[$objectId];
                            if ($ObjectWeapon->getObjectType() == 'mine') {
                                $icon = '&#xe0a1;';
                            } else if ($ObjectWeapon->getObjectType() == 'torpedo') {
                                $icon = '&#xe0d1;';
                            } else {
                                $icon = '&#xe0f6;';
                            }
                            $bigIcon = '&#xe09f;';
                            ?>
                        <div class='large-4 columns'>
                            <div class='panel'>
                                <div class='module_type'>
                                    <span data-icon="<?php echo $icon?>"></span>
                                </div>
                                <div class='module_time'>
                                    <?php
                                    echo $quantity;
                                    ?>
                                </div>
                                <span class="icon_big" data-icon="<?php echo $bigIcon?>"></span>
                                <strong><?php echo $ObjectWeapon->getObjectName()?></strong>
                                <P style="font-size: .8em;">
                                    <?php echo $ObjectWeapon->getObjectDescription()?>
                                </P>
                                    <div class="row collapse">
                                        <div class="small-6 columns">
                                            <label class="prefix radius" for="quantity_<?php echo $ObjectWeapon->getId()?>">Quantité</label>
                                        </div>
                                        <div class="small-6 columns">
                                            <input type="number" id="quantity_<?php echo $ObjectWeapon->getId()?>" placeholder="max <?php echo $quantity?>" name="object_quantity[<?php echo $ObjectWeapon->getId()?>]" min="0" max="<?php echo $quantity?>">
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    ?>
                    </div>
                    <div class="row">
                        <div class="large-12 columns" style="text-align: center;">
                            <?php
                            if ($type == 'torpedo') {
                                $value = 'Lancer une attaque';
                            } else {
                                $value = 'Larguer les mines';
                            }
                            ?>
                            <input type="submit" value="<?php echo $value ?>" class="button small alert" />
                        </div>
                    </div>
                </fieldset>
            </form>
            </div>
                <?php
            }
        }
    ?>
    </div>
</div>
<div class="panel armes">
    <h4>Armes à fabriquer</h4>
    <p>Une fois fabriquées, les armes pourront être utilisées</p>
    <div class="row">
        <?php foreach ($array_objects as $Object)
        {
            if ($Object->getObjectType() == 'load') {
                $icon = '&#xe0a1;';
            } else if ($Object->getObjectType() == 'power') {
                $icon = '&#xe0d1;';
            } else if ($Object->getObjectType() == 'energy') {
                $icon = '&#xe0b0;';
            } else {
                $icon = '&#xe0f6;';
            }
            $bigIcon = '&#xe091;';
            if ($Object->isBuilding()) {
                $bigIcon = '&#xe077;';
            }

            $quantity = $Object->getBuildQuantity();
            ?>
        <div class='large-4 columns'>
            <a href='#' data-width=250 class="tip-top weapon_link" data-weapon-id="<?php echo $Object->getId()?>" style="display: block">
                <div class='panel'>
                    <div class='weapon_type'>
                        <span data-icon="<?php echo $icon?>"></span>
                    </div>
                    <div class='weapon_time'>
                        <?php
                        if ($Object->isBuilding()) {
                            if ($quantity > 1) {
                                echo '('.$quantity.') ';
                            }
                            echo renderCountDown($Object->getBuildEnd() - time());
                        } else {
                            echo countDown($Object->getObjectTime());
                        }
                        ?>
                    </div>
                    <span class="icon_big" data-icon="<?php echo $bigIcon?>"></span>
                    <strong><?php echo $Object->getObjectName()?></strong>
                    <P style="font-size: .8em;">
                        <?php echo $Object->getObjectDescription()?>
                    </P>
                    <div class="weapon_ressources">
                        <span data-icon="&#xe0a4;" class="fuel"><?php echo $Object->getObjectCostFuel()?></span>
                        <span data-icon="&#xe08e;" class="techs"><?php echo $Object->getObjectCostTechs()?></span>
                        <span data-icon="&#xe0b0;" class="energy"><?php echo $Object->getObjectCostEnergy()?></span>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
    ?>
    </div>
</div>