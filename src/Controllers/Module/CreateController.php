<?php

namespace Ombimo\MrPanel\Controllers\Module;

use Illuminate\Http\Request;
use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Support\Facades\DB;

use Ombimo\MrPanel\Models\Table;

class CreateController extends Controller
{
    //
    public function get(Request $request, $tableAlias)
    {
        if (!$this->permission->can_create) {
            return mrpanel_abort(403);
        }

        $table = Table::with('colsForm.type')->where('alias', $tableAlias)->firstOrFail();

        return view('mrpanel::module.create.index', [
            'table' => $table
        ]);
    }

    public function post(Request $request, $tableAlias)
    {
        //dd($request->all());
        if (!$this->permission->can_create) {
            return mrpanel_abort(403);
        }

        $table = Table::with('colsForm.type')->where('alias', $tableAlias)->firstOrFail();
        $from = $request->input('mrpanel_from');
        $red = $request->input('mrpanel_red');

        foreach ($table->colsForm as $col) {
            $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
            $inputClass = new $inputClass();
            $result = $inputClass::getInput($col);
            if ($result['return']) {
                $dataDB[$col->col_name] = $result['data'];
            }
        }

        if (!is_null($table->created_col) && $table->created_col != '') {
            $dataDB[$table->created_col] = now();
        }
        if (!is_null($table->updated_col) && $table->updated_col != '') {
            $dataDB[$table->updated_col] = now();
        }

        if (!is_null($from)) {
            $addTable = Table::with('colsForm.type')->where('alias', $from)->first();
            $additional = collect(json_decode($addTable->additional))->where('table', $table->name)->first();
            $dataDB[$additional->foreign_key] = $request->input($additional->foreign_key);
        }

        $result = DB::table($table->name)->insert($dataDB);

        if ($result) {
            session()->flash('alert', [
                'type' => 'alert-success',
                'msg' => 'Tambah data '. $table->label .' berhasil'
            ]);
            $red = is_null($red) ? mrpanel_url($table->alias.'/view') : $red;
            return redirect($red);
        } else {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Terjadi kesalahan saat menyimpan data, silahkan ulangi lagi'
            ]);
            return redirect(mrpanel_url($table->alias.'/create'))->withInput();
        }
    }
}
