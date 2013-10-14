<?php
class Form
{
    /**
     *
     * @param string $name
     * @param string $type
     * @param string $value
     * @param string $class
     * @param string $placeholder
     * @param string $disabled
     * @return string
     */
    public static function input($name=null, $type=null, $value=null, $class=null, $placeholder = null, $disabled = false)
    {
        // default type=text
    	if (empty($type)) {
            $type = 'text';
    	}
        
    	// adding class
    	if (!empty($class)) {
            $class = ' class="'.$class.'"';
    	}

        // getting values
        if (empty($value)) {
            $value = self::_getValues($name);
        }

        $value = ' value="'.$value.'" ';

        if (!empty($placeholder)) {
            $placeholder = ' placeholder="'.$placeholder.'" ';
        }

        $id = $name;

        if ($disabled) {
            $disabled = ' readonly="readonly" ';
        }

        return '<input id="'.$id.'" type="'.$type.'" name="'.$name.'"'.$class.''.$value.''.$placeholder.''.$disabled.' />';
    }

    /**
     *
     * @param string $for
     * @param string $text
     * @param string $class
     * @return string
     */
    public static function label($for, $text, $class=null)
    {
        if (!empty($class)) {
            $class = ' class="'.$class.'"';
    	}
        return '<label for="'.$for.'"'.$class.'>'.$text.'</label>';
    }

    /**
     *
     * @param string $name
     * @param string $value
     * @param int $rows
     * @param int $cols
     * @param string $placeholder
     * @param string $class
     * @return string
     */
    public static function textarea($name, $value=null, $rows=8, $cols=45, $placeholder=null, $class=null)
    {
        if (!empty($placeholder)) {
            $placeholder = ' placeholder="'.$placeholder.'" ';
        }

        if (!empty($class)) {
            $class = ' class="'.$class.'" ';
        }

        // getting values
        if (empty($value)) {
            $value = self::_getValues($name);
        }

        $id = $name;

        return '<textarea name="'.$name.'" id="'.$id.'" rows="'.$rows.'" cols="'.$cols.'"'.$placeholder.''.$class.'>'.$value.'</textarea>';
    }

    /**
     *
     * @param string $name
     * @param array $options
     * @param string $selected
     * @param string $class
     * @return string
     */
    public static function select($name, array $options, $selected=null, $class=null)
    {
    	if (!empty($class)) {
            $class = ' class="'.$class.'"';
    	}

        $return = '<select name="'.$name.'" id="'.$name.'" '.$class.'>'."\n";

        // getting values
        if (empty($selected)) {
            $selected = self::_getValues($name);
        }


        foreach($options as $value => $option)
        {
            $tselected = '';
            if ($selected == $value) {
                $tselected = ' selected="selected" ';
            } 

            $return .=  '<option value="'.$value.'"'.$tselected.'>'.$option.'</option>';
            $return .= "\n";
        }

        $return .= '</select>';
        return $return;
    }

    /**
     *
     * @param string $name
     * @param string $checked
     * @param string $class
     * @return string
     */
    public static function checkbox($name, $checked=null, $class="")
    {
        // getting values
        if (empty($checked)) {
            $checked = self::_getValues($name);
        }

        if ($checked) {
            $checked = 'checked="checked"';
        }

        if (!empty($class)) {
            $class = ' class="'.$class.'" ';
        }

        $id = $name;

        return '<input type="checkbox" name="'.$name.'" id="'.$id.'" '.$checked.''.$class.' />';
    }

    /**
     *
     * @param string $name
     * @param array $radios
     * @param string $checked
     * @return string
     */
    public static function radios($name, array $radios, $checked=null)
    {
        $return = '';

        // getting values
        if (empty($checked)) {
            $checked = self::_getValues($name);
        }

        foreach ($radios as $value => $text)
        {
            if ($checked == $value) {
                $checkedTag = ' checked="checked" ';
            } else {
                $checkedTag = '';
            }
            $return .=  '
            		<label for="radio_'.$value.'" id="label_'.$name.'_'.$value.'" class="label_'.$name.'">
            			<input type="radio" name="'.$name.'" value="'.$value.'" id="radio_'.$value.'"'.$checkedTag.' class="radio_'.$name.'_'.$value.'" />
            			<span>'.$text.'</span>
            		</label>';
        }

        return $return;
    }

    /**
     *
     * @param string $name
     * @return string
     */
    private static function _getValues($name)
    {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    /**
     *
     * @param array $array
     */
    public static function saveSessions(array $array)
    {
        foreach($array as $value)
        {
            if (!empty($_SESSION[$value])) {
                if ($_SESSION[$value] == 'on') {
                    $_SESSION[$value] = '';
                }
            }

            if (isset($_POST[$value])) {
                $_SESSION[$value] = $_POST[$value];
            } else {
                $_SESSION[$value] = '';
            }
        }
    }

    /**
     *
     * @param array $array
     */
    public static function cleanSessions(array $array)
    {
        foreach($array as $value)
        {
             unset($_SESSION[$value]);
        }
    }

    /**
     *
     * @param array $array
     * @return boolean
     */
    public static function check(array $array)
    {
        foreach($array as $value)
        {
            if (empty($_POST[$value])) {
            	if (!isset($_POST[$value])) {
            		return false;
            	}
            	if ($_POST[$value] === 0 || $_POST[$value] === '') {
            		return false;
            	}
            }

        }
        return true;
    }
    
}