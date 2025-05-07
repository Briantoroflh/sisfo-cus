<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailsBorrowResource;
use App\Models\DetailsBorrow;
use App\Models\Items;
use App\Models\Borrowed;
use Illuminate\Http\Request;

class DetailBorrowController extends Controller
{
    public function index()
    {
        $details = DetailsBorrow::with(['item', 'borrowed.user', 'detailReturn'])->get();
        return DetailsBorrowResource::collection($details);
    }

    public function getItemsByDetailBorrow($id)
    {
        $detailBorrows = DetailsBorrow::with('item.category')
            ->where('id_details_borrow', $id)
            ->get();

        if ($detailBorrows->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Detail tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $detailBorrows->map(function ($detail) {
                return [
                    'item_name' => $detail->item->item_name ?? '-',
                    'category_name' => $detail->item->category->category_name ?? '-',
                    'quantity' => $detail->amount,
                ];
            })
        ]);
    }
}
