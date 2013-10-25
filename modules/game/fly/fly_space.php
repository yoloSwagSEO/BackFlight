<?php
$type = 'flight';
if (!empty($_GET['speed'])) {
    if ($_GET['speed'] === 'jump') {
        $type = 'jump';
    }
}

// Is ship already flying ?
if ($MasterShipPlayer->getState() == 'flying') {
    exit('Ship already flying !');
}

// Is ship damaged ?
if ($MasterShipPlayer->isShipDamaged()) {
    exit('Ship is damaged. Repair it or wait');
}


$PositionCurrent = new Position($MasterShipPlayer->getPositionId());

$array_positions_knowns = Position::getKnownFor($User->getId());

$PositionDestination = $PositionCurrent->determineDestination($type, $array_positions_knowns);

$distance = Position::calculateDistance($PositionCurrent->getX(), $PositionCurrent->getY(), $PositionDestination->getX(), $PositionDestination->getY());
$time = $MasterShipPlayer->calculateTravelTime($distance, $type);

$energy = $MasterShipPlayer->calculateTravelEnergy($distance, $type);
$fuel = $MasterShipPlayer->calculateTravelFuel($distance, $type);


if ($energy > $MasterShipPlayer->getEnergy() || $fuel > $MasterShipPlayer->getFuel()) {
    exit('Unsufficiant resources');
}



$Action = new Action();
$Action->setFrom($PositionCurrent->getId());
$Action->setTo($PositionDestination->getId());
$Action->setDuration($time);
$Action->setType($type);
$Action->setUser($User->getId());
$Action->setDistance($distance);

$id_move = $Action->save();

// Creating fleet
$Fleet = new Fleet();
$Fleet->setActionId($id_move);
$Fleet->addShip($MasterShipPlayer->getId());
$Fleet->setUserId($User->getId());
$Fleet->save();

// Let's go
$Action->start();
$Fleet->takeOff($energy, $fuel);


//exit;
header('location: '.PATH.'overview');
exit;



?>
