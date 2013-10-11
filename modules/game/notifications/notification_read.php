<?php
$Notification = new Notification($_GET['read']);
if (!$Notification->isSql()) {
    exit('Unknown notification');
}

if ($Notification->getUserId() != $User->getId()) {
    exit('Not your notification');
}

$Notification->setRead(NOTIFICATION_READ);
$Notification->save();

if (isset($_GET['all'])) {
    header('location: '.PATH.'notifications/all');
} else {
    header('location: '.PATH.'notifications');
}
exit;

?>
