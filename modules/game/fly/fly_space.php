<?php
$type = 'flight';
if (!empty($_GET['speed'])) {
    if ($_GET['speed'] === 'fast') {
        $type = 'jump';
    }
}

// Is ship already flying ?
if ($MasterShipPlayer->getState() == 'flying') {
    exit('Ship already flying !');
}

$PositionCurrent = new Position($MasterShipPlayer->getPositionId());

$PositionDestination = $PositionCurrent->determineDestination(DESTINATION_EMPTY);
$time = 4 *60;
if ($type === 'jump') {
    $time = 30;
}


$Move = new Move();
$Move->setFrom($PositionCurrent->getId());
$Move->setTo($PositionDestination->getId());
$Move->setDuration($time);
$Move->setType($type);
$Move->setUser($User->getId());

$id_move = $Move->save();

// Creating fleet
$Fleet = new Fleet();
$Fleet->setMoveId($id_move);
$Fleet->addShip($MasterShipPlayer->getId());
$Fleet->setUserId($User->getId());
$Fleet->save();

// Let's go
$Move->start();
$Fleet->takeOff();
header('location: ../overview');
exit;



?>
