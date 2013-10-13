<?php
$remainingDistance = $CurrentPosition->getDistanceFromEarth();
$total = Position::calculateDistance(POSITION_START_X, POSITION_START_Y, 0, 0);

$diff = $total - $remainingDistance;

$current = 100 - $remainingDistance / $total * 100;
?>


<div class="panel">
    <div data-alert="" class="alert-box radius">Distance from Earth

    </div>
    Progression
    <small>(<?php echo round($diff)?> / <?php echo round($total)?>)</small>
    <div class="progress success radius" data-tooltip title="<?php echo round($current, 2)?>%"><span class="meter" style="width: <?php echo $current?>%"></span></div>
        
    <a class="button tiny" data-tooltip title="Total flight time to reach earth"><?php
    echo countDown($MasterShipPlayer->calculateTravelTime($remainingDistance));
    ?> </a>
    
</div>
