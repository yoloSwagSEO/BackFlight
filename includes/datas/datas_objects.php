<?php
$BasicTorpedo = new Object();
$BasicTorpedo->setObjectType('torpedo');
$BasicTorpedo->setObjectName('Mini-torpille');
$BasicTorpedo->setObjectDescription('Ne vous fiez pas à sa taille, vous pourrez être très supris !');
$BasicTorpedo->setObjectTime(120);
$BasicTorpedo->setObjectRange(20);
$BasicTorpedo->setObjectSpeed(20);
$BasicTorpedo->setObjectAttackType('basic');
$BasicTorpedo->setObjectAttackPower(20);
$BasicTorpedo->setObjectWeight(5);
$BasicTorpedo->setObjectCostEnergy(4);
$BasicTorpedo->setObjectCostFuel(5);
$BasicTorpedo->setObjectCostTechs(80);
$BasicTorpedo->setObjectLaunchEnergy(2);
$BasicTorpedo->setObjectLaunchFuel(1);
$BasicTorpedo->save();

$ShieldBasicTorpedo = new Object();
$ShieldBasicTorpedo->setObjectType('torpedo');
$ShieldBasicTorpedo->setObjectName('Mini-torpille éléctromagnétique');
$ShieldBasicTorpedo->setObjectDescription('Désactivez le bouclier de vos adversaires en un clin d\'oeil');
$ShieldBasicTorpedo->setObjectTime(120);
$ShieldBasicTorpedo->setObjectRange(20);
$ShieldBasicTorpedo->setObjectSpeed(20);
$ShieldBasicTorpedo->setObjectAttackType('shield');
$ShieldBasicTorpedo->setObjectAttackPower(100);
$ShieldBasicTorpedo->setObjectWeight(5);
$ShieldBasicTorpedo->setObjectCostEnergy(10);
$ShieldBasicTorpedo->setObjectCostFuel(8);
$ShieldBasicTorpedo->setObjectCostTechs(150);
$ShieldBasicTorpedo->setObjectLaunchEnergy(4);
$ShieldBasicTorpedo->setObjectLaunchFuel(2);
$ShieldBasicTorpedo->save();


//$BasicMine = new Object();
//$BasicMine->setObjectType('mine');
//$BasicMine->setObjectName('Mine légère');
//$BasicMine->setObjectDescription('Idéal pour provoquer la colère de vos adversaires. Inutile pour le reste.');
//$BasicMine->setObjectTime(120);
//$BasicMine->setObjectAttackType('basic');
//$BasicMine->setObjectAttackPower(20);
//$BasicMine->setObjectWeight(8);
//$BasicMine->setObjectCostEnergy(4);
//$BasicMine->setObjectCostFuel(4);
//$BasicMine->setObjectCostTechs(80);
//$BasicMine->setObjectLaunchEnergy(1);
//$BasicMine->setObjectLaunchFuel(1);
//$BasicMine->save();
//
//$BasicShieldMine = new Object();
//$BasicShieldMine->setObjectType('mine');
//$BasicShieldMine->setObjectName('Mine légère éléctromagnétique');
//$BasicShieldMine->setObjectDescription('Qui s\'y frotte y perdra son bouclier');
//$BasicShieldMine->setObjectTime(120);
//$BasicShieldMine->setObjectAttackType('shield');
//$BasicShieldMine->setObjectAttackPower(100);
//$BasicShieldMine->setObjectWeight(10);
//$BasicShieldMine->setObjectCostEnergy(8);
//$BasicShieldMine->setObjectCostFuel(4);
//$BasicShieldMine->setObjectCostTechs(150);
//$BasicShieldMine->setObjectLaunchEnergy(1);
//$BasicShieldMine->setObjectLaunchFuel(1);
//$BasicShieldMine->save();
?>
