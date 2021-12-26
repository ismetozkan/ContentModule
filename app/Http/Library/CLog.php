<?php

namespace App\Http\Library;

use App\Models\ContentLog;

trait CLog
{

    public function newLog($user_id,$route,$content_id,$log = null){
        ContentLog::create([
            'user_id' => $user_id,
            'route_name' => $route,
            'content_id' => $content_id,
            'log' => $log
        ]);
    }

}
