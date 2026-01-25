<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshRequest;

use App\Services\AuthService;
use App\Services\UserService;

class LoginController extends Controller
{
    private AuthService $auth_service;
    private UserService $user_service;

    public function __construct( AuthService $auth_service, UserService $user_service )
    {
        $this->auth_service = $auth_service;
        $this->user_service = $user_service;
    }

    public function login( LoginRequest $request ) : JsonResponse 
    {
        $user = $this->user_service->findUserByEmail( $request->email );
        if ( !$user ) {
            return response()->json([
                'message'   => 'Invalid Username or Password'
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message'   => 'Invalid Username or Password'
            ], 400);
        }
        
        $auth                   = $this->auth_service->authenticate( $request->email, $request->password );
        $user->tokens           = $auth;

        return response()->json($user, 200);
    }

    public function refresh( RefreshRequest $request ) : JsonResponse
    {
        $tokens = $this->auth_service->refreshToken( $request->refresh_token );
        return response()->json($tokens->tokens, $tokens->status);
    }
}
