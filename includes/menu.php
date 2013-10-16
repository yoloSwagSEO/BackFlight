<?php
$nb_conversation_unread = 0;

foreach ($array_conversations as $mConversation)
{
    if (!$mConversation->isRead()) {
        $nb_conversation_unread++;
    }
}

$menu_add = '';
if ($nb_conversation_unread) {
    $menu_add = ' ('.$nb_conversation_unread.')';
}

?>

<ul class="side-nav">
    <li><a href="overview">Ma position</a></li>
    <li><a href="messages">Messages<?php echo $menu_add?></a></li>
    <li><a href="observatory">Observatoire</a></li>
    <li><a href="quests">Quêtes</a></li>
    <li><a href="ship">Vaisseau</a></li>
</ul>