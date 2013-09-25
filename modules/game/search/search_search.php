<?php
$type = 'search';
$time = 30 / GAME_SPEED;
$energy = 3;
$fuel = 1;

if (!empty($_GET['speed'])) {
    if ($_GET['speed'] === 'probes') {
        $type = 'probes';
        $time = 4 * 30 / GAME_SPEED;
        $energy = 6;
        $fuel = 0;
    }
}

// Is ship already flying ?
if ($MasterShipPlayer->getState() == 'flying') {
    exit('Ship already flying !');
}

$PositionCurrent = new Position($MasterShipPlayer->getPositionId());

$Move = new Move();
$Move->setFrom($PositionCurrent->getId());
$Move->setTo($PositionCurrent->getId());
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
$Fleet->takeOff($energy, $fuel);

//exit;
header('location: '.PATH.'overview');
exit;
