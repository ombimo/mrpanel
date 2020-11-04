<?php

namespace Ombimo\MrPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'tbz_menus';
    protected $fillable = ['name'];

    public function table()
    {
        return $this->belongsTo('Ombimo\MrPanel\Models\Table', 'table_id');
    }
}
