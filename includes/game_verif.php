<?php
if (GAME_AUTOCREATE_DATAS) {
    // Modules
    $array_modules = Module::getAll();

    // If there's no module, we have to create them
    if (empty($array_modules)) {
        include_once 'includes/datas/datas_modules.php';

    }


    // Models
    $array_models = Model::getAll();

    // If there's no model, we have to create one
    if (empty($array_models)) {
        $Model = new Model();
        $Model->setName('Survivor');
        $Model->setCategory('mastership');
        $Model->setType('');
        $Model->setModulesMax(3);
        $Model->setLoadMax(1000);
        $Model->setEnergyMax(100);
        $Model->setEnergyGain(100);
        $Model->setFuelMax(100);
        $Model->setPowerMax(100);
        $Model->setSpeed(10);
        $Model->setShieldGain(300);
        $Model->setShieldMax(80);
        $Model->save();
    }


    // Quests
    $array_quests = Quest::getAll();
    if (empty($array_quests)) {
        include_once 'includes/datas/datas_quests.php';
    }
}
?>