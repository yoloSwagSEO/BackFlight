<?php
title('Vaisseau');

$array_modules = Module::getAll('', '', $User->getId());

head();


?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
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
        <dl class="sub-nav">
            <dt>Afficher :</dt>
            <dd<?php if (!isset($_GET['action'])) {?> class="active"<?php } ?>><a href="ship">Modules</a></dd>
            <dd<?php if (isset($_GET['action'])) {?> class="active"<?php } ?>><a href="ship/weapons">Armes</a></dd>
        </dl>

        <?php
        if (!isset($_GET['action'])) {
            include_once 'modules/game/ship/ship_modules.php';
        } else {
            include_once 'modules/game/ship/ship_weapons.php';
        }
        ?>
        
    </div>
</div>


<?php
foot();
?>
