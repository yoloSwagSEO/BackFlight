<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_moves = Move::getAll('', '', $User->getId(), 'flying');


$CurrentPosition = new Position($MasterShipPlayer->getPositionId());

if (!empty($array_moves)) {
    foreach ($array_moves as $i => $Move)
    {
        if ($Move->countRemainingTime() < 0) {
            // Searches
            if ($Move->getType() == 'search' || $Move->getType() == 'probes') {
                $result = $CurrentPosition->searchRessources($Move->getType());
                $search_result = '';
                if (!empty($result)) {
                    $search_result = $result[0];
                    $MasterShipPlayer->calculateLoad();
                    if ($result[0] == 'fuel') {
                        $fuel_added = $MasterShipPlayer->addFuel($result[1]);
                        if ($fuel_added != $result[1]) {
                            $_SESSION['errors']['fuel']['lost'] = round($result[1] - $fuel_added);
                        }
                        $MasterShipPlayer->save();
                    } else {
                        $techs_added = $MasterShipPlayer->addTechs($result[1]);
                        if ($techs_added != $result[1]) {
                            $_SESSION['errors']['techs']['lost'] = round($result[1] - $techs_added);
                        }

                        $MasterShipPlayer->save();
                    }

                    $_SESSION['infos']['search'] = $result;
                } else {
                    $_SESSION['infos']['search'] = 'empty';
                }

                Position::addPositionSearch($Move->getTo(), $User->getId(), $Move->getEnd(), $search_result);

                // Ship damages
                if ($Move->getType() == 'search') {
                    if ($MasterShipPlayer->hasTouchAsteroids()) {
                        $damages = $MasterShipPlayer->getAsteroidsDamages();

                        // TODO : shield
                        $MasterShipPlayer->removePower($damages);
                    }
                }

            // Normal flight
            } else {
                Position::addUserPosition($User->getId(), $Move->getTo());
                $CurrentPosition = new Position($Move->getTo());
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