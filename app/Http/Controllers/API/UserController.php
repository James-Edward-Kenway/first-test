<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        
    }
    public function register(Request $request){

        //validation
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation ' => 'required|password_confirmation'
        ]);

        $user = new User(['name'=>$request->get('name'), 'email'=>$request->get('email'),'password'=>$request->get('password')]);

        $user->save();

        $res = [];
        if(Auth::attempt([$user->toArray()])){
            $res = ['code'=>1];
        }else{
            $res = ['code'=>0];
        }

        return $res;
    }
}
