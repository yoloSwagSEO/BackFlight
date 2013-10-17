<?php
$array_objects = Object::getAll('', '', $User->getId());


?>
<div class="panel armes">
    <h4>Armes disponibles</h4>
    <div class="row">
        <?php foreach ($MasterShipPlayer->getObjects('weapons') as $moduleId => $quantity)
        {
            if ($quantity != 0) {
                $Module = $array_modules[$moduleId];
                if ($Module->getType() == 'load') {
                    $icon = '&#xe0a1;';
                } else if ($Module->getType() == 'power') {
                    $icon = '&#xe0d1;';
                } else if ($Module->getType() == 'energy') {
                    $icon = '&#xe0b0;';
                } else {
                    $icon = '&#xe0f6;';
                }
                $bigIcon = '&#xe09f;';
                ?>
            <div class='large-4 columns'>
                <a href='#' data-tooltip data-width=250 class="has-tip tip-top module_enable" data-module-id="<?php echo $Module->getId()?>" title="<?php echo $Module->getDescription()?>" style="display: block">
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
                        <strong><?php echo $Module->getName()?></strong>
                        <P>
                            <?php echo $Module->getIntro()?>
                        </P>
                    </div>
                </a>
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
            <a href='#' data-width=250 class="tip-top arme_link" data-module-id="<?php echo $Object->getId()?>" style="display: block">
                <div class='panel'>
                    <div class='arme_type'>
                        <span data-icon="<?php echo $icon?>"></span>
                    </div>
                    <div class='arme_time'>
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
                    <div class="arme_ressources">
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