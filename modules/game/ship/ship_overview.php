<?php
title('Vaisseau');
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
        <a href="ship/repair" class="button has-tip" data-tooltip title="Nécessite : <br />30 fuel, 250 techs et 5 énergie">
            Réparer le vaisseau
        </a>
        <?php
        }
        ?>
    </div>
</div>


<?php
foot();
?>
