<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Ombimo\MrPanel\Models\Permission;

if (! function_exists('superadmin_permission')) {
    function superadmin_permission() {
        $permission = new Permission;
        $permission->can_create = true;
        $permission->can_read = true;
        $permission->can_update = true;
        $permission->can_delete = true;
        return $permission;
    }
}

if (! function_exists('blank_permission')) {
    function blank_permission() {
        $permission = new Permission;
        $permission->can_create = false;
        $permission->can_read = false;
        $permission->can_update = false;
        $permission->can_delete = false;
        return $permission;
    }
}

if (! function_exists('mrpanel_get_alert')) {
    function mrpanel_get_alert($alert) {
        if (!is_null($alert)) {
            $type = $alert['type'];
            $msg = $alert['msg'];
            echo '
            <div class="alert '.$type.' alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              '.$msg.'
            </div>';
        }
    }
}

if (! function_exists('mrpanel_print_menu')) {
    function mrpanel_print_menu($menu, $parent = null) {
        $ulClass = is_null($parent) ? '' : 'collapse';
        echo '<ul class="'.$ulClass.'">';
        foreach ($menu as $value) {
            if ($value->divider && $value->parent_id == $parent) {
                echo '<li class="divider"><span>'. $value->name .'</span></li>';
            } elseif ($value->parent_id == $parent) {
                $hasSub = $menu->whereIn('parent_id', $value->id)->isEmpty() ? '' : 'has-sub';
                $icon = !empty($value->icon_class)? $value->icon_class : '' ;

                $url = url('/'.config('mrpanel.prefix'));

                if (!is_null($value->table_id) && isset($value->table->alias)) {
                    $url .= '/'.$value->table->alias;
                }

                if (!is_null($value->module)) {
                    $url .= '/'.$value->module;
                }

                if (!is_null($value->url) && !empty($value->url)) {
                    $url = mrpanel_url($value->url);
                }

                if (!is_null($value->param)) {
                    $url .= $value->param;
                }

                $url = $hasSub ? '#!' : $url;

                echo '<li>';
                echo '<a href="'.$url.'" class="'.$hasSub.'"><i class="'.$icon.'"></i>'.$value->name.'</a>';

                //sub menu
                if ($hasSub != '') {
                    mrpanel_print_menu($menu, $value->id);
                }

                echo '</li>';
            }
        }
        echo "</ul>";
    }
}

if (! function_exists('mrpanel_url')) {
    function mrpanel_url($url = '') {
        $url = config('mrpanel.prefix') . '/' . trim(trim($url), '/');
        return url($url);
    }
}

if ( ! function_exists('mrpanel_populate_select')) {
    function mrpanel_populate_select ($data, $selected = '', $multiArr = false, $keyName = '', $valName = '' )
    {
        if (gettype($data) === 'array') {
            $data = (object) $data;
        }
        if($multiArr) {
            foreach ($data as $value) {
                $temp = (strval($value->{$keyName}) === strval($selected)) ? 'selected' : '';
                echo '<option value="'.$value->{$keyName}.'"'.$temp.'>'.$value->{$valName}.'</option>';
            }
        } else {
            if( array_keys($data) !== range(0, count($data) - 1) ) {
                foreach ($data as $key => $value) {
                    $temp = (strval($key) === strval($selected)) ? 'selected' : '';
                    echo '<option value="'.$key.'"'.$temp.'>'.$value.'</option>';
                }
            } else {
                foreach ($data as $key => $value) {
                    $temp = (strval($value) === strval($selected)) ? 'selected' : '';
                    echo '<option value="'.$value.'"'.$temp.'>'.$value.'</option>';
                }
            }
        }
    }
}

if (! function_exists('mrpanel_back_ref')) {
    function mrpanel_back_ref($data, $value, $parent_id) {

        if (is_null($parent_id)) {
            return $value;
        }
        $temp = $data->firstWhere('id', $parent_id);
        $value = $temp->name.' > '.$value;
        return mrpanel_back_ref($data, $value, $temp->parent_id);
    }
}

if (! function_exists('mrpanel_abort')) {
    function mrpanel_abort($code = 500) {
        return response()
            ->view('mrpanel::errors.'.$code, [], $code);
    }
}

if (!function_exists('get_thumbnail')) {
    function get_thumbnail($image, $maxWidth = 100, $maxHeight = 100, $default = 'images/no-photo.png')
    {
        $response = $default;

        /**
         * fix ketika directory separator yang tidak sama
         */
        $image = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $image);

        //Log::debug($image);

        //jika image kosong return default
        if ($image == '' || !Storage::disk('public')->exists($image)) {
            return asset($default);
        }

        try {
            $path_parts = pathinfo($image);
            $dir = $path_parts['dirname'];
            $filename = $path_parts['filename'];
            $ext = $path_parts['extension'];
            $thumbnail = '';
            if ($dir != DIRECTORY_SEPARATOR) {
                $thumbnail = $dir.'/';
            }

            $thumbnail .= '_thumbnail/'.$maxWidth.'x'.$maxHeight.'/'.$filename . '.' . $ext;

            //cek jika thumbnail sudah ada
            if (Storage::disk('public')->exists($thumbnail)) {

                $path = Storage::disk('public')->url($thumbnail);
                $path = str_replace('\\', '/', $path);

                return $path;
            }

            $tempMemory = ini_get('memory_limit');
            ini_set('memory_limit', '512M');
            //Log::info('Memory Limit' . ini_get('memory_limit'));

            $img = Image::make(Storage::disk('public')->get($image))
                    ->resize($maxHeight, $maxWidth, function ($constraint) {
                        $constraint->upsize();
                        $constraint->aspectRatio();
                    })->interlace(true);

            $img->interlace(true)->encode(get_image_ext($img->mime()));

            if (Storage::disk('public')->put($thumbnail, $img->__toString())) {
                $response = Storage::disk('public')->url($thumbnail);
            } else {
                $response = asset($default);
            }

            ini_set('memory_limit', $tempMemory);

        } catch(\Exception $e) {
            $response = asset($default);
        }

        $response = str_replace('\\', '/', $response);
        return $response;
    }
}

if(!function_exists('get_image_ext')) {
    function get_image_ext($mime) {
        switch ($mime) {
            case 'image/gif':
                return 'gif';
                break;
            case 'image/png':
                return 'png';
                break;
            case 'image/jpeg':
                return 'jpg';
                break;
            default:
                return 'jpg';
                break;
        }
    }
}
