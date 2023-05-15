<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{

    public function getLogin() {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $rememberme = $request->input('rememberme') == 1 ? true : false ;
        if(auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')], $rememberme)){
            $user = auth()->guard('admin')->user();
            return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
        }else {
            return redirect()->back()->with('error', 'Whoops! invalid email and password');

        }
    }

    public function logout() {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }

    public function view($id) {
        $admin = Admin::find($id);
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request, $id) {
        $admin = Admin::find($id);
        $admin->username = $request->get('username');
        $admin->password = Hash::make($request->get('password'));
        $admin->email = $request->get('email');
        $admin->save();
        $message = 'updated done';
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $admin->clearMediaCollection('avatar');
            $admin->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
        return redirect()->back()->withSuccess($message);
    }
}
