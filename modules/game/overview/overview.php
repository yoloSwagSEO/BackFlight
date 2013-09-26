<?php
title('Ma position');
head();


$MasterShipPosition = new Position($MasterShipPlayer->getPositionId());


?>
<div class="row">
    <div class="column large-3">
        <ul class="side-nav">
            <li><a href="observatory">Observatoire</a></li>
        </ul>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Ma position</h3>
        <div data-alert class="alert-box radius">
            Tout semble si calme...
        </div>
        <p>
            <strong>Position actuelle :</strong> <?php echo $MasterShipPlayer->getPositionX()?>:<?php echo $MasterShipPlayer->getPositionY()?><br />
            <strong>Espace rencontré :</strong> <?php echo $MasterShipPosition->getCategory(true)?>
        </p>
    </div>
</div>


<?php
foot();
?>
