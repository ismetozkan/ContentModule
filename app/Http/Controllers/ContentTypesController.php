<?php

namespace App\Http\Controllers;

use App\Models\ContentTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ContentTypesController extends Controller
{
    public function read(Request $request)
    {
        $model= ContentTypes::all();
        return $model->count() > 0
            ? response()->json([
                'code' => 200,
                'message' => 'Başarılı',
                'result' => $model->all()
            ],Response::HTTP_OK)
            : response()->json([
                'code' => 400,
                'message' => 'Gösterilecek içerik tipi bulunamadı.',
            ],Response::HTTP_BAD_REQUEST);
    }

    public function create(Request $request)
    {
        $rules = [
            'type'=>'required|in:blog,page,other',
            'template'=>'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->messages()
            ], Response::HTTP_BAD_REQUEST );
        } else {
            $result=new ContentTypes();
            $result->fill([
                'type' => $request->get('type'),
                'template' => $request->get('template'),

            ]);
            $result->save();
            $result->typeToLog()->create([
                'log' => $result->type,
              //type_id' => $request->get('type_id')
            ]);

            return response()->json([
                'code' => $result ? 200 : 400,
                'message' => $result
                    ? 'Başarılı'
                    : 'Başarısız',
            ], $result
                ? 200
                : 400);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'type' => 'nullable|string|in:blog,page,other',
            'template' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Lütfen formunuzu kontrol ediniz.',
                'result' => $validator->errors()
            ]);
        } else {
            $result = ContentTypes::where('id', $id)->update($request->all());

            return $result
                ? response()->json([
                    'code' => 200,
                    'message' => 'Başarılı.'
                ], Response::HTTP_OK)
                : response()->json([
                    'code' => 400,
                    'message' => 'Başarısız'
                ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(Request $request,$id)
    {
        $result=ContentTypes::where('id',$id)->delete();

        return response()->json([
            'code' => $result  ? 200 : 400,
            'message' => $result ? 'Başarılı' : 'Başarısız',
        ],$result ? 200 : 400);
    }

    public function view(Request $request,$id)
    {
        $model = ContentTypes::where('id', $id)->get()->toArray();
        return $model
            ? response()->json([
                'code' => 200,
                'message' => 'Başarılı',
                'result' => $model
            ]) :
            response()->json([
                'code' => 400,
                'message' => 'Gösterilecek veri bulunamadı.'
            ]);
    }
}
