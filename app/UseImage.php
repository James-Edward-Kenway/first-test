<?php

namespace App;


trait UseImage
{
    public function addImage(Image $image){
        $arr = json_decode($this->images);
        $arr[] = $image->relative;
        $this->images = json_encode($arr);
    }
    public function removeAllImages(){

        $arr = json_decode($this->images);
        if($arr!=null&&!empty($arr)){
            foreach($arr as $one){
                try{
                    unlink(public_path($one));
                }catch(\Exception $e){}
            }
        }
        $this->images = '[]';
    }
}
