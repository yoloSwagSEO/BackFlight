<?php
$array_positions_knowns = Position::getKnownFor($User->getId());

$type = 'flight';
$type_link = '';
if (!empty($_GET['speed'])) {
    if ($_GET['speed'] === 'jump') {
        $type = 'jump';
        $type_link = '/jump';
    }
}

title('Positions');
head();


$MasterShipPosition = new Position($MasterShipPlayer->getPositionId());

?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Positions</h3>
        <div data-alert class="alert-box success radius">
            Vous avez déjà exploré ces positions et pouvez y retourner en un saut.
        </div>

        <dl class="sub-nav">
            <dt>Type de vol : </dt>
            <dd <?php if ($type == 'jump') { echo 'class="active"'; }?>><a href="positions/fly/jump">Saut hyperespace</a></dd>
            <dd <?php if ($type !== 'jump') { echo 'class="active"'; }?>><a href="positions/fly">Vol hyperespace</a></dd>
        </dl>

        <table width="100%">
            <thead>
                <tr>
                    <th>
                        Position
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Distance
                    </th>
                    <th>
                        Energie
                    </th>
                    <th>
                        Fuel
                    </th>
                    <th>
                        Durée
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
        <?php
        foreach ($array_positions_knowns as $Position)
        {
            $current_position = false;
            if ($Position->getId() == $MasterShipPosition->getId()) {
                $current_position = true;
            }
            $distance = Position::calculateDistance($MasterShipPosition->getX(), $MasterShipPosition->getY(), $Position->getX(), $Position->getY())
            ?>
            <tr>
                <td><?php echo $Position->getX()?>:<?php echo $Position->getY()?></td>
                <td><?php echo $Position->getCategory(true)?></td>
                <td><?php echo ceil($distance)?></td>
                <td><?php echo $MasterShipPlayer->calculateTravelEnergy($distance, $type)?></td>
                <td><?php echo $MasterShipPlayer->calculateTravelFuel($distance, $type)?></td>
                <td><?php echo $MasterShipPlayer->calculateTravelTime($distance, $type)?>s</td>
                <td>
                    <?php
                    if (!$current_position) {
                        ?>
                    <a href="fly/<?php echo $Position->getX()?>-<?php echo $Position->getY()?><?php echo $type_link?>">Rejoindre</a>

                        <?php
                    } else {
                        ?>
                        Position actuelle
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>


<?php
foot();
?>

