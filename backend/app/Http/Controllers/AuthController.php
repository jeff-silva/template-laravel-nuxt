<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiError;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Post;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    protected function tokenData($token): Array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    #[Post('/api/auth/login', name: 'auth.login')]
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            throw new ApiError('Unauthorized', 401);
        }

        return $this->tokenData($token);
    }

    #[Post('/api/auth/me', name: 'auth.me', middleware: 'api')]
    public function me()
    {
        return auth()->user();
    }

    #[Post('/api/auth/logout', name: 'auth.logout', middleware: 'api')]
    public function logout()
    {
        auth()->logout();
        return ['message' => 'Successfully logged out'];
    }

    #[Post('/api/auth/refresh', name: 'auth.refresh', middleware: 'api')]
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
