<?php
title('Nouveau message');
head();

?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Nouveau message</h3>
        <form action='messages/new' method='post'>
            <fieldset>
                <legend>Rédaction de mon message</legend>
                <div class="row">
                    <div class='small-5 columns'>
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix radius" data-icon="&#xe09f;"></span>
                            </div>
                            <div class="small-9 columns">
                                <?php input('message_user', '', '', '', 'Destinataire')?>
                            </div>
                        </div>
                    </div>
                    <div class='small-7 columns'>
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <span class="prefix radius" data-icon="&#xe030;"></span>
                            </div>
                            <div class="small-10 columns">
                                <?php input('message_subject', '', '', '', 'Sujet')?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <label>Mon message</label>
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

