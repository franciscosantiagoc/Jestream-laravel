<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateRequest;
use Laravel\Sanctum\PersonalAccessToken;

//use Illuminate\Http\Request;


class ValidateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ValidateRequest $request)
    {
        if(!$request->header('token')){
            return response()->json([
                "message"=>"Unauthenticated ¿Y usted quién es?"
            ],401);
        }

        $token = PersonalAccessToken::findToken($request->header('token'));
        $User = $token?$token->tokenable:null;

        if(!$token || $User->name !== $request->name){
            return response()->json([
                "message"=>"Unauthorized"
            ],403);
        }
//        return response()->json([
//            "data"=>$User,
//            "query"=>$request->name,
//            "tokens"=>$tokens,
//            "token"=>$token
//        ]);
        return response()->json([
            "data"=>$User->email
        ]);
        //return "Bienvenido ".$request->name;
    }
}
