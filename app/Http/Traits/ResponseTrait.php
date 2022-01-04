<?php

namespace App\Http\Traits;
use Illuminate\Http\Response;
trait ResponseTrait
{
    public function responseTrait($result = null,$errors = null){
        if(isset($errors)){
            return response()->json([
                'code' => 400,
                'message' => "Lütfen formunuzu kontrol ediniz.",
                'error' => $errors
            ],Response::HTTP_BAD_REQUEST);
        }else{
            return $result ? response()->json([
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
}
