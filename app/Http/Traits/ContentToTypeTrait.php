<?php

namespace App\Http\Traits;

use App\Models\ContentToType;

trait ContentToTypeTrait
{

    public function newContToType($type_id,$content_id){
        ContentToType::create([
            'type_id' => $type_id,
            'content_id' => $content_id
        ]);
    }

    public function delCont($content_id){
        ContentToType::where('content_id',$content_id)->delete();
    }

    public function delype($type_id){
        ContentToType::where('type_id',$type_id)->delete();
    }
}
