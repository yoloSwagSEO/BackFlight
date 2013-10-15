<?php
title('Messages');
head();

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
        if(!empty($array_conversations)) {
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
            foreach ($array_conversations as $Conversations)
            {
                $class = '';
//                if (!$Conversations->isRead()) {
//                    $class = ' class="notification_unread"';
//                }
                ?>
                <tr<?php echo $class?>>
                    <td><a href="messages/conversation-<?php echo $Conversations->getid()?>"><?php echo $Conversations->getSubject()?></a></td>
                    <td><a href="messages/conversation-<?php echo $Conversations->getid()?>"><?php echo date('d/m - h:i', $Conversations->getDate())?></a></td>
                    <td><a href="messages/conversation-<?php echo $Conversations->getid()?>">n:n</a></td>
                </tr>
                <?php
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

