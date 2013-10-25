<?php
$HoldBasicModule = new Module();
$HoldBasicModule->setName('Bloc de soute');
$HoldBasicModule->setIntro('+25% chargement');
$HoldBasicModule->setDescription('En rajoutant un bloc de soute, vous pourrez doubler votre capacité de chargement !');
$HoldBasicModule->setType('load');
$HoldBasicModule->setWeight(20);
$HoldBasicModule->setLoad(1.25);
$HoldBasicModule->setOperation('multiply');
$HoldBasicModule->setCostEnergy(20);
$HoldBasicModule->setCostFuel(50);
$HoldBasicModule->setCostTechs(350);
$HoldBasicModule->setTime(150);
$HoldBasicModule->save();


$HullBasicModule = new Module();
$HullBasicModule->setName('Renforcement coque');
$HullBasicModule->setIntro('+30% vitalité');
$HullBasicModule->setDescription('Une meilleure structure pourra subir plus de dommages avant de provoquer une panne du vaisseau.');
$HullBasicModule->setType('power');
$HullBasicModule->setWeight(120);
$HullBasicModule->setPower(1.3);
$HullBasicModule->setOperation('multiply');
$HullBasicModule->setCostEnergy(10);
$HullBasicModule->setCostFuel(50);
$HullBasicModule->setCostTechs(200);
$HullBasicModule->setTime(100);
$HullBasicModule->save();


$BatteryBasicModule = new Module();
$BatteryBasicModule->setName('Batteries supplémentaires');
$BatteryBasicModule->setIntro('+30% énergie');
$BatteryBasicModule->setDescription('Avec de nouvelles batteries, l\'énergie pourra être stockée en plus grande quantités.');
$BatteryBasicModule->setType('energy');
$BatteryBasicModule->setWeight(15);
$BatteryBasicModule->setEnergy(1.3);
$BatteryBasicModule->setOperation('multiply');
$BatteryBasicModule->setCostEnergy(50);
$BatteryBasicModule->setCostFuel(8);
$BatteryBasicModule->setCostTechs(100);
$BatteryBasicModule->setTime(70);
$BatteryBasicModule->save();


$ReactorBoostBasicModule = new Module();
$ReactorBoostBasicModule->setName('Boost du réacteur');
$ReactorBoostBasicModule->setIntro('+35% vitesse');
$ReactorBoostBasicModule->setDescription('En augmentant la condensation du réacteur, la vitesse du vaisseau sera augmentée.');
$ReactorBoostBasicModule->setType('speed');
$ReactorBoostBasicModule->setWeight(20);
$ReactorBoostBasicModule->setSpeed(1.35);
$ReactorBoostBasicModule->setOperation('multiply');
$ReactorBoostBasicModule->setCostEnergy(25);
$ReactorBoostBasicModule->setCostFuel(40);
$ReactorBoostBasicModule->setCostTechs(90);
$ReactorBoostBasicModule->setTime(220);
$ReactorBoostBasicModule->save();

$ShieldBasicModule = new Module();
$ShieldBasicModule->setName('Renforcement du bouclier');
$ShieldBasicModule->setIntro('+60% bouclier');
$ShieldBasicModule->setDescription('Une meilleure protection des émetteurs de champs éléctromagnétiques du bouclier augmentera fortement son efficacité.');
$ShieldBasicModule->setType('shield');
$ShieldBasicModule->setWeight(20);
$ShieldBasicModule->setShield(1.6);
$ShieldBasicModule->setOperation('multiply');
$ShieldBasicModule->setCostEnergy(80);
$ShieldBasicModule->setCostFuel(50);
$ShieldBasicModule->setCostTechs(300);
$ShieldBasicModule->setTime(300);
$ShieldBasicModule->save();

$SolarBasicModule = new Module();
$SolarBasicModule->setName('Capteurs solaires');
$SolarBasicModule->setIntro('+40% gain énergie');
$SolarBasicModule->setDescription('En recouvrant une plus grande partie du vaisseau de capteurs solaires, celui-ci récupérera plus vite son énergie');
$SolarBasicModule->setType('energy');
$SolarBasicModule->setWeight(20);
$SolarBasicModule->setEnergyGain(1.4);
$SolarBasicModule->setOperation('multiply');
$SolarBasicModule->setCostEnergy(20);
$SolarBasicModule->setCostFuel(40);
$SolarBasicModule->setCostTechs(400);
$SolarBasicModule->setTime(280);
$SolarBasicModule->save();


$ModuleSlotModule = new Module();
$ModuleSlotModule->setName('Module supplémentaire');
$ModuleSlotModule->setIntro('+1 emplacement module');
$ModuleSlotModule->setDescription('L\'agrandissement des slots modules permet d\'ajouter plus de modules.');
$ModuleSlotModule->setType('module');
$ModuleSlotModule->setWeight(15);
$ModuleSlotModule->setModule(1);
$ModuleSlotModule->setOperation('add');
$ModuleSlotModule->setCostEnergy(50);
$ModuleSlotModule->setCostFuel(90);
$ModuleSlotModule->setCostTechs(800);
$ModuleSlotModule->setTime(500);
$ModuleSlotModule->save();