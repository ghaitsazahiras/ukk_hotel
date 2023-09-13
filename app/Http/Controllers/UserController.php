<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTexceptions;

class UserController extends Controller
{
    // register user (create user data)
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'role' => 'required|string|max:255'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        //define nama file yang akan di upload
        $imageName = time() .'.'. $request->image->extension();

        //proses upload
        $request->image->move(public_path('images'), $imageName);
    
        $user = User::create([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
        'image' => $imageName,
        'role' => $request->get('role'),
        ]);
    
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }

    // login user
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        
        try {
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token', 500]);
        }
        
        //return response()->json(compact('token'));
        if($data = User::where('email', '=', $request->email)-> get()){
        return response()->json([
            'status' => 1,
            'message' => 'Succes login!',
            'token' => $token,
            'data' => $data
        ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Failed login!'
            ],404);
        }
    }

    // get auth user
    public function getAuthenticatedUser(){
        try{
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        }
        
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return response()->json(['token_expired'], $e->getStatusCode());
        }
        
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return response()->json(['token_invalid'], $e->getStatusCode());
        }

        catch (Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        
        // return response()->json(compact('user'));
        return response()->json([
            'status' => 1,
            'message' => 'Success login!',
            'data' => $user
        ]);
    }
}
