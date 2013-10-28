<?php
// Modules and Objects initialization
$array_modules = Module::getAll('', '', $User->getId());
$array_objects = Object::getAll('', '', $User->getId());

$array_weapons = $MasterShipPlayer->getObjects('weapons');
$array_weapons_user = array();
foreach ($array_weapons as $objectId => $quantity)
{
    $ObjectWeapon = $array_objects[$objectId];
    $array_weapons_user[$ObjectWeapon->getObjectType()][$objectId] = $quantity;
}

// Sanitize the quantity input
$quantity = preg_replace("[^0-9]", "", $_POST['quantity']);

if (isset($_POST['type'])) {
    $type = $_POST['type'];
} else {
    header('location: '.PATH.'cargo');
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}


// Define max value
if ($type == 'fuel') {
    $max = number_format($MasterShipPlayer->getFuel());
} else if ($type == 'techs') {
    $max = number_format($MasterShipPlayer->getTechs());
} else if ($type == 'module') {
    $modules = $MasterShipPlayer->getModules();
    $max = $modules[$id];
} else if ($type == 'weapon') {
    $max = $array_weapons_user[$_POST['subtype']][$id];
    // TODO : check the subtype input
} else {
    header('location: '.PATH.'cargo');
}

// If quantity < 0, quantity = 0
// If quantity > max, quantity = max
$quantity = max(min($max,$quantity),0);

// Save type and quantity for notification
if ($type == 'fuel') {
    $MasterShipPlayer->removeFuel($quantity);
    $name = 'fuel';
} else if ($type == 'techs') {
    $MasterShipPlayer->removeTechs($quantity);
    $name = 'tech'. ($quantity>1?'s':'');
} else if ($type == 'module' || $type == 'weapon') {
    for ($i = 0; $i < $quantity ; $i++) {
        $MasterShipPlayer->useObject($type, $id);
        // Currently not working for Modules ??
    }
    if ($type == 'module') {
        $name = 'module'.($quantity>1?'s':'');
    } else {
        $name = $_POST['subtype'];
        // TODO : get the real name and check the input
    }
}

$_SESSION['infos']['drop']['type'] = $name;
$_SESSION['infos']['drop']['quantity'] = $quantity;


// Drop ressources and save
// $MasterShipPlayer->save();

// Exit.
// header('location: '.PATH.'cargo');
// exit;
