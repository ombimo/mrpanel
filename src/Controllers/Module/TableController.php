<?php

namespace Ombimo\MrPanel\Controllers\Module;

use Illuminate\Http\Request;
use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Support\Facades\DB;

use Ombimo\MrPanel\Models\Table;

class TableController extends Controller
{
    //
    public function get(Request $request, $id = '')
    {

        return view('mrpanel::module.table.index', [

        ]);
    }

    public function post(Request $request, $tableAlias)
    {
        $table = Table::with('colsForm.type')->where('alias', $tableAlias)->firstOrFail();

        foreach ($table->colsForm as $col) {
            $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
            $inputClass = new $inputClass();
            $result = $inputClass::getInput($col);
            if ($result['return']) {
                $dataDB[$col->col_name] = $result['data'];
            }
        }

        if (is_null($table->created_col)) {
            $dataDB['created_at'] = now();
        }
        if(is_null($table->updated_col)) {
            $dataDB['updated_at'] = now();
        }

        $result = DB::table($table->name)->insert($dataDB);

        if ($result) {
            session()->flash('alert', [
                'type' => 'alert-success',
                'msg' => 'Tambah data '. $table->label .' berhasil'
            ]);
            return redirect(mrpanel_url($table->alias.'/view'));
        } else {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Terjadi kesalahan saat menyimpan data, silahkan ulangi lagi'
            ]);
            return redirect(mrpanel_url($table->alias.'/create'))->withInput();
        }
    }
}
