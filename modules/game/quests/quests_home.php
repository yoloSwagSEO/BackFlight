<?php
title('Quests');
head();

$array_quests[0] = $array_quests_player;
$array_quests[1] = array();

ksort($array_quests);

?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Mes quêtes</h3>
        <?php
        foreach ($array_quests as $i => $quests)
        {
        ?>
        <h4><?php if ($i == 0) { echo 'Quêtes en cours'; } else { echo 'Quêtes achevées'; }?></h4>
        <?php
        if (empty($quests)) {
            ?>
            <p>
                Aucune
            </p>
            <?php
        } else {
        ?>
        <ul class="ul_blocs">
            <?php
            foreach ($quests as $Quest)
            {
                if ($Quest->getState() == 'end') {
                    continue;
                }
                $status = '';
                if ($Quest->isStartedByPlayer()) {
                    $status = '[En cours] ';
                }
                ?>
            <li>
                <a href="quests/<?php echo $Quest->getId()?>" class="full"><?php echo $status.$Quest->getName()?></a>
            </li>
                <?php
            }
            ?>
        </ul>
        <?php
        }
        }
        ?>
    </div>
</div>
<?php
foot();