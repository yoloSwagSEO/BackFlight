<?php
title('Messages');
head();


$array_conversations_date = array();
foreach ($array_conversations as $Conversation)
{
    $array_conversations_date[$Conversation->getLastDate()][] = $Conversation;
}
krsort($array_conversations_date);

?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Messages</h3>
        <div data-alert class="alert-box success radius">
            Cliquez sur une conversation pour l'ouvrir.
        </div>
        <p>
            <a href='messages/new'>Ecrire un nouveau message</a>
        </p>
        <?php
        if(!empty($array_conversations_date)) {
            ?>
            <table width="100%">
                <thead>
                    <tr>
                        <th>
                            Titre
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Joueurs
                        </th>
                    </tr>
                </thead>
            <?php
            foreach ($array_conversations_date as $conversations) {
                foreach($conversations as $Conversation)
                {
                    $class = '';
                    if (!$Conversation->isRead()) {
                        $class = ' class="notification_unread"';
                    }
                    ?>
                    <tr<?php echo $class?>>
                        <td><a href="messages/conversation-<?php echo $Conversation->getId()?>"><?php echo $Conversation->getSubject()?></a></td>
                        <td><a href="messages/conversation-<?php echo $Conversation->getId()?>"><?php echo date('d/m - h:i', $Conversation->getLastDate())?></a></td>
                        <td>
                            <a href="messages/conversation-<?php echo $Conversation->getId()?>">
                                <?php
                                $i = 0;
                                $len = count($Conversation->getUsers());
                                foreach ($Conversation->getUsers(true) as $id => $userPseudo)
                                {
                                    if ($i == $len - 1) {
                                        echo ' et ';
                                    } else if ($i != 0) {
                                        echo ', ';
                                    }
                                    echo $userPseudo;
                                    $i++;
                                }
                                ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </table>
        <?php
        } else {
            ?>
        <p>
            Aucune conversation
        </p>
            <?php
        }
        ?>

<?php
foot();
?>

