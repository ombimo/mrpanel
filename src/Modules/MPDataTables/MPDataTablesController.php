<?php

namespace Ombimo\MrPanel\Modules\MPDataTables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\Table;


class MPDataTablesController extends Controller
{
    //
    public function get(Request $request, $tableAlias, $id = null)
    {
        $selectKey = null;
        $selectIndex = null;
        //ambil dari get
        $searchCol = $request->query('search');
        $keyword = $request->query('keyword') ?: '';
        $strict = $request->query('strict', false);

        $table = Table::with('colsView.type')->where('alias', $tableAlias)->firstOrFail();

        $data = DB::table($table->name);

        //jika ada search
        if (!is_null($searchCol)) {
            if ($strict) {
                $data = $data->where($searchCol, 'LIKE', $keyword);
            } else {
                $data = $data->where($searchCol, 'LIKE', '%'.$keyword.'%');
            }

            $appends['col'] = $searchCol;
            $appends['keyword'] = $keyword;
        }

        //ambil data
        $data = $data->get();
        if ($data->isEmpty()) {
            return response()->json([
                'data' => []
            ]);
        } else {
            foreach ($data as $key => $value) {
            //primary key as id
                $responseData[$key]['id'] = $value->{$table->primary_col};
                foreach ($table->colsView as $col) {
                    $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
                    $inputClass = new $inputClass();
                    if ($col->empty_checker) {
                        if (empty($value->{$col->col_name})) {
                            $responseData[$key][$col->col_name] = '<div class="text-danger"><i class="fa fa-times"></i></div>';
                        } else {
                           $responseData[$key][$col->col_name] = '<div class="text-success"><i class="fa fa-check"></i></div>';
                        }
                    } else {
                        $responseData[$key][$col->col_name] = $value->{$col->col_name};
                    }


                    //jika inputnya select
                    if ($col->type->class === 'Select' || $col->type->class === 'Select2') {
                        $selectKey[$col->col_name][] = $value->{$col->col_name};
                        $selectIndex[$col->col_name][$key] = $value->{$col->col_name};
                        $responseData[$key][$col->col_name. '__value'] = null;
                    }//end if select

                }//end foreach cols
            }//end foreach data

            //ambil nilai dari select
            foreach ($table->colsView as $col) {
                if ($col->type->class === 'Select' || $col->type->class === 'Select2') {
                    $config = json_decode($col->config_form);

                    $selectValue[$col->col_name] = DB::table($config->source->name)
                        ->select($config->source->col_id . ' as id', $config->source->col_value . ' as value')
                        ->wherein($config->source->col_id, $selectKey[$col->col_name])
                        ->get()
                        ->mapWithKeys(function ($item) {
                            return [$item->id => $item->value];
                    });
                }
            }

            //tambahkan value select
            foreach ($data as $key => $value) {
                foreach ($table->colsView as $col) {
                    if ($col->type->class === 'Select' || $col->type->class === 'Select2') {

                        //jika inputnya select
                        if ($col->type->class === 'Select' || $col->type->class === 'Select2') {
                            if (isset($selectValue[$col->col_name][$value->{$col->col_name}])) {
                                $responseData[$key][$col->col_name . '__value'] = $selectValue[$col->col_name][$value->{$col->col_name}];
                            }

                        }//end if select
                    }
                }
            }


            return response()->json([
                'data' => $responseData
            ]);
        }
    }
}
