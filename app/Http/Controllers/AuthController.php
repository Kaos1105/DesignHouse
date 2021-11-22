<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected IUser $userRepo;

    public function __construct(IUser $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(Request $request)
    {
        $data = $this->registerValidator($request);

        $user = $this->userRepo->create([
            "username" => $data['username'],
            "name" => $data['name'],
            "email" => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    protected function registerValidator(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:15|alpha_dash',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|confirmed|min:8'
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {
            if (!Auth::attempt($data)) {
                return response()->json([
                    'message' => 'Invalid login credentials'
                ], 401);
            }
            if (Auth::user() instanceof MustVerifyEmail && !Auth::user()->hasVerifiedEmail()) {
                return response()->json([
                    'message' => 'PLease verify your email account first'
                ], 422);
            }

            Auth::user()->tokens()->delete();
            $token = Auth::user()->createToken('auth_token')->plainTextToken;

            $response = [
                'user' => Auth::user(),
                'token' => $token,
            ];
            return response($response, 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Error in Login',
                'error' => $error,
            ], 500);
        }
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Token Revoked'
        ], 201);
    }
}
