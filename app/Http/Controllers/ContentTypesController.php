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
        return $model->count() > 0
            ? $this->responseTrait($model)
            : $this->responseTrait();
    }

    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'type'    => 'required|string|in:blog,page,other',
            'template'=>'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->responseTrait(null,$validator->errors());
        } else {
            $result=new ContentTypes();

            $result->fill([
                'title' => $request->get('title'),
                'type' => $request->get('type'),
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
            return $this->responseTrait(null,$validator->errors());
        } else {
            $result = ContentTypes::where('id',$id)->first();
            $result->update([
                'title' => $request->get('title') ? $request->get('title') : $result->title,
                'type' => $request->get('type') ? $request->get('type') : $result->type,
                'template' => $request->get('template') ? $request->get('template') : $result->template

            ]);


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
        return $this->responseTrait($model);
    }
}
