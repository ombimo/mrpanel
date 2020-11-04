<?php

namespace Ombimo\MrPanel\Controllers;

use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ombimo\MrPanel\Models\InputType;
use Ombimo\MrPanel\Models\Table;

class TableController extends Controller
{
    //
    public function index()
    {
        //masukin ke table ke database
        $tables = array_map('reset', DB::select('SHOW TABLES'));
        $newTables = [];
        foreach ($tables as $table) {
            $newTables[] = [
                'name' => $table,
                'alias' => Str::of($table)->replace('_', '-'),
            ];
        }
        Table::insertOrIgnore($newTables);

        $tbzTable = array_column(Table::get()->toArray(), null, 'name');

        return view('mrpanel::table.index', [
            'tables' => $tables,
            'tbzTable' => $tbzTable,
        ]);
    }

    public function edit($tableAlias)
    {
        $table = Table::fromAlias($tableAlias)->first();
        $cols = DB::select("SHOW COLUMNS FROM $table->name");
        $type = InputType::get();

        //masukin ke table ke database
        $first = true;
        $query = "INSERT IGNORE INTO `tbz_table_cols` (`table_id`, `col_name`) VALUES ";
        foreach ($cols as $col) {
            if (!$first) {
                $query .= ',';
            }
            $query .= "('$table->id', '$col->Field')";
            $first = false;
        }
        $query .= ';';

        DB::insert($query);
        return view('mrpanel::table.edit', [
            'table' => $table,
            'cols' => $cols,
            'type' => $type,
        ]);
    }

    public function editAction(Request $request, $tableAlias)
    {
        //dd($request->input('additional'));
        $table = Table::fromAlias($tableAlias)->first();

        $table->alias = $request->input('alias');
        $table->label = $request->input('label');
        $table->primary_col = $request->input('primary_col');
        $table->created_col = $request->input('created_col');
        $table->updated_col = $request->input('updated_col');
        $table->publish = $request->input('publish') ?: 0;
        $table->additional = $request->input('additional');
        $table->save();

        $tableID = $table->id;
        $query = "INSERT INTO tbz_table_cols
        (table_id, searchable, col_name, label, help_text, type_id, view, form, empty_checker, config_view, config_form, posisi_view, posisi_form, updated_at)
        VALUES";
        $first = true;
        $param = [];
        foreach ($table->cols as $col) {
            $label = $request->input('cols.' . $col->col_name . '.label') ?: '';
            $helpText = $request->input('cols.' . $col->col_name . '.help_text') ?: '';
            $typeID = $request->input('cols.' . $col->col_name . '.type_id');
            $view = $request->input('cols.' . $col->col_name . '.view') ?: 0;
            $form = $request->input('cols.' . $col->col_name . '.form') ?: 0;
            $emptyChecker = $request->input('cols.' . $col->col_name . '.empty_checker') ?: 0;
            $searchable = $request->input('cols.' . $col->col_name . '.searchable') ?: 0;
            //$configView = $request->input('cols.'.$col->col_name.'.');
            $configView = '';
            $configForm = $request->input('cols.' . $col->col_name . '.config') ?: '';
            $posisiForm = $request->input('cols.' . $col->col_name . '.posisi_form') ?: 0;
            $posisiView = $request->input('cols.' . $col->col_name . '.posisi_view') ?: 0;

            if (!$first) {
                $query .= ',';
            }
            $query .= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $first = false;
            $param[] = $table->id;
            $param[] = $searchable;
            $param[] = $col->col_name;
            $param[] = $label;
            $param[] = $helpText;
            $param[] = $typeID;
            $param[] = $view;
            $param[] = $form;
            $param[] = $emptyChecker;
            $param[] = $configView;
            $param[] = $configForm;
            $param[] = $posisiView;
            $param[] = $posisiForm;
        }

        $query .= "ON DUPLICATE KEY
        UPDATE label = VALUES(label), searchable = VALUES(searchable), help_text = VALUES(help_text), type_id = VALUES(type_id), view = VALUES(view), form = VALUES(form), empty_checker = VALUES(empty_checker), config_view = VALUES(config_view), config_form = VALUES(config_form), posisi_view = VALUES(posisi_view), posisi_form = VALUES(posisi_form), updated_at = VALUES(updated_at)";

        //echo $query;
        //echo json_encode($param);exit();

        $result = DB::insert($query, $param);
        if ($result) {
            session()->flash('mrpanel.alert', [
                'type' => 'alert-success',
                'msg' => 'Ubah table berhasil',
            ]);
        } else {
            session()->flash('mrpanel.alert', [
                'type' => 'alert-danger',
                'msg' => 'Ubah table gagal',
            ]);
        }

        return redirect()->route('mrpanel.table.edit', ['tableAlias' => $table->alias]);
    }
}
