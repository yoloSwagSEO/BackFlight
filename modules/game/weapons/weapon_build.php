<?php
if (!empty($_POST['weaponId'])) {
    $ObjectWeapon = new Object($_POST['weaponId']);
    if (!$ObjectWeapon->isSql()) {
        exit('Unknown weapon');
    }
} else {
    exit('Empty weapon');
}

// Check for ressources
if ($ObjectWeapon->getObjectCostEnergy() > $MasterShipPlayer->getEnergy() || $ObjectWeapon->getObjectCostFuel() > $MasterShipPlayer->getFuel() || $ObjectWeapon->getObjectCostTechs() > $MasterShipPlayer->getTechs()) {
    exit('Unsuffisant ressources');
}

// Get current modules build on ship
$end = Build::getTimeEndBuild('weapon', $User->getId(), 'ship', $MasterShipPlayer->getId());
if (!$end) {
    $end = time();
}

$queue = Build::getQueueFor('weapon', $ObjectWeapon->getId(), $User->getId(), 'ship', $MasterShipPlayer->getId());
$queue += 1;


$ModuleBuild = new Build();
$ModuleBuild->setType('weapon');
$ModuleBuild->setTypeId($ObjectWeapon->getId());
$ModuleBuild->setUserId($User->getId());
$ModuleBuild->setDestination('ship');
$ModuleBuild->setDestinationId($MasterShipPlayer->getId());
$ModuleBuild->setStart(time());
$ModuleBuild->setEnd($end + $ObjectWeapon->getObjectTime());

$ModuleBuild->save();

$MasterShipPlayer->removeTechs($ObjectWeapon->getObjectCostTechs());
$MasterShipPlayer->removeEnergy($ObjectWeapon->getObjectCostEnergy());
$MasterShipPlayer->removeFuel($ObjectWeapon->getObjectCostFuel());
$MasterShipPlayer->save();

if ($queue > 1) {
    $queue = '('.$queue.') ';
} else {
    $queue = '';
}

exit($queue.renderCountDown($end - time() + $ObjectWeapon->getObjectTime()));

?>
