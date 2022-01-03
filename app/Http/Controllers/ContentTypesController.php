<?php

namespace App\Http\Controllers;

use App\Http\Traits\ContentToTypeTrait;
use App\Http\Traits\LogTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\ContentTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ContentTypesController extends Controller
{
    use LogTrait, ContentToTypeTrait, ResponseTrait;
    public function read()
    {
        $model= ContentTypes::all();
        return $this->responseTrait($model);
    }

    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'type'    => "required|array|min:1",
            'type.*'  => "required|in:blog,page,other",
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
                'title' => $request->get('title'),
                'type' => json_encode($request->get('type')),
                'template' => $request->get('template')
            ]);
            $result->save();

            return $this->responseTrait($result);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'nullable|string',
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
            return response()->json([
                'code' => 400,
                'message' => 'Lütfen formunuzu kontrol ediniz.',
                'result' => $validator->errors()
            ]);
        }else{
        $result=ContentTypes::where('id',$id)->first();
        if($result != null){
            $this->delType($result->id);
            $result->delete();
        }
            return $this->responseTrait($result);
        }
    }

    public function view($id)
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
