<?php
$Message = new Message($_POST['messageId'], $User->getId());
if (!$Message->isSql()) {
    exit('Unknown message');
}

if (!$Message->isRead()) {
    $Message->read($User->getId());
    exit('ok');
}


?>
