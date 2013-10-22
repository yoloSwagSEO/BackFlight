<?php
if (empty($_POST['object_quantity'])) {
    exit('No quantities passed');
}

$array_weapons = Object::getAll('', '', $User->getId());

$array_weapons_post = $_POST['object_quantity'];
$array_weapons_use = array();
$type = '';
foreach ($array_weapons_post as $objectId => $quantity)
{
    if ($quantity > 0) {
        if (empty($array_weapons[$objectId])) {
            exit('Unknown object');
        }

        $ObjectWeapon = $array_weapons[$objectId];

        if (empty($type)) {
            $type = $ObjectWeapon->getObjectType();
        } else {
            if ($type != $ObjectWeapon->getObjectType()) {
                exit('Can\'t use torpedoes and mines together');
            }
        }


        // Check for availability
        if (!$MasterShipPlayer->hasObjectAvailable('weapon', $ObjectWeapon->getId())) {
            exit('No object on board');
        }

        $quantity = $MasterShipPlayer->getObject('weapons', $ObjectWeapon->getId());
        if ($quantity < $array_weapons_post[$ObjectWeapon->getId()]) {
            exit('Not so much objects onboard');
        }

        $array_weapons_use[$ObjectWeapon->getId()] = $ObjectWeapon;
    }
}