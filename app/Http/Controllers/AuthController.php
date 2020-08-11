<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\APIHelpers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request) {
        $credentials = $request->only('email', 'password');
        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], Response::HTTP_BAD_REQUEST);
        }
        $user = auth()->user();
        unset($user['password']);
        $user['token'] = $token;
        return APIHelpers::createAPIResponse(true, 200, 'login successfully', $user, null);
    }

    public function register(AuthRegisterRequest $request) {
        $user = new User();
        try {
            $params = $request->only('email', 'name', 'password');
            $params['password'] = bcrypt($params['password']);
            $user->create($params);
            return APIHelpers::createAPIResponse(true, 201, 'register successfully', $user, null);
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, 'register failed', null, $e->getMessage());
        }
    }

    public function getUser(Request $request) {
        $user = Auth::user();
        try {
            return APIHelpers::createAPIResponse(true, 201, 'get user successfully', $user, null);
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 401, 'get user failed!', null, $e->getMessage());
        }
    }

    public function logout(Request $request) {
        try {
            JWTAuth::invalidate($request->input('token'));
            return APIHelpers::createAPIResponse(true, 201, 'You have successfully logged out.', null, null);
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, 'Failed to logout, please try again.', null, $e->getMessage());
        }
    }

    public function refreshToken(Request $request) {
        $token = JWTAuth::getToken()->get();
        JWTAuth::setToken($token);
        $new_token = JWTAuth::refresh($token);
        $response = $request;
        $response->header('Authorization','Bearer '.$new_token);
        $body = [
            'token' => $new_token
        ];
        return APIHelpers::createAPIResponse(true, 201, 'You have successfully logged out.', $body, null);
    }
}
