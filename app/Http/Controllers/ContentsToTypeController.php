<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Content;
use App\Models\ContentToType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentsToTypeController extends Controller
{
    use ResponseTrait;

    public function read()
    {
        $model = ContentToType::all();
        return $model->count() > 0
            ? $this->responseTrait($model)
            : $this->responseTrait();
    }

    public function update(Request $request,$id){
        $rules = [
            'content_id' => 'nullable|integer',
            'type_id' => 'nullable|integer'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return $this->responseTrait(null,$validator->errors());
        }else{
            $result = ContentToType::where('id',$id)->first();

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
