<?php

namespace App\Http\Traits;

use GuzzleHttp\Psr7\Request;

trait LogTrait
{
    public function logTrait(Request $request )
    {
        $result->save();
        $result->typeToLog()->create([

            'user_id' => $request->get('user_id'),
            'content_id' => $request->get('content_id'),
            'route_name'=>$request->route()->getName(),
            'log' => $result->type,
    }
}
