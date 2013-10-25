<?php
$remainingDistance = $CurrentPosition->getDistanceFromEarth();
$total = Position::calculateDistance(POSITION_START_X, POSITION_START_Y, 0, 0);

$diff = $total - $remainingDistance;

$current = 100 - $remainingDistance / $total * 100;

$array_ranks_user = $Rank->getFor($array_ranks, $User->getId());
$nb_users = User::getNbUsers();
?>


<div class="panel">
    <div data-alert="" class="alert-box radius">Distance from Earth

    </div>
    Progression
    <small>(<?php echo round($diff)?> / <?php echo round($total)?>)</small>
    <div class="progress success radius" data-tooltip title="<?php echo round($current, 2)?>%"><span class="meter" style="width: <?php echo $current?>%"></span></div>
        
    <a class="button tiny" data-tooltip title="Total flight time to reach earth"><?php
    $time = $MasterShipPlayer->calculateTravelTime($remainingDistance);
    if ($time) {
        echo countDown($time);
    } else {
        echo 'Unknown';
    }
    ?> </a>
    
</div>

<a href="ranks">
    <div class="panel">
        <div data-alert="" class="alert-box radius">
            Classement
        </div>
        <strong>Général : <small><?php echo $array_ranks_user['global']?> / <?php echo $nb_users;?></small></strong><br />
    </div>
</a>