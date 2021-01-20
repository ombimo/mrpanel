<?php

namespace Ombimo\MrPanel\App\Input;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
/**
 *
 */
class InputFile extends Base
{
    public static function getInput($col)
    {
        $config = json_decode($col->config_form);
        $file = request()->file($col->col_name);
        $path = '';

        if (request()->hasFile($col->col_name) &&
            request()->file($col->col_name)->isValid()
        ){
            $filename = Str::slug(pathinfo(request($col->col_name)->getClientOriginalName(), PATHINFO_FILENAME));
            $ext = '.'.request()->file($col->col_name)->extension();
            $tempFilename = $filename;
            $i = 1;
            while (Storage::disk('public')->exists($config->dir.DIRECTORY_SEPARATOR.$filename.$ext)) {
                $filename = $tempFilename.'_'.$i;
                $i++;
            }
            $path = Storage::disk('public')->putFileAS(
                $config->dir,
                request()->file($col->col_name),
                $filename.$ext
            );
            $result['return'] = true;
            $result['data'] = $path;
        } else {
            $result['return'] = false;
        }
        return $result;
    }
}
