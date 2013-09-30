<?php
abstract class FlyTemplate
{
    private static $_header;
    private static $_footer;

    private static $_title;

    private static $_css = array();
    private static $_scripts = array();

    public static function head($file = false)
    {
        global $User, $array_fleets, $array_actions;
        if (self::$_header) {
            trigger_error('Header already loaded', E_USER_ERROR);
        }
        self::$_header = true;
        include_once ROOT_DIR.'templates/header.php';
    }

    public static function foot($file = false)
    {
        if (self::$_footer) {
            trigger_error('Footer already loaded', E_USER_ERROR);
        }
        self::$_footer = true;
        include_once ROOT_DIR.'templates/footer.php';
    }

    public static function title($title = null, $title_only = false)
    {
        if (!$title) {
            return self::$_title;
        }

        self::$_title = $title;
        if (!$title_only) {
            $title .= ' - BackFlight';
        }
    }

    public static function css($src = null)
    {
        if (!$src) {
            return self::$_css;
        }
        self::$_css[$src] = true;
    }

    public static function script($src = null, $script = null)
    {
        if (!$src && !$script) {
            return self::$_scripts;
        }

        if ($src) {
            self::$_scripts[$src] = '';
        }

        if ($script) {
            self::$_scripts[] = $script;
        }
    }
}