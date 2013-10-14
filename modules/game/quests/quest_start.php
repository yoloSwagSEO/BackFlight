<?php 
$Quest = new Quest($_GET['questId'], $User->getId());
if (!$Quest->isSql()) {
    exit('Unknown quest !');
}

if ($Quest->isStartedByPlayer()) {
    exit('Quest already started');
}

if ($Quest->isDoneByPlayer()) {
    exit('Quest already done');
}

$Quest->start($User->getId());

header('location: '.PATH.'observatory');