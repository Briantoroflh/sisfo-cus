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

    public function show($id)
    {
        $detail = DetailsBorrow::with(['item', 'borrowed.user', 'detailReturn'])->findOrFail($id);
        return new DetailsBorrowResource($detail);
    }
}
