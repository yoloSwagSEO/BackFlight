<?php
$Conversation = new Conversation($_GET['conversation']);
if (!$Conversation->isSql()) {
    exit('Unknown conversation');
}


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
        <?php
        foreach ($Conversation->getMessages() as $Message)
        {
            ?>
        <div class="row panel">
            <div class="large-2 columns">
                <strong><?php echo $Message->getUserFrom(true)?></strong><br />
                <small><?php echo date('d/m h:i', $Message->getDate())?></small>
            </div>
            <div class="large-10 columns">
                <?php echo $Message->getContent()?>
            </div>
        </div>
            <?php
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
                <input type="submit" value="Envoyer mon message" class="button" />
            </fieldset>

        </form>



    </div>
</div>
        <?php
        foot();
        ?>