<?php

namespace Ombimo\MrPanel\Controllers;

use Illuminate\Http\Request;
use Ombimo\MrPanel\Controllers\BaseController as Controller;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //$roles = \Ombimo\MrPanel\App\Roles::find(4);
        //$roles->pages()->attach(1, ['can_see' => true]);
        //$roles->pages()->sync([37 => ['can_see' => true]]);
        //dd($roles->pages);
        //exit();
        return view('mrpanel::dashboard');
    }
}
