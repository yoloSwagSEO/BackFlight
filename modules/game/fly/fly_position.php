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

$PositionCurrent = new Position($MasterShipPlayer->getPositionId());

$PositionDestination = new Position($_GET['x'], $_GET['y']);
if (!$PositionDestination->isSql()) {
    exit('Unknown position');
}

if (!$PositionDestination->isKnownBy($User->getId())) {
    exit('You have never visited this position');
}

var_dump($PositionDestination);
exit;

$distance = Position::calculateDistance($PositionCurrent->getX(), $PositionCurrent->getY(), $PositionDestination->getX(), $PositionDestination->getY());
$time = $MasterShipPlayer->calculateTravelTime($distance, $type);

$energy = $MasterShipPlayer->calculateTravelEnergy($distance, $type);
$fuel = $MasterShipPlayer->calculateTravelFuel($distance, $type);


$Action = new Action();
$Action->setFrom($PositionCurrent->getId());
$Action->setTo($PositionDestination->getId());
$Action->setDuration($time);
$Action->setType($type);
$Action->setUser($User->getId());

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
