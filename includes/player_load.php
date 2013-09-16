<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_moves = Move::getAll('', '', $User->getId(), 'flying');

if (!empty($array_moves)) {
    foreach ($array_moves as $Move)
    {
        if ($Move->countRemainingTime() < 0) {
            $Move->land();
        }
    }
}

?>
