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
                $search_result_type = '';
                $search_result_quantity = 0;
                if (!empty($result)) {
                    $search_result_type = $result[0];
                    $search_result_quantity = $result[1];
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
                    
                    Position::addPositionSearch($Action->getTo(), $User->getId(), $Action->getEnd(), $search_result_type, $search_result_quantity);
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
    // If build has ended
    if ($Build->getEnd() <= time()) {
        $type = $Build->getType();

        // For modules and weapons
        if ($type == 'module' || $type == 'object') {
            $Build->setState('end');
            $MasterShipPlayer->addObject($Build->getType(), $Build->getTypeId());
            $Build->save();
        }
    }
}

// Load user objects for player (sent by / sent to)
$array_objects_user = ObjectUser::getAll('', '', $User->getId());
$array_torpedoes_user = array();

foreach ($array_objects_user as $ObjectUser)
{
    if ($ObjectUser->getObjectType() == 'torpedo') {
        $distance = Position::calculateDistance($ObjectUser->getObjectFromX(), $ObjectUser->getObjectFromY(), $ObjectUser->getPositionShipX(), $ObjectUser->getPositionShipY());
        if ($distance > $ObjectUser->getObjectRange() * POSITION_LENGHT) {
            $ObjectUser->destroy();
            exit('Ship has runaway');
        } else {
            $time_travel = $distance / $ObjectUser->getObjectSpeed();
            if ($ObjectUser->getObjectStart() + $time_travel <= time()) {
                if ($MasterShipPlayer->getId() == $ObjectUser->getObjectToId()) {
                    $Ship = $MasterShipPlayer;
                } else {
                    $Ship = new Ship($ObjectUser->getObjectToId());
                    $Ship->updateEnergy();
                    $Ship->updatePower();
                    $Ship->updateShield();
                    $Ship->setLastUpdate(time());
                    $Ship->save();
                }

                if ($ObjectUser->getObjectAttackType() == 'shield') {
                    $Ship->removeShield($ObjectUser->getObjectAttackPower());
                } else {
                    $Ship->removePower($ObjectUser->getObjectAttackPower());
                }

                $NotificationTarget = new Notification();
                $NotificationTarget->setAction('attack');
                $NotificationTarget->setTypeId(1);
                $NotificationTarget->setActionId($Ship->getId());
                $NotificationTarget->setActionType($ObjectUser->getObjectAttackType());
                $NotificationTarget->setDate($ObjectUser->getObjectStart() + $time_travel);
                $NotificationTarget->setImportance(NOTIFICATION_IMPORTANCE_HIGH);

                $NotificationLauncher = clone($NotificationTarget);
                $NotificationLauncher->setType('attack_done');
                $NotificationLauncher->setUserId($ObjectUser->getObjectUserId());
                $NotificationLauncher->setImportance(NOTIFICATION_IMPORTANCE_MEDIUM);
                $NotificationLauncher->setActionSub($Ship->getId());
                $NotificationLauncher->save();

                $NotificationTarget->setActionSub($ObjectUser->getObjectUserId());
                $NotificationTarget->setType('attack_received');
                $NotificationTarget->setUserId($Ship->getUserId());
                $NotificationTarget->save();

                $ObjectUser->destroy();

                $Ship->save();
            } else {
                $from = 'target';
                if ($ObjectUser->getObjectUserId() == $User->getId()) {
                    $from = 'launcher';
                }
                $array_torpedoes_user[$from][$ObjectUser->getId()] = $ObjectUser;
            }
        }
    }
}


// Load notifications
$array_notifications_unread = Notification::getAll('', '', NOTIFICATION_UNREAD, $User->getId());

// Load messages
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