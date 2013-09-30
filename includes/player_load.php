<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_actions = Action::getAll('', '', $User->getId(), 'current');


$CurrentPosition = new Position($MasterShipPlayer->getPositionId());

if (!empty($array_actions)) {
    foreach ($array_actions as $i => $Action)
    {
        if ($Action->countRemainingTime() < 0) {
            // Searches
            if ($Action->getType() == 'search' || $Action->getType() == 'probes') {
                $result = $CurrentPosition->searchRessources($Action->getType());
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

                Position::addPositionSearch($Action->getTo(), $User->getId(), $Action->getEnd(), $search_result);

            } else if ($Action->getType() == 'repair') {
                $repair_diff = $MasterShipPlayer->getLastUpdateDiff();
                $repair_ratio = $repair_diff * GAME_SPEED / SHIP_REPAIR_TIME;

                $repair = SHIP_REPAIR_VALUE * $repair_ratio;
                if ($repair_ratio > 1) {
                    $repair_ratio = 1;
                }

                $MasterShipPlayer->addPower($repair);
                $MasterShipPlayer->setLastUpdate(time());
                $MasterShipPlayer->save();

            // Normal flight
            } else {
                Position::addUserPosition($User->getId(), $Action->getTo());
                $CurrentPosition = new Position($Action->getTo());
            }

            // Ship damages
            if ($Action->getType() == 'search' || $Action->getType() == 'flight') {
                if ($MasterShipPlayer->hasTouchAsteroids($Action->getType())) {
                    $damages = $MasterShipPlayer->getAsteroidsDamages($Action->getType());

                    // TODO : shield
                    $MasterShipPlayer->removePower($damages);
                    $MasterShipPlayer->save();

                    $_SESSION['infos']['flight']['damages'] = $damages;
                }
            }

            $Action->land();


            unset($array_actions[$i]);
        } else {
            if ($Action->getType() == 'repair') {
                $repair_diff = $MasterShipPlayer->getLastUpdateDiff();
                $repair_ratio = $repair_diff * GAME_SPEED / SHIP_REPAIR_TIME;

                if ($repair_ratio > 1) {
                    $repair_ratio = 1;
                }

                $repair = SHIP_REPAIR_VALUE * $repair_ratio;
                
                $MasterShipPlayer->addPower($repair);
                $MasterShipPlayer->setLastUpdate(time());
                $MasterShipPlayer->save();
            }
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
        $Ship->updatePower();
        $Ship->setLastUpdate(time());
        $Ship->save();
    }
}

?>