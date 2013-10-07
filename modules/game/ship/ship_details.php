<div class="panel">
    <?php
        echo '<div data-alert="" class="alert-box radius">'.$MasterShipPlayer->getModelName().' ('.$MasterShipPlayer->getState().')<br />Position : '.$MasterShipPlayer->getPositionX().':'.$MasterShipPlayer->getPositionY().'</div>';
    ?>
    <span data-tooltip title='Gain : <?php echo round($MasterShipPlayer->getEnergyGain() / 3600 * GAME_SPEED / 10, 2)?> power / s'>Power</span> <small>(<?php echo round($MasterShipPlayer->getPower())?> / <?php echo $MasterShipPlayer->getPowerMax()?>)</small>
    <div class="progress success radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getPower() / $MasterShipPlayer->getPowerMax() * 100)?>%"></span></div>

    <span data-tooltip title='Gain : <?php echo round($MasterShipPlayer->getShieldGain() / 3600 * GAME_SPEED, 2)?> shield / s'>Shield</span> <small>(<?php echo round($MasterShipPlayer->getShield())?> / <?php echo $MasterShipPlayer->getShieldMax()?>)</small>
    <div class="progress radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getShield() / $MasterShipPlayer->getShieldMax() * 100)?>%"></span></div>

    <span data-tooltip title='Gain : <?php echo round($MasterShipPlayer->getEnergyGain() / 3600 * GAME_SPEED, 2)?> energy / s'>Energy</span> <small>(<?php echo round($MasterShipPlayer->getEnergy())?> / <?php echo $MasterShipPlayer->getEnergyMax()?>)</small>
    <div class="progress radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getEnergy() / $MasterShipPlayer->getEnergyMax() * 100)?>%"></span></div>

    Fuel <small>(<?php echo round($MasterShipPlayer->getFuel())?> / <?php echo $MasterShipPlayer->getFuelMax()?>)</small>
    <div class="progress alert radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getFuel() / $MasterShipPlayer->getFuelMax() * 100)?>%"></span></div>

    Load <small>(<?php echo round($MasterShipPlayer->getLoad())?> / <?php echo $MasterShipPlayer->getLoadMax()?>)</small>
    <div class="progress success radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getLoad() / $MasterShipPlayer->getLoadMax() * 100)?>%"></span></div>

    <a class="button tiny secondary" >Speed <?php echo $MasterShipPlayer->getSpeed()?></a>
    <a class="button tiny" ><?php echo $MasterShipPlayer->getTechs()?> techs </a>

</div>
