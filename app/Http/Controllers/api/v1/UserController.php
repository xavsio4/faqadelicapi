<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
 
class UserController extends Controller
{
    public $successStatus = 200;
	/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request){ 

        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
	        }

        $cred = $request->only('email', 'password');
        
        if (auth()->attempt($cred)) {
            $user = Auth::user(); 
            auth()->user()->tokens()->delete();
            $success['token'] =  auth()->user()->createToken('Personal Access Token')->accessToken; 
            $success['userId'] = $user->id;
            return response()->json([
            'access_token' => $success['token'],
            ]);
            
            //return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout()
    {
        Auth()->user()->token()->revoke();
        if (Auth::check()) {
       Auth::user()->OauthAccessToken()->delete();
    }
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
    * passworg forgot
    *
    */
    public function passwordForgot(request $request)
    {
        $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        $status = Password::sendResetLink(
        $request->only('email')
        );
        
        if ($status === Password::RESET_LINK_SENT)
            return response()->json([
        'status_code' => 200,
        'message' => 'Password reset link sent !'
        ]);
        else
            return response()->json([
        'status_code' => 401,
        'message' => 'Somrthing is wrong ! Are you registered here ?'
        ]);
    }
 
	/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            // 'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'passwordc' => 'required|same:password',
        ]);
        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
	    }
    

	$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        
       //  $success['token'] =  $user->createToken('SPA')-> accessToken; // marche pas
        // $success['name'] =  $user->name;
		//return response()->json(['success'=>$success], $this-> successStatus); 
        return response()->json([
        'status_code' => 200,
        'message' => 'User successfully registered',
        'user' => $user,
        //  'token' => $token
        ], 201);
    }
	
	/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function userDetails() 
    { 
        //for nuxt auth it must return a "user" field in json
        $user = Auth::user(); 
        return response()->json(['user' => $user], $this-> successStatus); 
    }
}