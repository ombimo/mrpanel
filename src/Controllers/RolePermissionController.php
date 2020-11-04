<?php

namespace Ombimo\MrPanel\Controllers;

use Ombimo\MrPanel\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\Permission;
use Ombimo\MrPanel\Models\Roles;
use Ombimo\MrPanel\Models\Table;

class RolePermissionController extends Controller
{
    //
    public function index()
    {
        $roles = Roles::get();
        $table = Table::with('colsView.type')
            ->where('name', 'tbz_roles')
            ->firstOrFail();

        return view('mrpanel::role-permission.index', [
            'data' => $roles,
            'table' => $table,
        ]);
    }

    public function edit($id)
    {
        $role = Roles::find($id);
        $query = "INSERT IGNORE INTO `tbz_permissions` (`table_id`, `role_id`) SELECT `id`, :role_id FROM `tbz_tables`";

        DB::insert($query, [
            'role_id' => $id,
        ]);
        $role = Roles::with('permissions.table')->find($id);

        return view('mrpanel::role-permission.edit', [
            'role' => $role,
        ]);
    }

    public function editAction(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $action = $request->input('action');

        $privilage = Permission::find($id);
        $privilage->{ $action } = $status;
        $response['status'] = $privilage->save();
        return response()->json($response);
    }
}
