<?php

namespace Ombimo\MrPanel\App\Input;
/**
 * 
 */
class RadioSwitch extends Base
{
    public static function getInput($col)
    {
        $result['return'] = true;
        $result['data'] = request($col->col_name, 0);
        return $result;
    }
}