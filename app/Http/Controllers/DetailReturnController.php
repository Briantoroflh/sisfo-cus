<?php

namespace App\Http\Controllers;

use App\Models\DetailReturns;
use App\Models\DetailsBorrow;
use Illuminate\Http\Request;

class DetailReturnController extends Controller
{
    public function index()
    {
        $returns = DetailReturns::with('detailsBorrow')->get();
        return view('detail_returns.index', compact('returns'));
    }

    public function create()
    {
        $detailsBorrows = DetailsBorrow::all();
        return view('detail_returns.create', compact('detailsBorrows'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_details_borrow' => 'required|exists:details_borrows,id_details_borrow',
            'date_return' => 'required|date',
        ]);

        DetailReturns::create($request->all());

        return redirect()->route('detail_returns.index')->with('success', 'Pengembalian berhasil ditambahkan.');
    }

    public function show($id)
    {
        $return = DetailReturns::with('detailsBorrow')->findOrFail($id);
        return view('detail_returns.show', compact('return'));
    }

    public function edit($id)
    {
        $return = DetailReturns::findOrFail($id);
        $detailsBorrows = DetailsBorrow::all();
        return view('detail_returns.edit', compact('return', 'detailsBorrows'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_details_borrow' => 'required|exists:details_borrows,id_details_borrow',
            'date_return' => 'required|date',
        ]);

        $return = DetailReturns::findOrFail($id);
        $return->update($request->all());

        return redirect()->route('detail_returns.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $return = DetailReturns::findOrFail($id);
        $return->delete();

        return redirect()->route('detail_returns.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
