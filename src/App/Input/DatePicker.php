<?php

namespace Ombimo\MrPanel\App\Input;
use Illuminate\Support\Str;
/**
 *
 */
class DatePicker extends Base
{
    public static function form($col, $value = '', $config = [])
    {
        $config = json_decode($col->config_form);

        if ($value != '') {
            $date = date_create_from_format('Y-m-d', $value);
            if (!$date) {
                $date = date_create_from_format('Y-m-d H:i:s', $value);
            }
            if (!$date) {
                $value = '';
            } else {
                $value = date_format($date, 'd/m/Y');
            }
        }

        return view()->first([
            self::getFormView(), 'mrpanel::input.base.form'
        ],[
            'id' => $col->col_name.'-'. Str::random(5),
            'col' => $col,
            'config' => $config,
            'value' => $value
        ]);
    }

    public static function getInput($col)
    {

        $tempDataInput = request($col->col_name, '');
        if( $tempDataInput === '' || is_null($tempDataInput ) ) {
            //$date = date();
            $result['return'] = false;

        } else {
            $result['return'] = true;
            $date = date_create_from_format('d/m/Y', $tempDataInput);
            $result['data'] = date_format($date, 'Y-m-d');
        }

        return $result;
    }
}
