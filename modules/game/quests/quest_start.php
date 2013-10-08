<?php 
$Quest = new Quest($_GET['questId'], $User->getId());
if (!$Quest->isSql()) {
    exit('Unknown quest !');
}

if ($Quest->isStartedByPlayer()) {
    exit('Quest already started');
}

$Quest->start($User->getId());