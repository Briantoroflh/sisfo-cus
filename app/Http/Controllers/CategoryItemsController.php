<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryItemsReq;
use App\Http\Resources\CategoryItemsResource;
use App\Models\CategoryItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryItemsController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = CategoryItems::all();

        if($categories->count() < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => CategoryItemsResource::collection($categories)
        ]);

    }

    public function store(CategoryItemsReq $request): JsonResponse
    {
        $req = $request->validated();

        $category = CategoryItems::create($req);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'data' => new CategoryItemsResource($category)
        ])->setStatusCode(201);
    }

    public function show($id): JsonResponse
    {
        $category = CategoryItems::with('items')->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => new CategoryItemsResource($category)
        ])->setStatusCode(200);
    }

    public function update(CategoryItemsReq $request, $id): JsonResponse
    {
        $category = CategoryItems::findOrFail($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        $category->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui!',
            'data' => new CategoryItemsResource($category)
        ])->setStatusCode(200);
    }

    public function destroy($id): JsonResponse
    {
        $category = CategoryItems::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus!'
        ])->setStatusCode(200);
    }
}
