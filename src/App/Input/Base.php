<?php

namespace Ombimo\MrPanel\App\Input;

use Illuminate\Support\Str;

/**
 *
 */
class Base
{
    protected $formView;
    protected $view;

    /**
     * menampilkan data
     * @param  [string] $data data yang akan ditampilkan
     * @return [view]       view dari data yang ditampilkan
     */
    public static function view($data, $col = null)
    {
        $config = json_decode($col->config);

        return view()->first([
            self::getView(), 'mrpanel::input.base.view',
        ], [
            'data' => $data,
            'config' => $config,
        ]);
    }

    /**
     * menampilkan form
     * @param  [array] $col objek col dari database
     * @return [view]       view dari form yang ditampilkan
     */
    public static function form($col, $value = '', $config = [])
    {
        $config = json_decode($col->config_form);

        return view()->first([
            self::getFormView(), 'mrpanel::input.base.form',
        ], [
            'id' => $col->col_name . '-' . Str::random(5),
            'col' => $col,
            'config' => $config,
            'value' => $value,
        ]);
    }

    /**
     * ambil data dari post yang akan dimasukkan ke DB
     * @param  [type] $col [description]
     * @return [type]      [description]
     */
    public static function getInput($col)
    {
        $result['return'] = true;
        $result['data'] = request($col->col_name, '');
        return $result;
    }

    /**
     * ambil nama view untuk menampilkan form berdasarkan nama class
     * @return [string] nama view
     */
    protected static function getFormView()
    {
        $class = Str::kebab(class_basename(get_called_class()));
        return 'mrpanel::input.' . $class . '.form';
    }

    /**
     * ambil nama view untuk menampilkan data berdasarkan nama class
     * @return [string] nama view
     */
    protected static function getView()
    {
        $class = Str::kebab(class_basename(get_called_class()));
        return 'mrpanel::input.' . $class . '.view';
    }
}
