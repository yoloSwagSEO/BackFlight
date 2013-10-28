<div class="panel">
    <?php
        echo '<div data-alert="" class="alert-box radius">'.$MasterShipPlayer->getModelName().' ('.$MasterShipPlayer->getState().')<br />Position : '.$MasterShipPlayer->getPositionX().':'.$MasterShipPlayer->getPositionY().'</div>';
    ?>
    <span class="icomoon" data-icon="&#xe0d1;" style="margin: 0 5px"></span>
    <span data-tooltip title='Gain : <?php echo round($MasterShipPlayer->getEnergyGain() / 3600 * GAME_SPEED / 10, 2)?> power / s'>Power</span> <small>(<?php echo round($MasterShipPlayer->getPower())?> / <?php echo round($MasterShipPlayer->getPowerMax())?>)</small>
    <div class="progress success radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getPower() / $MasterShipPlayer->getPowerMax() * 100)?>%"></span></div>

    <span class="icomoon" data-icon="&#xe0af;" style="margin: 0 5px"></span>
    <span data-tooltip title='Gain : <?php echo round($MasterShipPlayer->getShieldGain() / 3600 * GAME_SPEED, 2)?> shield / s'>Shield</span> <small>(<?php echo round($MasterShipPlayer->getShield())?> / <?php echo round($MasterShipPlayer->getShieldMax())?>)</small>
    <div class="progress radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getShield() / $MasterShipPlayer->getShieldMax() * 100)?>%"></span></div>

    
    <span class="icomoon" data-icon="&#xe0b0;" style="margin: 0 5px"></span><span data-tooltip title='Gain : <?php echo round($MasterShipPlayer->getEnergyGain() / 3600 * GAME_SPEED, 2)?> energy / s'>Energy</span> <small>(<?php echo round($MasterShipPlayer->getEnergy())?> / <?php echo round($MasterShipPlayer->getEnergyMax())?>)</small>
    <div class="progress radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getEnergy() / $MasterShipPlayer->getEnergyMax() * 100)?>%"></span></div>

    <span class="icomoon" data-icon="&#xe0a4;" style="margin: 0 5px"></span>
    Fuel <small>(<?php echo round($MasterShipPlayer->getFuel())?> / <?php echo round($MasterShipPlayer->getFuelMax())?>)</small>
    <div class="progress alert radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getFuel() / $MasterShipPlayer->getFuelMax() * 100)?>%"></span></div>

    <span class="icomoon" data-icon="&#xe0a1;" style="margin: 0 5px"></span>
    Load <small>(<?php echo round($MasterShipPlayer->getLoad())?> / <?php echo round($MasterShipPlayer->getLoadMax())?>)</small>
    <a href="cargo"><div class="progress success radius "><span class="meter" style="width: <?php echo round($MasterShipPlayer->getLoad() / $MasterShipPlayer->getLoadMax() * 100)?>%"></span></div></a>



    <?php
    $class = 'secondary';
    $tip = '';
    $href = 'javascript:void(0)';
    if ($MasterShipPlayer->isShipDamaged()) {
        $class = 'alert has-tip';
        $tip = ' title="Votre vaisseau est trop endommagé pour voler. Réparez-le ou patientez." data-tooltip';
        $href = 'ship';
    }
    ?>

    <a class="button tiny <?php echo $class?>" <?php echo $tip ?> href="<?php echo $href?>">Speed <?php echo $MasterShipPlayer->getSpeed()?></a>
    <a class="button tiny" ><span class="icomoon" data-icon="&#xe08e;" style="margin-right: 5px"></span><?php echo number_format($MasterShipPlayer->getTechs())?> techs </a>

</div>
