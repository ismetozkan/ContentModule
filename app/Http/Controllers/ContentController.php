<?php

namespace App\Http\Controllers;

use App\Http\Library\CLog;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

////LOG TUTULACAK. YAPILMADI DAHA. TRAİT YAZ T-LOG ADINDA. LOG FONKSİYONUNA ARRAY GÖNDER PARAMETRE


class ContentController extends Controller
{
    use CLog;
    public function read(){
        $model = Content::all();
        return $model->count() > 0
            ? response()->json([
                'code' => 200,
                'message' => 'Başarılı',
                'result' => $model->all()
            ],Response::HTTP_OK)
            : response()->json([
                'code' => 400,
                'message' => 'Gösterilecek içerik bulunamadı.',
            ],Response::HTTP_BAD_REQUEST);
    }

    public function create(Request $request){

        $rules = [
            'title' => 'required|string',
            'slug' => 'required|string',
            'content'=>'required|string'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'code' => 400,
                'message' => "Lütfen formunuzu kontrol ediniz.",
                'result' => $validator->errors()
            ]);
        }else{
                $result = new Content();
                $result->fill([
                    'title' => $request->get('title'),
                    'slug' => $request->get('slug'),
                    'content'=>$request->get('content'),
                ]);

            $result->save();
            $result->contentToType()->create([
                'content_id' => $result->id,
                'type_id' => $request->get('type_id')
            ]);



                return $result ?
                    $this->newLog($request->route()->getName(),"a") &&
                    response()->json([
                    'code' => 200,
                    'message' => "Başarılı",
                    'result' => $result
                ],Response::HTTP_OK) :
                    response()->json([
                        'code' => 400,
                        'message' => "Başarısız"
                    ],Response::HTTP_BAD_REQUEST);

        }
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
                    'code' => 400,
                    'message' => 'Gösterilecek veri bulunamadı.'
                ]);
    }

    public function update(Request $request, $id){
        $rules = [
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'content' => 'nullable|string',
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

    public function delete(Request $request,$id)
    {
        $result=Content::where('id',$id)->delete();

        return response()->json([
            'code' => $result  ? 200 : 400,
            'message' => $result ? 'Başarılı' : 'Başarısız',
        ],$result ? 200 : 400);
    }

}
