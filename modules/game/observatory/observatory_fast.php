<?php
title('Observatory - Fast look');
head();


$MasterShipPosition = new Position($MasterShipPlayer->getPositionId());
$position_category = $MasterShipPosition->getCategory();

?>
<div class="row">
    <div class="column large-3">
        <ul class="side-nav">
            <li><a href="overview">Ma position</a></li>
        </ul>
        <?php include_once 'modules/game/ship/ship_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Observatoire</h3>
        <div data-alert class="alert-box success radius">
            <?php
            if ($position_category == 'planet') {
            ?>
                Nos capteurs détectent une planète habitable.
            <?php
            } else if ($position_category == 'asteroids') {
                ?>
                Nos capteurs détectent un vaste champs d'astéroïdes. 
                <?php
            } else if ($position_category == 'space') {
                ?>
                Nos capteurs détectent seulement du vide : nous sommes en plein espace.
                <?php
            }
            ?>
        </div>

        <?php
        include_once 'modules/game/observatory/observatory_'.$position_category.'.php';
        ?>


<?php
foot();
?>

