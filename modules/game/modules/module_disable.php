<?php
if (!empty($_POST['moduleId'])) {
    $Module = new Module($_POST['moduleId']);
    if (!$Module->isSql()) {
        exit('Unknown module');
    }
} else {
    exit('No module');
}


if ($MasterShipPlayer->hasModuleEnabled($Module->getId())) {
    $MasterShipPlayer->disableModule($Module->getId());
} else {
    exit('Module not available');
}
