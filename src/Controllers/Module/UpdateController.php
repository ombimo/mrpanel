<?php

namespace Ombimo\MrPanel\Controllers\Module;

use Illuminate\Http\Request;
use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\Table;

class UpdateController extends Controller
{
    //
    public function get(Request $request, $tableAlias, $id)
    {
        if (!$this->permission->can_update) {
            return mrpanel_abort(403);
        }

        $table = Table::with('colsForm.type')->where('alias', $tableAlias)->firstOrFail();
        session([
            'ref.update.'.$tableAlias => url()->previous()
        ]);
        $additional = json_decode($table->additional) ?: [];
        foreach ($additional as $key => $value) {
            $additional[$key]->table = Table::with('colsForm.type', 'colsView.type')->where('name', $value->table)->first();
        }

        //ambil data
        $data = DB::table($table->name)->where($table->primary_col, $id)->first();

        //ambil addon
        if (!empty($table->addon)) {
            $dataAddon = json_decode($table->addon);
        } else {
            $dataAddon = [];
        }
        if (is_null($dataAddon)) {
            $dataAddon = [];
        }
        return view('mrpanel::module.update.index', [
            'table' => $table,
            'data' => $data,
            'id' => $id,
            'dataAddon' => $dataAddon
        ]);
    }

    public function post(Request $request, $tableAlias, $id)
    {
        if (!$this->permission->can_update) {
            return mrpanel_abort(403);
        }

        $table = Table::with('colsForm.type')->where('alias', $tableAlias)->firstOrFail();

        foreach ($table->colsForm as $col) {
            $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
            $inputClass = new $inputClass();
            $result = $inputClass::getInput($col);
            if ($result['return']) {
                $dataDB[$col->col_name] = $result['data'];
            }
        }

        if(!is_null($table->updated_col) && $table->updated_col != '') {
            $dataDB[$table->updated_col] = now();
        }


        $result = DB::table($table->name)
            ->where($table->primary_col, $id)
            ->update($dataDB);
        if ($result) {
            session()->flash('alert', [
                'type' => 'alert-success',
                'msg' => 'Ubah data '. $table->label .' berhasil'
            ]);
            return redirect(session('ref.update.'.$tableAlias, mrpanel_url($tableAlias.'/view')));
        } else {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Terjadi kesalahan saat ubah data, silahkan ulangi lagi'
            ]);
            return redirect(mrpanel_url($table->alias.'/update/'.$id))->withInput();
        }
    }
}
