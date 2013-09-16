<?php
function isConnected()
{
    if (!empty($_SESSION['User'])) {
        return true;
    }
}


function renderCountDown($time)
{
    return '<span class="countdown" data-time="'.(time() + $time).'"></span>';
}
