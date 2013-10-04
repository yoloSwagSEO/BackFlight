<?php
title('Vaisseau');

$array_modules = Module::getAll();

head();


?>
<div class="row">
    <div class="column large-3">
        <ul class="side-nav">
            <li><a href="overview">Ma position</a></li>
            <li><a href="observatory">Observatoire</a></li>
            <li><a href="ship">Vaisseau</a></li>
        </ul>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <?php
        if (!empty($_SESSION['infos']['ship']['repair'])) {
            ?>
    <div class="row">
        <div data-alert="" class="alert-box success radius">
            La réparation du vaisseau est terminée : +<?php echo $_SESSION['infos']['search'][1]?> <?php echo $_SESSION['infos']['search'][0]?>
        </div>
    </div>
        <?php
        }
        ?>
        <h3>Vaisseau</h3>
        <p>
            <strong>Modèle :</strong> <?php echo $MasterShipPlayer->getModelName()?><br />
        </p>

        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php
        if ($MasterShipPlayer->getPower() != $MasterShipPlayer->getPowerMax()) {
        ?>
        <a href="ship/repair" class="button has-tip success" data-tooltip title="Nécessite : <br />30 fuel, 250 techs et 5 énergie">
            Réparer le vaisseau
        </a>
        <?php
        }
        ?>
            <div class="panel modules">
                <h4>Modules actifs (<?php echo $MasterShipPlayer->getModulesEnabledNumber() ?>/<?php echo $MasterShipPlayer->getModulesMaxNumber() ?>)</h4>
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

    </div>
</div>


<?php
foot();
?>
