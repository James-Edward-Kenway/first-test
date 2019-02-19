<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Token;



class UserController extends Controller
{
    public function __construct(Request $request)
    {
        if($request->has('token')&&$request->has('user_id')){
            $this->user = Token::where('user_id',$request->get('user_id'))->where('token',$request->get('token'))->first()->user;
            if($this->user!=null){
                $this->authenticated = true;
            }
        }
    }

    public $authenticated = false;
    public $user = null;

    public function register(Request $request){

        //validation
        $validate = validator($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'imei' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        if($validate->fails()){
            return $validate->errors();
        }

        $user = new User(['name'=>$request->get('name'), 'email'=>$request->get('email'),'password'=>$request->get('password')]);

        $user->save();

        $token = new Token(['user_id'=>$user->id,'token'=>bcrypt(microtime().'i'.random_int(0,100000)),'description'=>$this->tokenDesc()]);

        $token->save();
        $res = [];

        $res = ['authorized'=>1,'token'=>$token->toArray()];

        return $res;
    }
    
    public function login(Request $request){

        //validation
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
            'imei' => 'required',
        ]);

        $user = User::where('email',$request->get('email'))->first();


        $token = new Token(['user_id'=>$user->id,'token'=>bcrypt(microtime().'i'.random_int(0,100000)),'description'=>$this->tokenDesc()]);

        $token->save();
        $res = [];

        $res = ['authorized'=>1,'token'=>$token->toArray()];

        return $res;
    }

    public function tokenDesc(){
        return '';
    }

    public function check(){

        dd($this->user);
    }
}
