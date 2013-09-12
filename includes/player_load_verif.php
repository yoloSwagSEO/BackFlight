<?php
$MasterShipPlayer = new Ship('master', $User->getId());

// If the player has no master ship, we create it
if (!$MasterShipPlayer->isSql()) {
    echo '<div data-alert="" class="alert-box radius">No master ship for user.</div>';
    $MasterShipPlayer = new Ship('master', $User->getId());
    
    // Get a position for the player to begin
    $startPosition = Position::getClearPosition();
    if ($startPosition) {
        echo '<div data-alert="" class="alert-box radius">Ship position : '.$startPosition->getX().':'.$startPosition->getY().'.</div>';
    }

    $MasterShipPlayer->setPosition($startPosition);
    $MasterShipPlayer->setType('master');
    $MasterShipPlayer->setModel(1);
    $MasterShipPlayer->setUserId($User->getId());
    $MasterShipPlayer->setState('flying');
    $MasterShipPlayer->save();
    
    
} else {
    echo '<div data-alert="" class="alert-box radius">MasterShip ('.$MasterShipPlayer->getModelName().') position : '.$MasterShipPlayer->getPositionX().':'.$MasterShipPlayer->getPositionY().'</div>';
}