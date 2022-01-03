<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ResponseTrait;

    public function read()
    {
        $model = User::all();
        return response()->json([
            'code' => $model->count() > 0
                ? 200
                : 400,
            'message' => $model->count() > 0
                ? 'Başarılı'
                : 'Listelenecek kullanıcı bulunamadı',
            'result' => $model->count() > 0
                ? $model->toArray()
                : []
        ],Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->messages()
            ], Response::HTTP_BAD_REQUEST );
        } else {
            $result = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'token'=>null,
                'conclusion'=>null,
            ]);

            return $this->responseTrait($result);
        }
    }

    public function update(Request $request)
    {
        $result = User::where('id',$request->get('id'))->update($request->all());

        return $this->responseTrait($result);
    }


    public function delete(Request $request,$id)
    {
        $result=User::where('id',$id)->delete();

        return $this->responseTrait($result);
    }

    public function view(Request $request,$id)
    {
        $model = User::where('id', $id)->get()->toArray();
        return $this->responseTrait($model);
    }

}
