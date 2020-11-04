<?php

namespace Ombimo\MrPanel\App\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ombimo\MrPanel\Models\Table;

/**
 *
 */
class Select extends Base
{
    protected static $cache = [];

    public static function view($id, $col = null)
    {
        $config = json_decode($col->config_form);
        $url = '';

        if (empty($id)) {
            $data = null;
        } elseif (
            !empty($config->source->table_name) &&
            !empty($config->source->col_id) &&
            !empty($config->source->col_value)
        ) {
            $tableName = $config->source->table_name;
            $colID = $config->source->col_id;
            $colValue = $config->source->col_value;

            if (isset(self::$cache[$tableName][$id])) {
                $data = self::$cache[$tableName][$id];
            } else {
                $temp = DB::table($tableName)
                    ->select($colID, $colValue)
                    ->where($colID, $id)
                    ->first();
                $data = $temp->{$colValue};
                self::$cache[$tableName][$id] = $data;
            }

            if (!is_null($data) || !empty($data)) {
                if (!empty($config->link) && $config->link) {
                    $tempTable = Table::where('table_name', $tableName)->first();
                    $url = mrpanel_url($tempTable->alias . '/update/' . $id);
                }
            }
        }

        if (empty($data)) {
            $data = $id;
        }

        return view()->first([
            self::getView(), 'mrpanel::input.base.view',
        ], [
            'data' => $data,
            'config' => $config,
            'url' => $url,
        ]);
    }
    public static function form($col, $value = '', $config = [])
    {
        $config = json_decode($col->config_form);
        if (empty($config->source->table_name) ||
            empty($config->source->col_id) ||
            empty($config->source->col_value)
        ) {
            return false;
        }
        $data = DB::table($config->source->table_name)
            ->select($config->source->col_id, $config->source->col_value)
            ->orderBy($config->source->col_value)
            ->get();

        return view()->first([
            self::getFormView(), 'mrpanel::input.base.form',
        ], [
            'id' => $col->col_name . '-' . Str::random(5),
            'col' => $col,
            'data' => $data,
            'config' => $config,
            'value' => $value,
        ]);
    }

    public static function getInput($col)
    {
        $config = json_decode($col->config_form);
        $result['return'] = true;
        $result['data'] = request($col->col_name, '');

        if ($config->null && $result['data'] == '') {
            $result['data'] = null;
        }

        return $result;
    }

}
