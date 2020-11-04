<?php

namespace Ombimo\MrPanel\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Ombimo\MrPanel\Models\Page;
use Ombimo\MrPanel\Models\Admin;
use Ombimo\MrPanel\Models\Menu;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $acc = false;
        $curPages = null;
        //cek apakah sudah login
        if (!session()->has('mrpanel.admin') or !session()->get('mrpanel.admin.login')) {
            return redirect()->route('mrpanel.login');
        }

        /*$route = \Route::current();
        dd($route);

        $tableAlias = $route->parameter('tableAlias');
        $routeName = $route->getName();
        */
        //preg_match('/mrpanel\.module\.([a-z-]+)\.*/', $routeName, $temp);
        /*$moduleName = isset($temp[1]) ? $temp[1]: null ;

        if ($admin->roles->is_superadmin) {
            $pages = Page::with('table')
            ->where('side_menu', true)
            ->orderBy('parent_id')->orderBy('position')->get();
            $acc = true;
            $superAdmin = true;
        } else {
            $superAdmin = false;
            $pages = $admin->roles->pages;

            //jika punya
            if (!is_null($tableAlias) && !is_null($moduleName)) {
                $acc = $pages->where('table.alias', $tableAlias)
                          ->where('module', $moduleName)->isNotEmpty();
            } elseif (!is_null($routeName)) {
                $acc = $pages->where('route_name', $routeName)->isNotEmpty();
            }

            if ($routeName === 'mrpanel.dashboard') {
                $acc = true;
            }
        }

        if (!is_null($tableAlias) && !is_null($moduleName)) {
            $curPages = Page::where('module', $moduleName)->whereHas('table', function ($query) use ($tableAlias) {
                $query->where('alias', $tableAlias);
            })->first();
        }

        //debug
        if (0) {
            dump($route);
            dump($pages);
        }

        //exit();
        //dd($pages);
        //
        if (!$acc) {
            return mrpanel_abort(403);
            exit();
        }

        $request->attributes->add(['menu_pages' => $pages]);
        $request->attributes->add(['cur_pages' => $curPages]);

        //share menuPages to view
        View::share('curPages', $curPages);
        */

        return $next($request);
    }
}
