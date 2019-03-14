<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Token;
use Illuminate\Support\Facades\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if(Request::header('xx-token',false)&&Request::header('xx-user-id',false)){
            $t = Token::where('user_id', Request::header('xx-user-id',false))->where('token',Request::header('xx-token',false))->first();
            if($t!=null){
                $user = $t->user;
                $user->currentToken = $t;
                if($user!=null){
                    \Auth::login($user);
                }else{
                    $t->delete();
                }
            }
        }

    }
}
