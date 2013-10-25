<div class="panel modules">
    <h4>Modules actifs (<?php echo $MasterShipPlayer->getModulesEnabledNumber() ?>/<?php echo $MasterShipPlayer->getModulesMax() ?>)</h4>
    <?php
    if (!$MasterShipPlayer->getModulesEnabled()) {
        ?>
    <p>
        Il n'y a aucun module activé pour l'instant.
    </p>
        <?php
    }
    foreach ($MasterShipPlayer->getModulesEnabled() as $moduleId => $quantity)
    {
        if ($moduleId == 7) {
            continue;
        }
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
            <a href='#' data-tooltip data-width=250 class="has-tip tip-top module_disable" data-module-id="<?php echo $Module->getId()?>" title="<?php echo $Module->getDescription()?>" style="display: block">
                <div class='panel'>
                    <div class='module_type'>
                        <span data-icon="<?php echo $icon?>"></span>
                    </div>
                    <div class='module_time'>
                        <?php echo $quantity; ?>
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
    ?>
    <hr />
    <h4>Modules à utiliser</h4>
    <div class="row">
        <?php foreach ($MasterShipPlayer->getModules() as $moduleId => $quantity)
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
    <div class="panel modules">
    <h4>Modules à fabriquer</h4>
    <p>Les modules doivent être fabriqués avant d'être activés</p>
    <div class="row">
        <?php foreach ($array_modules as $Module)
        {
            if ($Module->getType() == 'load') {
                $icon = '&#xe0a1;';
            } else if ($Module->getType() == 'power') {
                $icon = '&#xe0d1;';
            } else if ($Module->getType() == 'energy') {
                $icon = '&#xe0b0;';
            } else {
                $icon = '&#xe0f6;';
            }
            $bigIcon = '&#xe091;';
            if ($Module->isBuilding()) {
                $bigIcon = '&#xe077;';
            }

            $quantity = $Module->getBuildQuantity();
            ?>
        <div class='large-4 columns'>
            <a href='#' data-tooltip data-width=250 class="has-tip tip-top module_link" data-module-id="<?php echo $Module->getId()?>" title="<?php echo $Module->getDescription()?>" style="display: block">
                <div class='panel'>
                    <div class='module_type'>
                        <span data-icon="<?php echo $icon?>"></span>
                    </div>
                    <div class='module_time'>
                        <?php
                        if ($Module->isBuilding()) {
                            if ($quantity > 1) {
                                echo '('.$quantity.') ';
                            }
                            echo renderCountDown($Module->getBuildEnd() - time());
                        } else {
                            echo countDown($Module->getTime());
                        }
                        ?>
                    </div>
                    <span class="icon_big" data-icon="<?php echo $bigIcon?>"></span>
                    <strong><?php echo $Module->getName()?></strong>
                    <P>
                        <?php echo $Module->getIntro()?>
                    </P>
                    <div class="modules_ressources">
                        <span data-icon="&#xe0a4;" class="fuel"><?php echo $Module->getCostFuel()?></span>
                        <span data-icon="&#xe08e;" class="techs"><?php echo $Module->getCostTechs()?></span>
                        <span data-icon="&#xe0b0;" class="energy"><?php echo $Module->getCostEnergy()?></span>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
    ?>
    </div>
</div>