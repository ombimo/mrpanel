<?php

namespace Ombimo\MrPanel\Controllers;

use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\MenuRole;
use Ombimo\MrPanel\Models\Roles;
use Ombimo\MrPanel\Models\Table;

class RoleMenusController extends Controller
{
    //
    public function index()
    {
        $roles = Roles::get();
        $table = Table::with('colsView.type')
            ->where('name', 'tbz_roles')
            ->firstOrFail();

        return view('mrpanel::role-menu.index', [
            'data' => $roles,
            'table' => $table,
        ]);
    }

    public function edit($id)
    {
        $role = Roles::findOrFail($id);
        $query = "INSERT IGNORE INTO `tbz_menu_role` (`menu_id`, `role_id`) SELECT `id`, :role_id FROM `tbz_menus`";

        DB::insert($query, [
            'role_id' => $id,
        ]);
        $role = Roles::with('menus')->find($id);

        return view('mrpanel::role-menu.edit', [
            'role' => $role,
        ]);
    }

    public function editAction(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $privilage = MenuRole::find($id);
        $privilage->active = $status;
        $response['status'] = $privilage->save();
        return response()->json($response);
    }
}
