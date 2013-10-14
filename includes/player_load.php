<?php
$array_fleets = Fleet::getAll('', '', $User->getId());
$array_actions = Action::getAll('', '', $User->getId(), 'current');

// Load quests
$array_quests_player = Quest::getAll('', '', null, $User->getId(), 'player');

$CurrentPosition = new Position($MasterShipPlayer->getPositionId());

if (!empty($array_actions)) {
    foreach ($array_actions as $i => $Action)
    {
        if ($Action->countRemainingTime() < 0) {
            // Searches
            if ($Action->getType() == 'search' || $Action->getType() == 'probes') {
                $result = $CurrentPosition->searchRessources($Action->getType(), $CurrentPosition->getCategory());
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
                    
                    Position::addPositionSearch($Action->getTo(), $User->getId(), $Action->getEnd(), $search_result);
                    $_SESSION['infos']['search'] = $result;

                    // For quests
                    Quest::addAction($array_quests_player, 'searches', 1, $User->getId());

                } else {
                    $_SESSION['infos']['search'] = 'empty';
                }

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

// Load all ships
$array_ships = Ship::getAll('', '', $User->getId());
if (!empty($array_ships)) {
    foreach ($array_ships as $Ship)
    {
        if ($Ship->getId() === $MasterShipPlayer->getId()) {
            $MasterShipPlayer = $Ship;
        }
        $Ship->updateEnergy();
        $Ship->updatePower();
        if ($Ship->isOverloaded()) {
            $Ship->setSpeed($Ship->getSpeed() / SHIP_SPEED_OVERLOADED);
        }
        $Ship->updateShield();
        $Ship->setLastUpdate(time());
        $Ship->save();
    }
}

// Load builds and create objects if necessary
$array_builds = Build::getAll('', '', $User->getId());
foreach ($array_builds as $Build)
{
    if ($Build->getType() == 'module') {
        if ($Build->getEnd() <= time()) {
            $Build->setState('end');
            $MasterShipPlayer->addModule($Build->getTypeId());
            $Build->save();
        }
    }
}

// Load notifications
$array_notifications_unread = Notification::getAll('', '', NOTIFICATION_UNREAD, $User->getId());

$array_conversations = Conversation::getAll('', '', $User->getId());

// Load MasterShip position
$MasterShipPosition = new Position($MasterShipPlayer->getPositionId());

// Check for quests
foreach ($array_quests_player as $Quest)
{
    if ($Quest->isStartedByPlayer()) {
        $QuestStep = $Quest->getCurrentStep();
        if ($QuestStep) {
            // Validate step only on right position if it exists
            if ($QuestStep->getStepPositionId()) {
                if ($QuestStep->getStepPositionId() != $MasterShipPosition->getId()) {
                    continue;
                }
            }

            if ($QuestStep->hasAllRequirementsDone()) {
                $QuestStep->addUserStep($User->getId());
                $gains = $QuestStep->getStepGains();
                if ($gains) {
                    Quest::earnGains($gains, $MasterShipPlayer, $array_ressources, $array_modules);
                }
            }
        }

        // If quest is complete
        if ($Quest->hasAllStepsDone() && !$Quest->isDoneByPlayer()) {
            if ($Quest->getPositionId()) {
                if ($Quest->getPositionId() != $MasterShipPosition->getId()) {
                    continue;
                }
            }
            // Get gains
            $gains = $Quest->getGains();
            if ($gains) {
                Quest::earnGains($gains, $MasterShipPlayer, $array_ressources, $array_modules);
            }
            $Quest->setUserState($User->getId(), 'done');
            $Quest->save();

            // Create notification
            $Notification = new Notification();
            $Notification->setType(TABLE_QUESTS);
            $Notification->setTypeId($Quest->getId());
            $Notification->setImportance(NOTIFICATION_IMPORTANCE_MEDIUM);
            $Notification->setAction('quest_done');
            $Notification->save();
        }
    }
}
?>