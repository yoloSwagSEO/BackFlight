<?php
title('Notifications');
head();

$array_notifications = $array_notifications_unread;
if (isset($_GET['all'])) {
    $array_notifications = Notification::getAll();
}


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
            <dt>Afficher les notifications : </dt>
            <dd<?php if (isset($_GET['all'])) {?> class="active"<?php } ?>><a href="notifications/all">Toutes</a></dd>
            <dd<?php if (!isset($_GET['all'])) {?> class="active"<?php } ?>><a href="notifications">Non lues</a></dd>
        </dl>
        <?php
        if(!empty($array_notifications)) {
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
                            Position
                        </th>
                    </tr>
                </thead>
            <?php
            foreach ($array_notifications as $Notification)
            {
                $class = '';
                if (!$Notification->isRead()) {
                    $class = ' class="notification_unread"';
                }
                ?>
                <tr<?php echo $class?>>
                    <td><a href="notifications/read/<?php echo $Notification->getid()?>"><?php echo $Notification->renderTitle()?></a></td>
                    <td><a href="notifications/read/<?php echo $Notification->getid()?>"><?php echo date('d/m - h:i', $Notification->getDate())?></a></td>
                    <td><a href="notifications/read/<?php echo $Notification->getid()?>">n:n</a></td>
                </tr>
                <?php
            }
            ?>
            </table>
        <?php
        } else {
            ?>
        <p>
            Aucune notification
        </p>
            <?php
        }
        ?>

<?php
foot();
?>

