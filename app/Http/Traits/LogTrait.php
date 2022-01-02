<?php

namespace App\Http\Traits;

use App\Models\ContentLog;
use GuzzleHttp\Psr7\Request;

trait LogTrait
{
    public function newLog($user_id = null,$route,$content_id ,$log){
        ContentLog::create([
            'user_id' => $user_id,
            'route_name' => $route,
            'content_id' => $content_id,
            'log' => $log
        ]);

    }
}
