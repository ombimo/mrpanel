<?php

namespace Ombimo\MrPanel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function login()
    {
        if (session()->has('mrpanel.admin') or session()->get('mrpanel.admin.login'))
        {
            return redirect()->route('mrpanel.dashboard');
        }
        return view('mrpanel::login');
    }

    public function loginAction(Request $request)
    {
        $username = $request->input('username');
        $pass = $request->input('password');

        $validator = Validator::make(request()->only(['username', 'password']), [
            'username' => 'required|exists:tbz_admin,username',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('mrpanel.alert', [
                'type' => 'alert-danger',
                'msg' => 'Ada kesalahan dalam data yang kamu berikan'
            ]);
            return redirect()->route('mrpanel.login')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = DB::table('tbz_admin')->where('username', $username)->first();

        if (!Hash::check($pass, $user->password)) {
            session()->flash('mrpanel.alert', [
                'type' => 'alert-danger',
                'msg' => 'Password salah'
            ]);
            return redirect()->route('mrpanel.login')
                        ->withInput();
        }

        $ses['mrpanel'] = [
            'admin' => [
                'login' => true,
                'admin_id' => $user->id
            ]
        ];
        session($ses);
        return redirect()->route('mrpanel.dashboard');
    }

    public function logoutAction()
    {
        session()->forget('mrpanel');
        return redirect()->route('mrpanel.login');
    }
}
