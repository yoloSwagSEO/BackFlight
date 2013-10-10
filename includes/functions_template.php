<?php
function head($file = false)
{
    global $User, $array_fleets, $array_actions, $array_notifications_unread;
    return FlyTemplate::head($file);
}

function foot($file = false)
{
    return FlyTemplate::foot($file);
}

function title($title = null, $title_only = false)
{
    return FlyTemplate::title($title, $title_only);
}

function css($src = null)
{
    return FlyTemplate::css($src);
}

function script($src = null, $script = false)
{
    return FlyTemplate::script($src, $script);
}
?>
