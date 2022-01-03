<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Content;
use App\Models\ContentToType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ContentsToTypeController extends Controller
{
    use ResponseTrait;

    public function read()
    {
        $model = ContentToType::all();
        return $this->responseTrait($model);
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

            return $this->responseTrait($result);
        }
    }

}
