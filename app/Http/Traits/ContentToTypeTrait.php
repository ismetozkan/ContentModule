<?php

namespace App\Http\Traits;

use App\Models\ContentToType;
use Illuminate\Support\Facades\DB;

trait ContentToTypeTrait
{

    public function newContToType($type_id,$content_id){
        return ContentToType::create([
            'type_id' => $type_id,
            'content_id' => $content_id
        ]);
    }

    public function delCont($content_id){
        return ContentToType::where('content_id',$content_id)->delete();
    }

    public function delType($type_id){
        return DB::table('contents_to_types')->where('content_id',$type_id)->delete();
    }
}
