<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginReq;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function LoginWeb(UserLoginReq $request): JsonResponse
    {
        try {
            $req = $request->validated();
            $user = User::where('email', $req['email'])->first();

            if (!$user || !Hash::check($req['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password tidak di temukan!'
                ], 404);
            }

            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses!'
                ], 403);
            }

            Auth::login($user);

            // Jika Anda tetap ingin token (untuk konsumsi API dari JS misalnya)
            $user->tokens()->delete();
            $token = $user->createToken('API_TOKEN')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successfuly!',
                'token' => $token,
                'token_type' => 'Bearer',
                'data' => new UserResource($user)
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed!',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function LoginMobile(UserLoginReq $request): JsonResponse
    {
        try {
            $req = $request->validated();
            $user = User::where('email', $req['email'])->first();

            if (!$user || !Hash::check($req['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password tidak di temukan!'
                ])->setStatusCode(404);
            }

            $user->tokens()->delete();

            $token = $user->createToken('API_TOKEN')->plainTextToken;
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not found!'
                ])->setStatusCode(401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successfuly!',
                'token' => $token,
                'token_type' => 'Bearer',
                'data' => new UserResource($user)
            ])->setStatusCode(200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed!',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function Me(): JsonResponse {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => new UserResource($user)
        ]);
    }
}
