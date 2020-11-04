<?php

namespace Ombimo\MrPanel\Controllers\Module;

use Illuminate\Http\Request;
use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Support\Facades\DB;

use Ombimo\MrPanel\Models\Table;

class ViewDtController extends Controller
{
    //
    public function get(Request $request, $tableAlias)
    {
        //$perpage = intval($request->query('perpage', 10));
        //$page = intval($request->query('page', 1));
        $table = Table::with('colsView.type')->where('alias', $tableAlias)->firstOrFail();
        //$searchCol = $request->query('col');
        //$keyword = $request->query('keyword') ?: '';
        /*$appends = [
            'perpage' => $perpage
        ];*/
        $data = DB::table($table->name);

        //jika ada search
        /*if (!is_null($searchCol)) {
            $data = $data->where($searchCol, 'LIKE', '%'.$keyword.'%');
            $appends['col'] = $searchCol;
            $appends['keyword'] = $keyword;
        }*/

        if ($table->created_col != '') {
            $data = $data->orderByDesc($table->primary_col);
        } else {
            $data = $data->orderByDesc('created_at');
        }

        //$data = $data->paginate($perpage);

        //$data->appends(['perpage' => $perpage]);
        $data = $data->get();

        return view('mrpanel::module.view-dt.index', [
            'table' => $table,
            'data' => $data,
            //'startNum' => ($page -1 ) * $perpage,
            //'searchCol' => $searchCol,
            //'keyword' => $keyword
        ]);
    }
}
