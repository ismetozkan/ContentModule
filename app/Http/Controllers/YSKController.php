<?php

namespace App\Http\Controllers;

use App\Http\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Content;
use Illuminate\Support\Facades\Validator;

class YSKController extends Controller
{
    use LogTrait;

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
    }  public function create(Request $request){


        $result = new Content();
        $result->fill([
            'title' => "titttlee",
            'slug' => "ssluuugg",
            'content'=> "contoonnett",
        ]);
        /* //ROUTE NAME KOMUTU
        $route=$request->route()->getName();
        echo  $route;
        */
        $result->save();
        $this->newLog(1,$request->route()->getName(),$result->id, json_encode($request->header()));

        return $result ?
            (response()->json([
                'code' => 200,
                'message' => "Başarılı",
                'result' => $result
            ],Response::HTTP_OK)):
            response()->json([
                'code' => 400,
                'message' => "Başarısız"
            ],Response::HTTP_BAD_REQUEST);

}

    public function update(Request $request,$id){
        $result = Content::where('id',$id)->update($request->all());

        if($result != 0)
            $this->newLog(1,$request->route()->getName(),$id, "asdsa");


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

    public function delete(Request $request,$id)
    {
        //$this->newLog(1,$request->route()->getName(),$id,"a");
        $result=Content::where('id',$id)->delete();
        dd($result);

        return response()->json([
            'code' => $result  ? 200 : 400,
            'message' => $result ? 'Başarılı' : 'Başarısız',
        ],$result ? 200 : 400);
    }

}
