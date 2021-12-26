<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentToType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentsToTypeController extends Controller
{
    public function read()
    {
        $model = ContentToType::all();
        return response()->json([
            'code' => $model->count() > 0
                ? 200
                : 400,
            'message' => $model->count() > 0
                ? 'Başarılı'
                : 'Listelenecek öge bulunamadı',
            'result' => $model->count() > 0
                ? $model->toArray()
                : []
        ],$model->count() > 0
        ? Response::HTTP_OK
        : Response::HTTP_BAD_REQUEST);
    }

    public function create(Request $request)
    {
       /*
        $res = new Content();
        $res->fill([
            'title' => $request->get('title')
        ]);
        $result = $res->save();
        $res->contentToType()->create([
            'content_id' => $result->id,
            'type_id' => $request->get('type_id')
        ]);
       */
    }
}
