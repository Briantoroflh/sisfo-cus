<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailReturnReq;
use App\Http\Resources\DetailReturnsResource;
use App\Http\Resources\DetailsReturnsResource;
use App\Models\DetailReturns;
use App\Models\DetailsBorrow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailReturnController extends Controller
{
    public function index()
    {
        $returns = DetailReturns::with([
            'borrowed.user',
            'borrowed.detailsBorrow.item'
        ])->where('soft_delete', 0)->get();

        return response()->json([
            'status' => 'success',
            'data' => DetailsReturnsResource::collection($returns)
        ]);
    }

    // Tampilkan detail pengembalian berdasarkan ID
    public function show($id)
    {
        $return = DetailReturns::with([
            'borrowed.user',
            'borrowed.detailsBorrows.item'
        ])->where('soft_delete', 0)->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => new DetailsReturnsResource($return)
        ]);
    }

    // Approve pengembalian
    public function approve($id, Request $request)
{
    $return = DetailReturns::findOrFail($id);
    if ($return->soft_delete == 1) {
        return response()->json(['message' => 'Data sudah dihapus'], 404);
    }

    // Periksa jika ada gambar yang diunggah
    if ($request->hasFile('item_image')) {
        $request->validate([
            'item_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Simpan gambar di storage 'public/returns'
        $image = $request->file('item_image');
        $imagePath = $image->store('public/returns');

        // Simpan path gambar ke kolom item_image
        $return->item_image = $imagePath;
    }

    // Update status pengembalian menjadi 'approve'
    $return->status = 'approve';
    $return->save();

    return response()->json([
        'message' => 'Pengembalian disetujui',
        'data' => new DetailsReturnsResource($return)
    ]);
}

    // Reject pengembalian
    public function reject($id)
    {
        $return = DetailReturns::findOrFail($id);
        if ($return->soft_delete == 1) {
            return response()->json(['message' => 'Data sudah dihapus'], 404);
        }

        $return->status = 'not approve';
        $return->save();

        return response()->json(['message' => 'Pengembalian ditolak']);
    }

    public function store(DetailReturnReq $request): JsonResponse{
        $validated = $request->validated();

        // Simpan gambar di storage 'public/returns'
        $image = $request->file('item_image');
        $imagePath = $image->store('public/returns');

        // Simpan data pengembalian
        $return = DetailReturns::create([
            'id_borrowed' => $validated['id_borrowed'],
            'description' => $validated['description'],
            'item_image' => $imagePath,
            'date_return' => $validated['date_return'],
            'soft_delete' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new DetailsReturnsResource($return)
        ]);
    }
}
