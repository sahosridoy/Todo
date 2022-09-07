<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    public function ResponseSuccess($data, $message = "Successfull", $status_code = JsonResponse::HTTP_OK){
        return response()->json([
            'code'=>$status_code,
            'message'=>$message,
            'data'=>$data,
        ]);
    }

    public function ResponseError($errors, $message = "Your data is invalid", $status_code = JsonResponse::HTTP_BAD_REQUEST){
        return response()->json([
            'code'=>$status_code,
            'message'=>$message,
            'errors'=>$errors
        ]);
    }

    public function ResponseInfo($code = JsonResponse::HTTP_OK,$message = "Success"){
       return [
           "code"=>$code,
           "message"=>$message
       ];
    }


    public function ResponseInfoAppend($append,$code = JsonResponse::HTTP_OK,$message = "Success"){
        return [
            "code"=>$code,
            "message"=>$message,
            "appends"=>$append
        ];
    }

}









