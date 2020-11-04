<?php

namespace Ombimo\MrPanel\Models;

use Illuminate\Database\Eloquent\Model;

class TableCols extends Model
{
    protected $table = 'tbz_table_cols';

    public function type()
    {
        return $this->belongsTo('Ombimo\MrPanel\Models\InputType', 'type_id');
    }
}
