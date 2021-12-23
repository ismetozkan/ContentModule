<?php

namespace App\Http\Library;

use App\Models\ContentLog;

trait CLog
{

    public function newLog($route,$content){
        ContentLog::create([
            'route_name' => $route,
            'content_id' => $content
        ]);
    }

}
