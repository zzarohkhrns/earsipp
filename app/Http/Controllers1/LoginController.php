<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class LoginController extends Controller
{

    public function login()
    {
        $data['title'] = 'Login';
        return view('user.login', $data);
    }

    public function verifikasi(Request $request)
    {

        $request->validate([
            'nohp' => 'required',
            'password' => 'required',
        ]);

        $user = Pengguna::where(['nohp' => $request->nohp])->first();
        // dd($user);
        //dd($user->id_pengguna);
        if (!$user) {
            return redirect(route('login'))->with('pesan', 'Username atau password salah');
        }
        if ($user->password != md5($request->password)) {
            return redirect(route('login'))->with('pesan', 'Username atau password salah');
        }

        Auth::login($user, false);

        //dd(Auth::user()->sebagai);
        //$request->authenticate();

        $request->session()->regenerate();
        // dd(Auth::user()->id_pengguna);
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            return redirect('pc/dashboard');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            // dd(Auth::user()->gocap_id_upzis_pengurus);
            return redirect('upzis/dashboard');
        } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
            // dd(Auth::user()->gocap_id_ranting_pengurus);
            return redirect('ranting/dashboard');
        } else {
            return back()->withErrors([
                'password' => 'Wrong No HP or Password',
            ]);
        }
    }

    public function password()
    {
        $data['title'] = 'Change Password';
        return view('user/password', $data);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
