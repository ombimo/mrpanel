<?php

namespace Ombimo\MrPanel\Controllers\Module;

use Illuminate\Http\Request;
use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Support\Facades\DB;

use Ombimo\MrPanel\Models\Table;

class DeleteController extends Controller
{
    //
    public function post(Request $request, $tableAlias)
    {
        if (!$this->permission->can_delete) {
            return mrpanel_abort(403);
        }

        $red = $request->input('red');
        $id = $request->input('id');
        $table = Table::with('colsForm.type')->where('alias', $tableAlias)->firstOrFail();
        if (empty($id)) {
            session()->flash('alert', [
                'type' => 'alert-warning',
                'msg' => 'Terjadi kesalahan, silahkan ulangi lagi'
            ]);
            return redirect(mrpanel_url($table->alias.'/view'));
        }

        $primaryCol = is_null($table->primary_col) ? 'id' : $table->primary_col;
        $result = DB::table($table->name)->where($primaryCol, $id)->delete();

        if ($result) {
            session()->flash('alert', [
                'type' => 'alert-success',
                'msg' => 'Hapus data berhasil'
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'alert-warning',
                'msg' => 'Terjadi kesalahan, silahkan ulangi lagi'
            ]);
        }
        $red = (is_null($red) || empty($red)) ? mrpanel_url($table->alias.'/view') : $red;
        return redirect($red);
    }
}
