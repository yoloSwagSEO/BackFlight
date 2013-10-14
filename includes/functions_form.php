<?php

/**
 *
 * @param string $for
 * @param string $valeur
 * @param string $class
 */
function label($for, $valeur, $class=null)
{
    echo Form::label($for, $valeur, $class);
}

/**
 *
 * @param string $name
 * @param string $type
 * @param string $value
 * @param string $class
 * @param string $placeholder
 * @param string $session_force
 * @param boolean $disabled
 */
function input ($name, $type=null, $value=null, $class=null, $placeholder = null, $session_force=null, $disabled = false)
{
    echo Form::input($name, $type, $value, $class, $session_force, $placeholder, $disabled);
}

/**
 *
 * @param string $name
 * @param string $value
 * @param int $rows
 * @param int $cols
 * @param string $placeholder
 * @param string $class
 */
function textarea($name, $value=null, $rows=null, $cols=null, $placeholder=null, $class=null)
{
    echo Form::textarea($name, $value, $rows, $cols, $placeholder, $class);
}

/**
 *
 * @param string $name
 * @param array $choix
 * @param string $selected
 * @param string $ajout
 * @param string $class
 */
function select($name, array $choix, $selected=null, $ajout = null, $class = null)
{
    echo Form::select($name, $choix, $selected, $ajout, $class);
}

/**
 *
 * @param string $name
 * @param string $cocher
 * @param string $class
 */
function checkbox($name, $cocher=null, $class="")
{
    echo Form::checkbox($name, $cocher, $class);
}

/**
 *
 * @param string $name
 * @param array $radios
 * @param string $checked
 */
function radios($name, array $radios, $checked=null)
{
    echo Form::radios($name, $radios, $checked);
}

/**
 *
 * @param array $array
 * @return boolean
 */
function check(array $array)
{
    return Form::check($array);
}

/**
 *
 * @param array $array
 * @return type
 */
function saveSessions(array $array)
{
    return Form::saveSessions($array);
}

/**
 *
 * @param array $array
 * @return type
 */
function cleanSessions(array $array)
{
    return Form::cleanSessions($array);
}
