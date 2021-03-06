<?php
$type = 'search';
$fuel = 1;

if (!empty($_GET['speed'])) {
    if ($_GET['speed'] === 'probes') {
        $type = 'probes';
    }
}

$time = $MasterShipPlayer->getSearchTime($type, $CurrentPosition->getCategory());
$energy = $MasterShipPlayer->getSearchEnergy($type);
$fuel = $MasterShipPlayer->getSearchFuel($type);

// Is ship already flying ?
if ($MasterShipPlayer->getState() == 'flying') {
    exit('Ship already flying !');
}

// Is ship damaged ?
if ($MasterShipPlayer->isShipDamaged()) {
    exit('Ship is damaged. Repair it or wait');
}

if ($fuel > $MasterShipPlayer->getFuel())
{
    $_SESSION['errors']['search']['fuel_missing'] = true;
    header('location: '.PATH.'observatory');
    exit;
}

if ($energy > $MasterShipPlayer->getEnergy()) {
    $_SESSION['errors']['search']['energy_missing'] = true;
    header('location: '.PATH.'observatory');
    exit;
}



$Action = new Action();
$Action->setFrom($CurrentPosition->getId());
$Action->setTo($CurrentPosition->getId());
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
