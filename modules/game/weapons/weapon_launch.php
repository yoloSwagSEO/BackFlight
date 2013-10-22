<?php
include_once 'modules/game/weapons/weapons_check_post.php';

if ($type == 'torpedo') {
    if (empty($_POST['attack_mode'])) {
        exit('No type for attack passed');

    } else if ($_POST['attack_mode'] == 'auto') {
        $attack_mode = 'auto';

    } else {
        exit('This attack type isn\'t enabled');
        $attack_mode = 'user';
    }
    
    if (empty($_POST['launch_direction'])) {
        exit('No type for attack passed');

    } else if ($_POST['launch_direction'] == 'front') {
        $attack_direction = 'front';

    } else {
        $attack_direction = 'behind';
    }   

    if (empty($_POST['launch_mode'])) {
        exit('No mode for launch passed');

    } else if ($_POST['launch_mode'] == 'all') {
        $launch_mode = 'all';
        
    } else {
        $launch_mode = 'wave';
    }
}

$time = time();

if ($type == 'torpedo') {
    $state = 'flying';
} else {
    $state = 'armed';
}

foreach ($array_weapons_use as $ObjectWeapon)
{
    for ($i = 0; $i < $array_weapons_post[$ObjectWeapon->getId()]; $i++)
    {
        $ObjectUser = new ObjectUser();
        $ObjectUser->setObjectType($ObjectWeapon->getObjectType());
        $ObjectUser->setObjectModel($ObjectWeapon->getId());
        $ObjectUser->setObjectUserId($User->getId());
        $ObjectUser->setObjectFrom('ship');
        $ObjectUser->setObjectFromId($CurrentPosition->getId());
        $ObjectUser->setObjectTo('space');
        $ObjectUser->setObjectStart($time);
        $ObjectUser->setObjectState($state);
        $ObjectUser->save();

        $MasterShipPlayer->useObject('weapon', $ObjectWeapon->getId());
        
        if ($launch_mode == 'wave') {
            $time++;
        }
    }
}

header('location: '.PATH);
exit;






?>
