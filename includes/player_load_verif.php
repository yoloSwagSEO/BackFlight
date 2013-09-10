<?php
$MasterShipPlayer = new Ship('master', $User->getId());

// If the player has no master ship, we create it
if (!$MasterShipPlayer->isSql()) {
    echo '<div data-alert="" class="alert-box radius">No master ship for user.</div>';
    $MasterShipPlayer = new Ship();
    
    // Get a position for the player to begin
    $startPosition = Position::getClearPosition();
    if ($startPosition) {
        echo '<div data-alert="" class="alert-box radius">Ship position : '.$startPosition->getX().'.</div>';
    }
    
    
}