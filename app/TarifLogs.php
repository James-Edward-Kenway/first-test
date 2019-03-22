<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TarifLogs extends Model
{
    public $fillable = ['tarif_id','owner_id','is_user'];
    
    public function tarif(){
        return $this->hasOne('App\Tarif','id','tarif_id');
    }
}
