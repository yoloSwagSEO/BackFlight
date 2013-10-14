<?php
$CurrentPosition = new Position(1);
$nb_runs = 10000;

// Asteroids
echo '<h1>Asteroids</h1>';
$array_results = array('fuel' => 0, 'techs' => 0, 'null' => 0);
for ($i = 0; $i < $nb_runs; $i++)
{
    $result = $CurrentPosition->searchRessources('probes', 'asteroids');
    if (!empty($result)) {
        $array_results[$result[0]]++;
    } else {
        $array_results['null']++;
    }
}

foreach ($array_results as $type => $value)
{
    $array_results[$type] = $value/$nb_runs*100;
}


var_dump($array_results);

// Planet
echo '<h1>Planet</h1>';
$array_results = array('fuel' => 0, 'techs' => 0, 'null' => 0);
for ($i = 0; $i < $nb_runs; $i++)
{
    $result = $CurrentPosition->searchRessources('probes', 'planet');
    if (!empty($result)) {
        $array_results[$result[0]]++;
    } else {
        $array_results['null']++;
    }
}

foreach ($array_results as $type => $value)
{
    $array_results[$type] = $value/$nb_runs*100;
}
var_dump($array_results);

// Space
echo '<h1>Space</h1>';
$array_results = array('fuel' => 0, 'techs' => 0, 'null' => 0);
for ($i = 0; $i < $nb_runs; $i++)
{
    $result = $CurrentPosition->searchRessources('probes', 'space');
    if (!empty($result)) {
        $array_results[$result[0]]++;
    } else {
        $array_results['null']++;
    }
}

foreach ($array_results as $type => $value)
{
    $array_results[$type] = $value/$nb_runs*100;
}
var_dump($array_results);
?>
