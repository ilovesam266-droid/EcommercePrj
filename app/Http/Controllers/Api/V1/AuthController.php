<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Repository\Constracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $loginField = filter_var($credentials['login_id'], FILTER_VALIDATE_EMAIL) ? 'email':'username';
        $attempt = [
            $loginField => $credentials['login_id'],
            'password' => $credentials['password'],
        ];

        if (!$token = JWTAuth::attempt($attempt)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    // public function register(Request $request)
    // {
    //     $user = $this->userRepository->create([
    //         'name'     => $request->name,
    //         'email'    => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     $token = JWTAuth::fromUser($user);

    //     return response()->json(['token' => $token], 201);
    // }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
