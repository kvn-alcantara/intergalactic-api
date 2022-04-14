<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'register']);
    }

    /**
     * Register a new user and get a JWT.
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'User successfully logged out!',
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
