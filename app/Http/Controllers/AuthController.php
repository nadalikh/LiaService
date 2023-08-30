<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginWithPasswordRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = User::whereMobile($request->mobile)->first();
        $attempts = $request->only("email", "password");
        if($token = Auth::attempt($attempts))
            return $this->respondWithSuccess(["token" => $token]);
        return $this->respondError("error");
    }
    public function whoAmI(){
        return $this->respondWithSuccess(
            auth()->user()->load("role.permissions", "visitsOfDoctor", "requestsOfPatients")
        );
    }

    public function refresh(){
        try{
            $token = Auth::refresh();
            return $this->respondWithSuccess(["token" => $token]);
        }catch(TokenExpiredException $e){
            return $this->respondError("error");
        }
        catch(Exception $e){
            return $this->respondError($e->getMessage());
        }
    }
}
