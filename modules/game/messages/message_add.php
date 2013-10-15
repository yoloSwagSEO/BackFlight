<?php
$array = array('message_text');
if (!empty($_POST['conversation_id'])) {
    $Conversation = new Conversation($_POST['conversation_id']);
    if (!$Conversation->isSql()) {
        exit('Unknown conversation');
    }
} else {
    $new = true;
    $array[] = 'message_user';
    $array[] = 'message_subject';
}

saveSessions($array);

if (!check($array)) {
    if ($new) {
        header('location: '.PATH.'messages/new');
    } else {
        header('location: '.PATH.'messages/new');
    }
    exit;
}

$ToUser = new User($_POST['message_user'], 'pseudo');

if (!$ToUser->isSql()) {
    $_SESSION['errors']['messages']['player'] = 'unknown';
    header('location: '.PATH.'messages/new');
    exit;
}

if (empty($_POST['conversation_id'])) {
    $Conversation = new Conversation();
    $Conversation->setSubject(strip_tags($_POST['message_subject']));
    $Conversation->setDate(time());
    $Conversation->save();
    $Conversation->addUser($ToUser->getId());
    $Conversation->addUser($User->getId());
}

$Message = new Message();
$Message->setContent(strip_tags($_POST['message_text']));
$Message->setConversationId($Conversation->getId());
$Message->setDate(time());
$Message->setUserFrom($User->getId());
$Message->save();

cleanSessions($array);
header('location: '.PATH.'messages/conversation-'.$Conversation->getId().'#'.$Message->getId());
exit;

?>
