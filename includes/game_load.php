<?php
$Rank = new Rank();
$Rank->updateRanks();
$lastRankUpdate = $Rank->getLastUpdate();

$array_ranks = Rank::getAll('', '', $lastRankUpdate);
profile('Game load');
?>
