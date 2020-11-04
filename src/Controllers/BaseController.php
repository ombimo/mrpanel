<?php

namespace Ombimo\MrPanel\Controllers;

use App\Http\Controllers\Controller;
use Ombimo\MrPanel\Models\Admin;
use Ombimo\MrPanel\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    protected $admin;

    protected $role;

    protected $permission;

    protected $tableAlias;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $route = $request->route();

            $id = session()->get('mrpanel.admin.admin_id');
            $this->admin = Admin::with('role')->find($id);

            if ($this->admin->is_superadmin) {
                $menu = Menu::with('table')->orderBy('position')->get();
            } else {
                $this->role = $this->admin->role;
                $menu = optional($this->role)->active_menus ?? [];
            }

            if (empty($this->tableAlias)) {
                $this->tableAlias = $route->parameter('tableAlias');
            }

            $this->getPermission();

            View::share('dataMenu', $menu);
            View::share('admin', $this->admin);
            View::share('role', $this->role);
            View::share('permission', $this->permission);

            return $next($request);
        });
    }

    public function getPermission()
    {

        if ($this->admin->is_superadmin) {
            $this->permission = superadmin_permission();
        } else {
            $this->permission = $this->role->permissions()->whereHas('table', function ($query) {
                $query->where('alias', $this->tableAlias);
            })->first();

            if ($this->permission == null) {
                $this->permission = blank_permission();
            }
        }
    }
}
