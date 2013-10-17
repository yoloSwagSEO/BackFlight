<?php
if (!empty($_POST['moduleId'])) {
    $Module = new Module($_POST['moduleId']);
    if (!$Module->isSql()) {
        exit('Unknown module');
    }
} else {
    exit('No module');
}


if ($MasterShipPlayer->hasObjectEnabled('module', $Module->getId())) {
    $MasterShipPlayer->disableObject('module', $Module->getId());
} else {
    exit('Module not available');
}
