<?php

namespace Ombimo\MrPanel\App\Input;
use Illuminate\Support\Facades\Hash;
/**
 * 
 */
class InputPassword extends Base
{
    public static function getInput($col)
    {

        $result['data'] = request($col->col_name, '');
        if (empty($result['data'])) {
            $result['return'] = false;
        } else {
            $result['return'] = true;
            $result['data'] = Hash::make($result['data']);
        }
        return $result;
    }
}