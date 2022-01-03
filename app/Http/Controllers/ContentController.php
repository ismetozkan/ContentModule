<?php

namespace App\Http\Controllers;

use App\Http\Traits\ContentToTypeTrait;
use App\Http\Traits\LogTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ContentController extends Controller
{
    use LogTrait ,ContentToTypeTrait, ResponseTrait;
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
            'type_id' => 'required|integer',
            'title' => 'required|string',
            'content'=>'required|string',
            'user_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
           return $this->responseTrait(null,$validator->errors());
        }else{

            $result = new Content();
            $result->fill([
                'title' => $request->get('title'),
                'slug' => Str::slug($request->get('title'), '-'),
                'content'=>$request->get('content')
            ]);

            try {
                $result->save();
                $this->newLog($request->get('user_id'),$request->route()->getName(),$result->id, json_encode($request->header()));
                $this->newContToType($request->get('type_id'),$result->id);
            }catch (\Exception $e){
                return response()->json([
                    'code' => 400,
                    'message' => "Başarısız",
                    'error' => $e
                ],Response::HTTP_BAD_REQUEST);
            }

            return $this->responseTrait($result);
        }
    }

    public function view($id){
        $model = Content::where('id',$id)->get()->toArray();
        return $this->responseTrait($model);
    }

    public function update(Request $request, $id){
        $rules = [
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'user_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return $this->responseTrait(null,$validator->errors());
        }else{
            $result = Content::where('id',$id)->first();

            if($result != null){
                $this->newLog($request->get('user_id'),$request->route()->getName(),$id, json_encode($request->header()));
                $result->update([
                    'title' => $request->get('title') ? $request->get('title') : $result->title,
                    'content' => $request->get('content') ? $request->get('content') : $result->content,
                    'slug' => $request->get('title') ? Str::slug($request->get('title'),"-") : $result->slug
                ]);
            }
            return $this->responseTrait($result);
        }
    }

    public function delete(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|integer'
        ]);

        if($validator->fails())
        {
            return $this->responseTrait(null,$validator->errors());
        }else{
        $result=Content::where('id',$id)->first();
        if($result != null){
            $this->newLog($request->get('user_id'),$request->route()->getName(),$id, json_encode($request->header()));
            $this->delCont($id);
            $result->delete();
        }
            return $this->responseTrait($result);
            }
        }
}
