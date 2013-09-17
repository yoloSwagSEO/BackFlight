<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_moves = Move::getAll('', '', $User->getId(), 'flying');

if (!empty($array_moves)) {
    foreach ($array_moves as $i => $Move)
    {
        if ($Move->countRemainingTime() < 0) {
            $Move->land();
            unset($array_moves[$i]);
        }
    }
}



$array_ships = Ship::getAll('', '', $User->getId());
if (!empty($array_ships)) {
    foreach ($array_ships as $Ship)
    {
        $Ship->updateEnergy();
    }
}

?>
