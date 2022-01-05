<?php

namespace App\Http\Traits;

use App\Models\ContentLog;

trait LogTrait
{
    public function newLog($request,$content_id){
        return ContentLog::create([
            'user_id' => $request->get('user_id'),
            'route_name' => $request->route()->getName(),
            'log' => json_encode($request->all()),
            'info' => json_encode($request->header())
        ]);

    }
}
