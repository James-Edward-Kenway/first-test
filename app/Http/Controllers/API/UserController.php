<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Token;



class UserController extends Controller
{
    public function __construct()
    {
        
    }
    public function register(Request $request){

        //validation
        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation ' => 'required|password_confirmation'
        ]);

        $user = new User(['name'=>$request->get('name'), 'email'=>$request->get('email'),'password'=>$request->get('password')]);

        $user->save();

        $token = new Token();

        $token->save(['user_id'=>$user->id,'token'=>bcrypt(time().'i'.random_int())]);
        $res = [];

        if(Auth::attempt([$user->toArray()])){

            $res = ['authorized'=>1,'token'=>$token->toArray()];
        }else{

            $res = ['authorized'=>0];
        }

        return $res;
    }
    

    public function check(){

        $user = User::getByToken();
        dd($user);
        return 'good';
    }
}
