<?php
$Conversation = new Conversation($_GET['conversation'], $User->getId());
if (!$Conversation->isSql()) {
    exit('Unknown conversation');
}

$array_messages = $Conversation->getMessages();

foreach ($Conversation->getUsersDate() as $userPseudo => $userDate)
{
    if ($userDate != $Conversation->getDate()) {
        $array_messages[$userDate][] = $userPseudo;
    }
}

ksort($array_messages);

title('Conversation');
head();

?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Conversation : <?php echo $Conversation->getSubject()?></h3>
        <p>
            Entre
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
        </p>
        <?php
        foreach ($array_messages as $date => $messages)
        {
            foreach ($messages as $Message)
            {                // Adding player date
                if (!is_a($Message, 'message')) {
                    ?>
                <div class="row panel radius" style="margin-bottom: 5px;">
                    <div class="large-2 columns">
                        <small><?php echo date('d/m H:i', $date)?></small>
                    </div>
                    <div class="large-10 columns">
                        <strong><?php echo $Message?></strong> rejoint la conversation
                    </div>
                </div>
                    <?php
                } else {
                    $data = '';
                    if (!$Message->isRead()) {
                        $data = ' data-unread="true"';
                    }
                    ?>
                <div class="row panel message radius" style="margin-bottom: 5px; position: relative;" data-message-id="<?php echo $Message->getId()?>"<?php echo $data?>>
                    <div class="large-2 columns">
                        <strong><?php echo $Message->getUserFrom(true)?></strong><br />
                        <small><?php echo date('d/m H:i', $Message->getDate())?></small>
                    </div>
                    <div class="large-10 columns">
                        <?php echo $Message->getContent()?>
                    </div>
                    <?php
                    if (!$Message->isRead()) {
                        ?><div class="message_unread"><span class="icomoon" data-icon="&#xe2d8;"></span></div><?php
                    }
                    ?>
                </div>
                    <?php
                }
                
            }
        }
        ?>

        <form action='messages/new' method='post'>
            <fieldset>
                <legend>Répondre</legend>
                <div class="row">
                    <div class="large-12 columns">
                        <label>Ma réponse</label>
                        <?php textarea('message_text', '', '', '', 'Mon message')?>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $Conversation->getId()?>" name="conversation_id" />
                <input type="submit" value="Envoyer mon message" class="button" />
            </fieldset>
        </form>
        <form action='messages/add-player' method='post'>
            <fieldset>
                <legend>Ajouter un joueur à la conversation</legend>
                <div class="row">
                    <div class="large-5 columns">
                         <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix radius" data-icon="&#xe09f;"></span>
                            </div>
                            <div class="small-9 columns">
                                <?php input('message_user', '', '', '', 'Pseudo')?>
                            </div>
                        </div>
                    </div>
                    <div class="large-7 columns">
                        <input type="hidden" value="<?php echo $Conversation->getId()?>" name="conversation_id" />
                        <input type="submit" value="Ajouter le joueur à la conversation" class="button small" />
                    </div>
                </div>
                
            </fieldset>
        </form>



    </div>
</div>
        <?php
        foot();
        ?>