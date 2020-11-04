<?php

namespace Ombimo\MrPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'tbz_roles';

    public function privilages()
    {
        return $this->hasMany('Ombimo\MrPanel\Models\Privilages', 'roles_id');
    }

    public function permissions()
    {
        return $this->hasMany('Ombimo\MrPanel\Models\Permission', 'role_id');
    }

    public function menus()
    {
        return $this->belongsToMany(
            'Ombimo\MrPanel\Models\Menu',
            'tbz_menu_role',
            'role_id',
            'menu_id')->withPivot(['active', 'id'])
            ->orderBy('position');
    }

    public function active_menus()
    {
        return $this->belongsToMany(
            'Ombimo\MrPanel\Models\Menu',
            'tbz_menu_role',
            'role_id',
            'menu_id')->withPivot(['active', 'id'])
            ->wherePivot('active', true)
            ->orderBy('position');
    }
}
