<?php

namespace Ombimo\MrPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Table extends Model
{
    protected $table = 'tbz_tables';

    public function scopeFromAlias($query, $alias)
    {
        return $query->where('alias', $alias);
    }

    public function cols()
    {
        return $this->hasMany('Ombimo\MrPanel\Models\TableCols', 'table_id')
                ->orderBy('id');
    }

    public function colsView()
    {
        return $this->hasMany('Ombimo\MrPanel\Models\TableCols', 'table_id')
            ->where('view', true)
            ->orderBy('posisi_view');
    }

    public function colsForm()
    {
        return $this->hasMany('Ombimo\MrPanel\Models\TableCols', 'table_id')
            ->where('form', true)
            ->orderBy('posisi_form');
    }

    public function hasSearchable()
    {
        return $this->searchable()->isNotEmpty();
    }

    public function searchable()
    {
        $filtered = $this->cols->where('searchable', true);
        return $filtered;
    }

    public function getPrimaryColAttribute($value)
    {
        if (is_null($value)) {
            $value = 'id';
        }
        return $value;
    }

    public function getAdditionalAttribute($value)
    {
        if (is_null($value) || empty($value)) {
            $value = '[]';
        }
        return $value;
    }

    /*public function getCreatedColAttribute($value)
    {
        if (is_null($value)) {
            $value = 'created_at';
        }
        return $value;
    }

    public function getUpdatedColAttribute($value)
    {
        if (is_null($value)) {
            $value = 'updated_at';
        }
        return $value;
    }*/

    public function getTitleAttribute()
    {
        $filter = ['-', '_'];
        return empty($this->label) ? Str::title(str_replace($filter , ' ', $this->alias)) : $this->label;
    }
}
