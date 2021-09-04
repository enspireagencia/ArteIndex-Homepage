<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    public function authenticate(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json(['status'=>'success','message'=>'All is cool! You have successfully login']);
        }
        return response()->json(['status'=>'error','message'=>'Please enter proper email and password.']);
    }
}