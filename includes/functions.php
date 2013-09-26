<?php
function isConnected()
{
    if (!empty($_SESSION['User'])) {
        return true;
    }
}


function renderCountDown($time)
{
    return '<span class="countdown" data-time="'.  countDown(time() + $time).'"></span>';
}

function countDown($rem)
{
    $day = floor($rem / 86400);
    $hr  = floor(($rem % 86400) / 3600);
    $min = floor(($rem % 3600) / 60);
    $sec = ($rem % 60);
    if($day) echo $day."j ";
    if($hr) echo $hr."h ";
    if($min) echo $min."m ";
    if($sec) echo $sec."s ";
}