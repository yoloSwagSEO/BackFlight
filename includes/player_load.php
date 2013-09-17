<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_moves = Move::getAll('', '', $User->getId(), 'flying');
$array_ships = Ship::getAll('', '', $User->getId());

if (!empty($array_moves)) {
    foreach ($array_moves as $Move)
    {
        if ($Move->countRemainingTime() < 0) {
            $Move->land();
        }
    }
}

if (!empty($array_ships)) {
    foreach ($array_ships as $Ship)
    {
        $Ship->updateEnergy();
    }
}

?>
