<?php

namespace Ombimo\MrPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbz_admin';

    public function role()
    {
        return $this->belongsTo('Ombimo\MrPanel\Models\Roles', 'role_id');
    }
}
