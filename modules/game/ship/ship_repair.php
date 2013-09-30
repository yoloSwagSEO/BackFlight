<?php
$power_diff = $MasterShipPlayer->getPowerMax() - $MasterShipPlayer->getPower();

$power_repair = SHIP_REPAIR_VALUE;
if ($power_repair > $power_diff) {
    $power_repair = $power_diff;
}

$energy_ratio =  $MasterShipPlayer->getEnergy() / SHIP_REPAIR_ENERGY;
$fuel_ratio =  $MasterShipPlayer->getFuel() / SHIP_REPAIR_FUEL;
$techs_ratio =  $MasterShipPlayer->getTechs() / SHIP_REPAIR_TECHS;
$power_ratio = $power_repair / SHIP_REPAIR_VALUE;

$power_repair_ratio = min($energy_ratio, $fuel_ratio, $techs_ratio, $power_ratio);

if ($power_repair_ratio < 0) {
    $_SESSION['erreurs']['ship']['repair'] = 'ressources_missing';
    header('location: '.PATH.'ship');
    exit;
}

$repair_energy = SHIP_REPAIR_ENERGY * $power_repair_ratio;
$repair_fuel = SHIP_REPAIR_FUEL * $power_repair_ratio;
$repair_techs = SHIP_REPAIR_TECHS * $power_repair_ratio;

$MasterShipPlayer->removeEnergy($repair_energy);
$MasterShipPlayer->removeFuel($repair_fuel);
$MasterShipPlayer->removeTechs($repair_techs);

$MasterShipPlayer->save();

// Is ship already flying ?
if ($MasterShipPlayer->isBusy()) {
    exit('Ship already occupied !');
}

$PositionCurrent = new Position($MasterShipPlayer->getPositionId());

$time = SHIP_REPAIR_TIME / GAME_SPEED * $power_repair_ratio;

$Action = new Action();
$Action->setFrom($PositionCurrent->getId());
$Action->setTo($PositionCurrent->getId());
$Action->setDuration($time);
$Action->setType('repair');
$Action->setUser($User->getId());

$id_action = $Action->start();

$Fleet = new Fleet();
$Fleet->setActionId($id_action);
$Fleet->addShip($MasterShipPlayer->getId());
$Fleet->setUserId($User->getId());
$Fleet->save();

$Fleet->start('repairing');

header('location: '.PATH.'ship');
exit;
?>
