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
        <h3>Vaisseau</h3>
        <p>
            <strong>Modèle :</strong> <?php echo $MasterShipPlayer->getModelName()?><br />
        </p>

        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php
        if ($MasterShipPlayer->getPower() != $MasterShipPlayer->getPowerMax()) {
        ?>
        <a href="ship/repair" class="button">
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
