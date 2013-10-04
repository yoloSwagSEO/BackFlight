<?php
$array_modules = Module::getAll();

// If there's no module, we have to create them
if (empty($array_modules)) {
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
}

?>
