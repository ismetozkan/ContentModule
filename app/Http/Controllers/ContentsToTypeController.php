<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentToType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function update(Request $request,$id){
        $rules = [
            'content_id' => 'nullable|integer',
            'type_id' => 'nullable|integer'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return response()->json([
                'code' => 400,
                'message' => 'Lütfen formunuzu kontrol ediniz.',
                'result' => $validator->errors()
            ]);
        }else{
            $result = Content::where('id',$id)->first();

            if($result != null){
                $result->update([
                    'content_id' => $request->get('content_id') ? $request->get('content_id') : $result->content_id,
                    'type_id' => $request->get('type_id') ? $request->get('type_id') : $result->type_id
                ]);
            }

            return $result
                ? response()->json([
                    'code' => 200,
                    'message' => 'ContentType düzenleme işleminiz başarılı bir şekilde gerçekleştirilmiştir.'
                ],200)
                : response()->json([
                    'code' => 400,
                    'message' => 'ContentType düzenleme işleminiz sırasında bir hata ile karşılaştık.Lütfen daha sonra tekrar deneyiniz.'
                ],400);
        }
    }

}
