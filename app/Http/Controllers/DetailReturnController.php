<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailReturnsResource;
use App\Http\Resources\DetailsReturnsResource;
use App\Models\DetailReturns;
use App\Models\DetailsBorrow;
use Illuminate\Http\Request;

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
    public function approve($id)
    {
        $return = DetailReturns::findOrFail($id);
        if ($return->soft_delete == 1) {
            return response()->json(['message' => 'Data sudah dihapus'], 404);
        }

        $return->status = 'approve';
        $return->save();

        return response()->json(['message' => 'Pengembalian disetujui']);
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
}
