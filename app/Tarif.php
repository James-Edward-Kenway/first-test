<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    
    public $fillable = ['name','is_user', 'description', 'limits','price','duration'];

    //[[1,-1],[1,-1],[1,-1],[1,-1],[1,10000]];
    //[limit_type, Count];
    public function apply($is_user,$id){

        $lims = json_decode($this->limits);
        if($is_user){

            foreach($lims as $lem){
                $lim = new UserLimit();
    
                $lim->user_id = $id;
                $lim->type = $lem[0];
                $lim->count = $lem[1];
                $lim->till = date('Y-m-d H:i:s',time()+$this->duration);
                $lim->save();
            }

        }else{

            foreach($lims as $lem){
                $lim = new Limit();
    
                $lim->store_id = $id;
                $lim->type = $lem[0];
                $lim->count = $lem[1];
                $lim->till = date('Y-m-d H:i:s',time()+$this->duration);
                $lim->save();
            }


        }
    }
}
