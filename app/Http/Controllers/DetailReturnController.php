<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailReturnsResource;
use App\Models\DetailReturns;
use App\Models\DetailsBorrow;
use Illuminate\Http\Request;

class DetailReturnController extends Controller
{
    public function index()
    {
        $returns = DetailReturns::with('detailsBorrow.item')->get();
        return DetailReturnsResource::collection($returns);
    }

    public function show($id)
    {
        $return = DetailReturns::with('detailsBorrow.item')->findOrFail($id);
        return new DetailReturnsResource($return);
    }
}
