<?php

namespace Ombimo\MrPanel\App\Input;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 *
 */
class InputImageResize extends Base
{
    public static function getInput($col)
    {
        $config = json_decode($col->config_form);
        $path = null;
        $result = [
            'return' => false,
        ];
        try {

            $dir = $config->dir . DIRECTORY_SEPARATOR;
            $filename = request()->input('judul');
            $filename = $filename ?? request()->input('nama');
            $filename = $filename ?? Str::random(26);
            $filename = $dir . Str::slug($filename);

            $img = Image::make(request()->input($col->col_name));
            $ext = get_image_ext($img->mime());
            $img->interlace(true)->encode($ext);

            $tempName = $filename;
            $i = 0;
            while(Storage::disk('public')->exists($filename . '.' . $ext)) {
                $i++;
                $filename = $tempName. '_'. $i;
            }
            if (Storage::disk('public')->put($filename . '.' . $ext, $img->__toString())) {
                $path = $filename . '.' . $ext;
            }

        } catch(\Exception $e) {
            //$img = null;
        }

        if ($path != null) {
            $result['return'] = true;
            $result['data'] = $path;
        }

        return $result;
    }
}
