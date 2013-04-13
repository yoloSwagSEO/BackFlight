<?php
class Form
{
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

        if (is_array($value)) {
            if (empty($value)) {
                $value = '';
            } else {
                if (preg_match('#(.+)\[(.+)\]#', $name)) {
                    $value = self::_getValuesArray($name);
                }
            }
        }
        $value = ' value="'.$value.'" ';

        if (!empty($placeholder)) {
            $placeholder = ' placeholder="'.$placeholder.'" ';
        }

        if ($disabled) {
        	$disabled = ' readonly="readonly" ';
        }

        $id = str_replace('[', '_', $name);
        $id = str_replace(']', '', $id);

        return '<input id="'.$id.'" type="'.$type.'" name="'.$name.'"'.$class.''.$value.''.$placeholder.''.$disabled.' />';
    }
    
    public static function label($for, $text, $class=null)
    {
        if (!empty($class)) {
            $class = ' class="'.$class.'"';
    	}

        $for = str_replace('[', '_', $for);
        $for = str_replace(']', '', $for);
        return '<label for="'.$for.'"'.$class.'>'.$text.'</label>';
    }
    
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

        if (is_array($value)) {
            if (empty($value)) {
                $value = '';
            } else {
                if (preg_match('#(.+)\[(.+)\]#', $name)) {
                    $value = self::_getValuesArray($name);
                }
            }
        }

        $id = str_replace('[', '_', $name);
        $id = str_replace(']', '', $id);

        return '<textarea name="'.$name.'" id="'.$id.'" rows="'.$rows.'" cols="'.$cols.'"'.$placeholder.''.$class.'>'.$value.'</textarea>';
    }

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

        if (is_array($selected)) {
            if (empty($selected)) {
                $selected = '';
            } else {
                if (preg_match('#(.+)\[(.+)\]#', $name)) {
                    $selected = self::_getValuesArray($name);
                }
            }
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

    public static function checkbox($name, $checked=null, $class="")
    {
        // getting values
        if (empty($checked)) {
            $checked = self::_getValues($name);
        }

        if (is_array($checked)) {
            if (empty($checked)) {
                $checked = '';
            } else {
                if (preg_match('#(.+)\[(.+)\]#', $name)) {
                    $checked = self::_getValuesArray($name);
                }
            }
        }
        if ($checked) {
            $checked = 'checked="checked"';
        }

        if (!empty($class)) {
            $class = ' class="'.$class.'" ';
        }

        $id = str_replace(array('[', ']'), array('_', ''), $name);

        return '<input type="checkbox" name="'.$name.'" id="'.$id.'" '.$cocher.''.$class.' />';
    }

    public static function radios($name, array $radios, $checked=null)
    {
        $return = '';

        // getting values
        if (empty($checked)) {
            $checked = self::_getValues($name);
        }

        if (is_array($checked)) {
            if (empty($checked)) {
                $checked = '';
            } else {
                if (preg_match('#(.+)\[(.+)\]#', $name)) {
                    $checked = self::_getValuesArray($name);
                }
            }
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
    
    private static function _getValues($name)
    {
        // On regarde si le nom du champ comporte des [], signe qu'on a peut-être affaire à un tableau
        if (preg_match('#(.+)\[(.+)\](.+?)#U', $name)) {
            return self::_getValuesArray($name);
        }

        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    private static function _getValuesArray($name, $array=null)
    {
        $retour = '';
        // Recherche des [] pour trouver les tableaux
        if (preg_match('#^(.+)\[(.+)\](.+)?$#U', $name, $retour)) {
            $session_add = '';
            // S'il y a effectviement un niveau inférieur
            if ($retour[2] != '') {
                $session_name = $retour[1];
                $session_check = $retour[2];
                if (!empty($retour[3])) {
                    $session_add = $retour[3];
                }
                if (empty($array)) {
                    $array = $_SESSION[$session_name];
                }
                // Si la session courante est toujours un tableau
                if (is_array($array)) {
                    if (!empty($array[$session_check])) {
                        $array_values = $array[$session_check];
                        // Si la valeur est un tableau, c'est qu'il y a sans doute encore un autre niveau
                        if (is_array($array_values)) {
                            return self::_getValuesArray($session_check.$session_add, $array_values);
                        }
                        return $array_values;
                    }
                }
                return $array;
            }
        }
    }

    
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
    
    public static function cleanSessions(array $array)
    {
        foreach($array as $value)
        {
             unset($_SESSION[$value]);
        }
    }
}