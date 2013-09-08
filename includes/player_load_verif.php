<?php
$MasterShipPlayer = new Ship('master', $Player->getId());

// If the player has no master ship, we create it
if (!$MasterShipPlayer->isSql()) {
    $MasterShipPlayer = new Ship();
    
    // Get a position for the player to begin
    $startPosition = Position::getClearPosition();
    
    
}