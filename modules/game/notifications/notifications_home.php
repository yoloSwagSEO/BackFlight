<?php
title('Notifications');
head();


?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Notifications</h3>
        <div data-alert class="alert-box success radius">

            Cliquez sur une notification pour la lire.
        </div>

        <dl class="sub-nav">
            <dt>Type de vol : </dt>
            <dd><a href="positions/fly/jump">Toutes</a></dd>
            <dd class="active"><a href="positions/fly">Non lues</a></dd>
        </dl>

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
                        Position
                    </th>
                </tr>
            </thead>
        <?php
        foreach ($array_notifications_unread as $Notification)
        {
            ?>
            <tr>
                <td><?php echo $Notification->renderTitle()?></td>
                <td><?php echo date('d/m - h:i', $Notification->getDate())?></td>
                <td>n:n</td>
            </tr>
            <?php
        }
        ?>
        </table>


<?php
foot();
?>

