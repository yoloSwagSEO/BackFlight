<?php
if (!empty($_POST['moduleId'])) {
    $Module = new Module($_POST['moduleId']);
    if (!$Module->isSql()) {
        exit('Unknown module');
    }
} else {
    exit('Empty module');
}

// Check for ressources
if ($Module->getCostEnergy() > $MasterShipPlayer->getEnergy() || $Module->getCostFuel() > $MasterShipPlayer->getFuel() || $Module->getCostTechs() > $MasterShipPlayer->getTechs()) {
    exit('Unsuffisant ressources');
}

if ($MasterShipPlayer->getFreeLoad() < $Module->getObjectWeight()) {
    exit('Too much load');
}

// Get current modules build on ship
$end = Build::getTimeEndBuild('module', $User->getId(), 'ship', $MasterShipPlayer->getId());
if (!$end) {
    $end = time();
}

$queue = Build::getQueueFor('module', $Module->getId(), $User->getId(), 'ship', $MasterShipPlayer->getId());
$queue += 1;


$ModuleBuild = new Build();
$ModuleBuild->setType('module');
$ModuleBuild->setTypeId($Module->getId());
$ModuleBuild->setUserId($User->getId());
$ModuleBuild->setDestination('ship');
$ModuleBuild->setDestinationId($MasterShipPlayer->getId());
$ModuleBuild->setStart(time());
$ModuleBuild->setEnd($end + $Module->getTime());

$ModuleBuild->save();

$MasterShipPlayer->removeTechs($Module->getCostTechs());
$MasterShipPlayer->removeEnergy($Module->getCostEnergy());
$MasterShipPlayer->removeFuel($Module->getCostFuel());
$MasterShipPlayer->save();

if ($queue > 1) {
    $queue = '('.$queue.') ';
} else {
    $queue = '';
}

exit($queue.renderCountDown($end - time() + $Module->getTime()));

?>
