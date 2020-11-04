<?php

namespace Ombimo\MrPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'tbz_permissions';

    public function table()
    {
        return $this->belongsTo('Ombimo\MrPanel\Models\Table', 'table_id');
    }
}
