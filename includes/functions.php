<?php
function isConnected()
{
    if (!empty($_SESSION['User'])) {
        return true;
    }
}
