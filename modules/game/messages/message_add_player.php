<?php
if (!empty($_POST['conversation_id'])) {
    $Conversation = new Conversation($_POST['conversation_id']);
    if (!$Conversation->isSql()) {
        exit('Unknown conversation');
    }
} else {
    exit('Unknown conversation');
}

$ToUser = new User($_POST['message_user'], 'pseudo');

if (!$ToUser->isSql()) {
    $_SESSION['errors']['messages']['player'] = 'unknown';
    header('location: '.PATH.'messages/new');
    exit;
}

$Conversation->addUser($ToUser->getId());

header('location: '.PATH.'messages/conversation-'.$Conversation->getId());
?>
