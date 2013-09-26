<?php
$MasterShipPlayer = new Ship('master', $User->getId());

// If the player has no master ship, we create it
if (!$MasterShipPlayer->isSql()) {
    echo '<div data-alert="" class="alert-box radius">No master ship for user.</div>';
    $MasterShipPlayer = new Ship('master', $User->getId());
    
    // Get a position for the player to begin
    $StartPosition = Position::getClearPosition();
    if ($StartPosition) {
        echo '<div data-alert="" class="alert-box radius">Ship position : '.$StartPosition->getX().':'.$StartPosition->getY().'.</div>';
    }

    $MasterShipPlayer->setPosition($StartPosition);
    $MasterShipPlayer->setType('master');
    $MasterShipPlayer->setModel(1);
    $MasterShipPlayer->setUserId($User->getId());
    $MasterShipPlayer->setState('space');
    $MasterShipPlayer->setFuel(SHIP_START_FUEL);
    $MasterShipPlayer->setTechs(SHIP_START_TECHS);
    $MasterShipPlayer->calculateLoad();
    $MasterShipPlayer->setPower(SHIP_START_POWER);
    $MasterShipPlayer->setEnergy(SHIP_START_ENERGY);


    $MasterShipPlayer->save();   
    
}

$array_ressources = Ressource::getAll('', '', $User->getId(), 'ship', $MasterShipPlayer->getId());
if (empty($array_ressources)) {
    $RessourceFuel = new Ressource();
    $RessourceFuel->setInto('ship');
    $RessourceFuel->setIntoId($MasterShipPlayer->getId());
    $RessourceFuel->setUserId($User->getId());

    $RessourceTechs = clone($RessourceFuel);
    $RessourceTechs->setType('techs');
    $RessourceFuel->setType('fuel');

    $RessourceFuel->setQuantity(60);
    $RessourceTechs->setQuantity(10);

    $RessourceFuel->save();
    $RessourceTechs->save();
}

