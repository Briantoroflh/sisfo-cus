<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateReq;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //getAllUsers
    public function index(): JsonResponse
    {
        $user = User::all();

        if ($user->count() < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => UserResource::collection($user)
        ])->setStatusCode(200);
    }

    //getUsersById
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => new UserResource($user)
        ])->setStatusCode(200); 
    }

    //createUser
    public function store(UserCreateReq $request): JsonResponse
    {
        $req = $request->validated();
        
        if(User::where('email', $req['email'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terdaftar!'
            ])->setStatusCode(409);
        }
        
        $user = new User($req);
        $user->password = Hash::make($req['password']);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan!',
            'data' => new UserResource($user)
        ])->setStatusCode(201);
    }

    //updateUser
    public function update(UserCreateReq $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

       
        $user->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui!',
            'data' => new UserResource($user)
        ])->setStatusCode(200);
    }

    //deleteUser
    public function destroy(int $id): JsonResponse
    {
        $user = User::where('id_user', $id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ])->setStatusCode(200);
    }
}
