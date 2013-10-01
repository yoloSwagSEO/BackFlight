<?php
title('Vaisseau');


$modules_nb = $MasterShipPlayer->getModulesMaxNumber();

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
            <div class="panel" id="modules">
                <h4>Modules actifs (<?php echo $MasterShipPlayer->getModulesNumber() ?>/<?php echo $MasterShipPlayer->getModulesMaxNumber() ?>)</h4>
                <p>
                Il n'y a aucun module activé pour le moment !
                </p>
                <hr /><br />
                <h4>Modules à fabriquer</h4>
                <p>Les modules doivent être fabriqués avant d'être activés</p>
                <div class="row">
                    <div class='large-4 columns'>
                        <a href='#'>
                            <div class='panel'>
                                <div class='module_type'>
                                    <span data-icon="&#xe0a1;"></span>
                                </div>
                                <span class="icon_big" data-icon="&#xe091;"></span>
                                <strong>Bloc de soute</strong>
                                <P>
                                    Chargement x2
                                </P>
                                <div class="modules_ressources">
                                    <span data-icon="&#xe0a4;" class="fuel">25</span>
                                    <span data-icon="&#xe08e;" class="techs">200</span>
                                    <span data-icon="&#xe0b0;" class="energy">20</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class='large-4 columns'>
                        <a href='#'>
                            <div class='panel'>
                                <div class='module_type'>
                                    <span data-icon="&#xe0d1;"></span>
                                </div>
                                <span class="icon_big" data-icon="&#xe091;"></span>
                                <strong>Renforcement coque</strong>
                                <P>
                                    +30% vitalité
                                </P>
                                <div class="modules_ressources">
                                    <span data-icon="&#xe0a4;" class="fuel">25</span>
                                    <span data-icon="&#xe08e;" class="techs">200</span>
                                    <span data-icon="&#xe0b0;" class="energy">20</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class='large-4 columns'>
                        <a href='#'>
                            <div class='panel'>
                                <div class='module_type'>
                                    <span data-icon="&#xe0b0;"></span>
                                </div>
                                <span class="icon_big" data-icon="&#xe091;"></span>
                                <strong>Batterie supplémentaire</strong>
                                <P>
                                    Energie x2
                                </P>
                                <div class="modules_ressources">
                                    <span data-icon="&#xe0a4;" class="fuel">25</span>
                                    <span data-icon="&#xe08e;" class="techs">200</span>
                                    <span data-icon="&#xe0b0;" class="energy">20</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

    </div>
</div>


<?php
foot();
?>
