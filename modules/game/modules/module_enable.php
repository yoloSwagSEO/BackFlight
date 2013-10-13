<?php
if (!empty($_POST['moduleId'])) {
    $Module = new Module($_POST['moduleId']);
    if (!$Module->isSql()) {
        exit('Unknown module');
    }
} else {
    exit('No module');
}

// Is this module available on ship ?
if ($MasterShipPlayer->getModulesEnabledNumber() >= $MasterShipPlayer->getModulesMax()) {
    exit('Already max module number enabled');
}

if ($MasterShipPlayer->hasModuleAvailable($Module->getId())) {
    Quest::addAction($array_quests_player, 'module_enabled', 1, $User->getId(), $Module->getId());
    $MasterShipPlayer->enableModule($Module->getId());

} else {
    exit('Module not available');
}


exit();

?>
