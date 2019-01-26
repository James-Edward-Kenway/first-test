<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Request;

class Token extends Model
{
    public $fillable = ['id','token','description','user_id'];

    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }
    public static function current(){
        return Token::where('user_id', @Request::capture()->get('user_id'))
        ->where('token', @Request::capture()->get('token'))->first();
    }
}
