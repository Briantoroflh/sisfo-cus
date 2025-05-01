<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowReq;
use App\Http\Requests\DetailBorrowReq;
use App\Http\Resources\BorrowedResource;
use App\Models\borrowed;
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
        $data = Borrowed::with(['user', 'detailsBorrow.item'])->latest()->get();
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

    public function store(BorrowReq $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $borrowed = Borrowed::create([
                'id_user' => $validated['id_user'],
                'date_borrowed' => $validated['date_borrowed'],
                'due_date' => $validated['due_date'],
                'status' => 'pending'
            ]);

            foreach ($validated['details'] as $detail) {
                $borrowed->detailsBorrow()->create([
                    'id_items' => $detail['id_items'],
                    'amount' => $detail['amount'],
                    'used_for' => $detail['used_for'],
                    'status_borrow' => 'pending'
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Borrow request created',
                'data' => new BorrowedResource($borrowed->load('user', 'detailsBorrow.item'))
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create borrow request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approve($id)
    {
        $borrowed = Borrowed::with('detailsBorrow')->findOrFail($id);
        if ($borrowed->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Already processed'], 400);
        }

        $borrowed->update(['status' => 'approved']);
        $borrowed->detailsBorrow()->update(['status_borrow' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Borrow approved']);
    }

    public function reject($id)
    {
        $borrowed = Borrowed::with('detailsBorrow')->findOrFail($id);
        if ($borrowed->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Already processed'], 400);
        }

        $borrowed->update(['status' => 'rejected']);
        $borrowed->detailsBorrow()->update(['status_borrow' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Borrow rejected']);
    }
}
