<?php

namespace Ombimo\MrPanel\App\Input;

use Illuminate\Support\Str;
/**
 *
 */
class SlugAuto extends Base
{
    public static function getInput($col)
    {
        $config = json_decode($col->config_form);
        $result['return'] = true;
        $data = request($col->col_name, '');

        if (is_null($data) || $data ==='' ) {
            $result['data'] = Str::slug(request($config->col_source, ''));
        } else {
            $result['data'] = Str::slug($data);
        }

        return $result;
    }
}
