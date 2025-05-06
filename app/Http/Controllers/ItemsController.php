<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemsReq;
use App\Http\Resources\ItemsResource;
use App\Models\items;
use App\Models\CategoryItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(): JsonResponse
    {
        $items = items::with('category')->get();

        if ($items->count() < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => ItemsResource::collection($items)
        ])->setStatusCode(200);
    }

    public function store(ItemsReq $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('item_image')) {
            $data['item_image'] = $request->file('item_image')->store('item_images', 'public');
        }

        $item = items::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan!',
            'data' => new ItemsResource($item)
        ])->setStatusCode(201);
    }

    public function show($id): JsonResponse
    {
        $item = items::with('category')->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => new ItemsResource($item)
        ])->setStatusCode(200);
    }

    public function update(ItemsReq $request, int $id): JsonResponse
    {
        $item = items::findOrFail($id);
        
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        $data = $request->validated();

        if ($request->hasFile('item_image')) {
            $data['item_image'] = $request->file('item_image')->store('item_images', 'public');
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil diperbarui!',
            'data' => new ItemsResource($item)
        ])->setStatusCode(200);
    }

    public function destroy($id): JsonResponse
    {
        $item = items::findOrFail($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada di koleksi!'
            ])->setStatusCode(404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus!'
        ])->setStatusCode(200);
    }
}
