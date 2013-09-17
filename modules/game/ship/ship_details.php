<div class="panel">
    <?php
        echo '<div data-alert="" class="alert-box radius">('.$MasterShipPlayer->getModelName().') position : '.$MasterShipPlayer->getPositionX().':'.$MasterShipPlayer->getPositionY().'</div>';
    ?>
    Power <small>(<?php echo $MasterShipPlayer->getPower()?> / <?php echo $MasterShipPlayer->getPowerMax()?>)</small>
    <div class="progress success radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getPower() / $MasterShipPlayer->getPowerMax() * 100)?>%"></span></div>

    Energy <small>(<?php echo $MasterShipPlayer->getEnergy()?> / <?php echo $MasterShipPlayer->getEnergyMax()?>)</small>
    <div class="progress radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getEnergy() / $MasterShipPlayer->getEnergyMax() * 100)?>%"></span></div>

    Fuel <small>(<?php echo $MasterShipPlayer->getFuel()?> / <?php echo $MasterShipPlayer->getFuelMax()?>)</small>
    <div class="progress alert radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getFuel() / $MasterShipPlayer->getFuelMax() * 100)?>%"></span></div>

    Load <small>(<?php echo $MasterShipPlayer->getLoad()?> / <?php echo $MasterShipPlayer->getLoadMax()?>)</small>
    <div class="progress success radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getLoad() / $MasterShipPlayer->getLoadMax() * 100)?>%"></span></div>

    Speed : <?php echo $MasterShipPlayer->getSpeed()?>

</div>
