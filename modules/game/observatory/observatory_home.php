<?php
title('Observatory');
head();

$MasterShipPosition = new Position($MasterShipPlayer->getPositionId());
$position_category = $MasterShipPosition->getCategory();

$array_quests_position = Quest::getAll('', '', $MasterShipPosition->getId(), $User->getId(), 'not_started');

foreach ($array_quests_position as $id => $Quest)
{
    if ($Quest->isDoneByPlayer()) {
        unset($array_quests_position[$id]);
    }
}

?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Observatoire</h3>
        <div data-alert class="alert-box success radius">
            <?php
            if ($position_category == 'planet') {
            ?>
                Nos capteurs détectent une planète habitable.
            <?php
            } else if ($position_category == 'asteroids') {
                ?>
                Nos capteurs détectent un vaste champs d'astéroïdes.
                <?php
            } else if ($position_category == 'space') {
                ?>
                Nos capteurs détectent seulement du vide : nous sommes en plein espace.
                <?php
            }
            ?>
        </div>

        <div class="alert-box success radius" data-alert>
            Présence de Fuel :
            <?php
            $qualityFuel = $MasterShipPosition->getSearchProbability('fuel');
            $qualityTechs = $MasterShipPosition->getSearchProbability('techs');
            if ($qualityFuel == POSITION_SEARCH_POOR_PROBA) {
                echo 'faible';
            } else if ($qualityFuel == POSITION_SEARCH_NORMAL_PROBA) {
                echo 'normale';
            } else {
                echo 'élevée';
            }
            ?>
            / Présence de techs :
            <?php
            if ($qualityTechs == POSITION_SEARCH_POOR_PROBA) {
                echo 'faible';
            } else if ($qualityTechs == POSITION_SEARCH_NORMAL_PROBA) {
                echo 'normale';
            } else {
                echo 'élevée';
            }
            ?>
        </div>

        <?php
        if (!empty($_SESSION['errors']['search']['fuel_missing'])) {
            ?>
            <div data-alert class="alert-box alert radius">
                Fuel insuffisant pour lancer la recherche ! <br />Effectuez une recherche avec les sondes, qui ne consomment pas de fuel...
            </div>
            <?php
            unset($_SESSION['errors']['search']['fuel_missing']);
        }
        ?>
        <?php
        if (!empty($_SESSION['errors']['search']['energy_missing'])) {
            ?>
            <div data-alert class="alert-box alert radius">
                Energie insuffisante pour lancer la recherche ! <br />Patientez jusqu'à ce que les batteries soient suffisamment chargées.
            </div>
            <?php
            unset($_SESSION['errors']['search']['energy_missing']);
        }
        ?>

        <?php
        if (!$MasterShipPlayer->isBusy()) {
            include_once 'modules/game/observatory/observatory_'.$position_category.'.php';
        } else {
            ?>
                Le vaisseau est déjà en vol !
            <?php
        }
        ?>

        <?php
        if (!empty($array_quests_position)) {
            ?>
        <h3>Quêtes</h3>
        <div data-alert class="alert-box success radius">
        <?php $c = count($array_quests_position); echo $c; ?> quête<?php echo ($c>1?'s':'') ?> se déroule<?php echo ($c>1?'nt':'') ?> ici.
        </div>
        <ul class="ul_blocs">
            <?php
            foreach ($array_quests_position as $Quest)
            {
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
        ?>
    </div>
</div>
<?php
foot();
?>

