<?php
function isConnected()
{
    if (!empty($_SESSION['User'])) {
        return true;
    }
}


function renderCountDown($time)
{
    return '<span class="countdown" data-time="'.$time.'">'.countDown($time).'</span>';
}

function countDown($rem)
{
    $day = floor($rem / 86400);
    $hr  = floor(($rem % 86400) / 3600);
    $min = floor(($rem % 3600) / 60);
    $sec = ($rem % 60);

    $time = '';
    if($day) $time .= $day."j ";
    if($hr) $time .= $hr."h ";
    if($min) $time .= $min."m ";
    if($sec) $time .= $sec."s ";
    return $time;
}