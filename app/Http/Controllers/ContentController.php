<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentToType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

////LOG TUTULACAK. YAPILMADI DAHA. TRAİT YAZ T-LOG ADINDA. LOG FONKSİYONUNA ARRAY GÖNDER PARAMETRE


class ContentController extends Controller
{

    public function create(Request $request){
        $rules = [
            'description' => 'required|string',
            'slug' => 'required|string'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'code' => 400,
                'message' => "Lütfen formunuzu kontrol ediniz.",
                'result' => $validator->errors()
            ]);
        }else{
                $result = Content::create([
                    'description' => $request->get('description'),
                    'slug' => $request->get('slug')
                ]);

                return $result ?
                    response()->json([
                    'code' => 200,
                    'message' => "Content oluşturma işleminiz başarılı bir şekilde gerçekleştirilmiştir.",
                    'result' => $result
                ]) :
                    response()->json([
                        'code' => 400,
                        'message' => "Contentoluşturma işleminiz sırasında bir hata ile karşılaştık.Lütfen daha sonra tekrar deneyiniz."
                    ],400);

        }

    }

    public function read(){
        $model = Content::all();
        return $model->count() > 0
            ? response()->json([
                'code' => 200,
                'message' => 'Başarılı',
                'result' => $model->all()
            ],200)
            : response()->json([
                'code' => 200,
                'message' => 'Gösterilecek kategori bulunamadı.',
            ],200);
    }

    public function view(Request $request,$id){
        $model = Content::where('id',$id)->get()->toArray();
        return $model != null
            ?  response()->json([
                'code' => 200,
                'message' => 'Başarılı',
                'result' => $model
            ]) :
                response()->json([
                    'code' => 200,
                    'message' => 'Gösterilecek veri bulunamadı.'
                ]);
    }

    public function update(Request $request, $id){
        $rules = [
            'description' => 'nullable|string',
            'slug' => 'nullable|string',
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
            $result = Content::where('id',$id)->update($request->all());

            return $result
                ? response()->json([
                    'code' => 200,
                    'message' => 'Content düzenleme işleminiz başarılı bir şekilde gerçekleştirilmiştir.'
                ],200)
                : response()->json([
                    'code' => 400,
                    'message' => 'Content düzenleme işleminiz sırasında bir hata ile karşılaştık.Lütfen daha sonra tekrar deneyiniz.'
                ],400);
        }
    }

    public function delete(Request $request,$id){
        $rules = [
            'description' => 'nullable|string',
            'slug' => 'nullable|string',
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
            $result = Content::where('id',$id)->delete();

            if($result)
            {
                ContentToType::where('content_id',$id)->delete();

                return response()->json([
                    'code' => 200,
                    'message' => 'Content silme işleminiz başarılı bir şekilde gerçekleştirilmiştir.'
                ],200);
            }else{
                return response()->json([
                    'code' => 400,
                    'message' => 'Content silme işleminiz sırasında bir hata ile karşılaştık.Lütfen daha sonra tekrar deneyiniz.'
                ],400);
            }
        }

    }
}
