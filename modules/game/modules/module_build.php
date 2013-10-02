<?php
if (!empty($_POST['moduleId'])) {
    $Module = new Module($_POST['moduleId']);
    if (!$Module->isSql()) {
        exit('Unknown module');
    }
}


// Check for ressources
if ($Module->getCostEnergy() > $MasterShipPlayer->getEnergy() || $Module->getCostFuel() > $MasterShipPlayer->getFuel() || $Module->getCostTechs() > $MasterShipPlayer->getTechs()) {
    exit('Unsuffisant ressources');
}

$ModuleBuild = new Build();
$ModuleBuild->setType('module');
$ModuleBuild->setTypeId($Module->getId());
$ModuleBuild->setUserId($User->getId());
$ModuleBuild->setDestination('ship');
$ModuleBuild->setDestinationId($MasterShipPlayer->getId());
$ModuleBuild->setStart(time());
$ModuleBuild->setEnd(time() + $Module->getTime());
$ModuleBuild->save();

?>
