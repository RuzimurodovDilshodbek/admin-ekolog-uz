<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $service;
    protected $response;
    public function __construct()
    {
        $this->service = new UserService();
    }
    public function login()
    {
//        dd('kelli');
        $credentials = request(['phone', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $this->response['success'] = true;
        $this->response['result'] = $this->withToken($token);
        return response()->json($this->response);
    }

    protected function withToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function register(Request $request)
    {
        return $this->service->store($request);
    }
}
