<div class="panel modules">
    <h4>Modules actifs (<?php echo $MasterShipPlayer->getModulesEnabledNumber() ?>/<?php echo $MasterShipPlayer->getModulesMax() ?>)</h4>
    <div class="row">
    <?php    
    $modulesEnabled = $MasterShipPlayer->getModulesEnabled();
    ksort($modulesEnabled);

    if (!empty($modulesEnabled[7])) {
        unset($modulesEnabled[7]);
    }

    if (!$modulesEnabled) {
        ?>
        <div class="large-12 columns">
            <div class="alert-box success">
        Il n'y a aucun module activé pour l'instant.
            </div>
        </div>
        <?php
    }

    foreach ($modulesEnabled as $moduleId => $quantity)
    {
        $Module = $array_modules[$moduleId];
        $icon = $Module->getIcon();
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
    </div>
</div>
<div class="panel modules">
    <?php

    $modulesAvailable = $MasterShipPlayer->getModules();
    ksort($modulesAvailable);

    ?>
    <h4>Modules à utiliser</h4>
    <div class="row">
        <?php
        if (empty($modulesAvailable)) {
        ?>
        <div class="large-12 columns">
            <div class="alert-box success">
                Il n'y a aucun module disponible.
            </div>
        </div>
        <?php
        }


        foreach ($modulesAvailable as $moduleId => $quantity)
        {
            if ($quantity != 0) {
                $Module = $array_modules[$moduleId];
                $icon = $Module->getIcon();
                $bigIcon = '&#xe0fe;';
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
            $icon = $Module->getIcon();
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