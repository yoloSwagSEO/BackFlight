<?php
title('Classement général');
head();

$Rank = new Rank();
$Rank->updateRanks();
$lastUpdate = $Rank->getLastUpdate();
$type = 'global';
if (!empty($_GET['type'])) {
    $type = $_GET['type'];
}


$array_ranks = Rank::getAll('', '', $lastUpdate, $type);


?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Classement</h3>
        <?php include_once 'modules/game/ranks/ranks_menu.php';?>
            <small>Dernière mise à jour : <?php echo date('H:i', $lastUpdate)?></small>
        </p>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Joueur</th>
                    <th>Points</th>
                    <th>Progression</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($array_ranks as $Rank)
                {
                    $class = '';
                    if ($Rank->getUserId() == $User->getId()) {
                        $class = ' class="strong"';
                    }
                    ?>
                <tr>
                    <td<?php echo $class?>><?php echo $i?></td>
                    <td<?php echo $class?>><?php echo $Rank->getUserPseudo()?></td>
                    <td<?php echo $class?>>
                        <?php
                        if ($type == 'global') {
                            echo round($Rank->getGlobal());
                        } else if ($type == 'ressources') {
                            echo round($Rank->getRessources());
                        } else if ($type == 'distance') {
                            echo round($Rank->getDistance());
                        } else if ($type == 'position') {
                            echo round($Rank->getPosition());
                        }
                        ?>
                    </td>
                    <td>
                    </td>
                </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>

    </div>
</div>
        

<?php
foot();
?>

