<?php

namespace Ombimo\MrPanel\App\Input;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
/**
 *
 */
class InputImage extends Base
{
    public static function getInput($col)
    {
        $filterMime = "/image\/.+/";
        $config = json_decode($col->config_form);
        $file = request()->file($col->col_name);
        $path = '';

        if (request()->hasFile($col->col_name) &&
            request()->file($col->col_name)->isValid() &&
            preg_match($filterMime, $file->getMimeType())
        ){
            $filename = Str::slug(pathinfo(request($col->col_name)->getClientOriginalName(), PATHINFO_FILENAME));
            $ext = '.'.request($col->col_name)->guessExtension();
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
