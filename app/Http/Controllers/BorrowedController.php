<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowReq;
use App\Http\Requests\DetailBorrowReq;
use App\Http\Resources\BorrowedResource;
use App\Http\Resources\DetailsBorrowResource;
use App\Models\borrowed;
use App\Models\DetailsBorrow;
use App\Models\items;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowedController extends Controller
{
    public function index()
    {
        $data = Borrowed::with(['user', 'detailsBorrow.item'])->where('soft_delete', 0)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List of borrow requests',
            'data' => BorrowedResource::collection($data)
        ]);
    }

    public function show($id)
    {
        $borrowed = Borrowed::with(['user', 'detailsBorrow.item'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Borrow detail',
            'data' => new BorrowedResource($borrowed)
        ]);
    }

    public function store(DetailBorrowReq $request)
    {
        $detail = DetailsBorrow::create($request->validated());

        $user = Auth::user();

        Borrowed::create([
            'id_user' => $user->id_user,
            'id_details_borrow' => $detail->id_details_borrow,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil diajukan.',
            'data' => new DetailsBorrowResource($detail)
        ], 201);
    }

    public function approve($id)
    {
        $borrowed = Borrowed::findOrFail($id);
        $borrowed->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman disetujui.'
        ]);
    }

    public function reject($id)
    {
        $borrowed = Borrowed::findOrFail($id);
        $borrowed->update(['soft_delete' => 1, 'status' => 'not approved']);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman ditolak dan ditandai sebagai soft delete.'
        ]);
    }
}
