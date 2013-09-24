<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_moves = Move::getAll('', '', $User->getId(), 'flying');

if (!empty($array_moves)) {
    foreach ($array_moves as $i => $Move)
    {
        if ($Move->countRemainingTime() < 0) {
            
            if ($Move->getType() == 'search' || $Move->getType() == 'probes') {
                $result = Position::searchRessources($Move->getTo(), $Move->getType());
                if (!empty($result)) {
                    if ($result[0] == 'fuel') {
                        $MasterShipPlayer->addFuel($result[1]);
                        $MasterShipPlayer->save();
                    } else {
                        $MasterShipPlayer->addTechs($result[1]);
                        $MasterShipPlayer->save();
                    }
                }

            } else {
                Position::addUserPosition($User->getId(), $Move->getTo());
            }

            
            $Move->land();


            unset($array_moves[$i]);
        }
    }
}

$array_ships = Ship::getAll('', '', $User->getId());
if (!empty($array_ships)) {
    foreach ($array_ships as $Ship)
    {
        if ($Ship->getId() === $MasterShipPlayer->getId()) {
            $MasterShipPlayer = $Ship;
        }
        $Ship->updateEnergy();        
    }
}

?>