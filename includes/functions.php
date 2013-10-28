<?php
require_once 'includes/markdown_extended.php';


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
    if($sec) {
        $time .= $sec."s ";
    } else if (!$day && !$hr && $min) {
        $time .= '0s';
    }
    return $time;
}

function profile($title = null)
{
    global $script_start_microtime;
    if (!empty($_SESSION['User'])) {
        if ($_SESSION['User'] == 1) {
                echo '<pre><span style="color:#cc0000; display: inline-block; width: 100px; text-align: right;">'.number_format(microtime(true) - $script_start_microtime, 4, '.', '').'s</span> <small>('.$title.')</small></pre>';

        }
    }
}