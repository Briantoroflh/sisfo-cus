<?php

namespace App\Http\Controllers;

use App\Models\DetailsBorrow;
use App\Models\Items;
use App\Models\Borrowed;
use Illuminate\Http\Request;

class DetailBorrowController extends Controller
{
    public function index()
    {
        $details = DetailsBorrow::with(['item', 'borrowed', 'detailReturn'])->get();
        return view('details_borrow.index', compact('details'));
    }

    public function create()
    {
        $items = Items::all();
        $borroweds = Borrowed::all();
        return view('details_borrow.create', compact('items', 'borroweds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_items' => 'required|exists:items,id_items',
            'id_borrowed' => 'required|exists:borroweds,id_borrowed',
            'status_borrow' => 'required|string|max:50',
            'used_for' => 'nullable|string|max:255',
            'amount' => 'required|integer|min:1'
        ]);

        DetailsBorrow::create($request->all());

        return redirect()->route('details_borrow.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function show($id)
    {
        $detail = DetailsBorrow::with(['item', 'borrowed', 'detailReturn'])->findOrFail($id);
        return view('details_borrow.show', compact('detail'));
    }

    public function edit($id)
    {
        $detail = DetailsBorrow::findOrFail($id);
        $items = Items::all();
        $borroweds = Borrowed::all();
        return view('details_borrow.edit', compact('detail', 'items', 'borroweds'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_items' => 'required|exists:items,id_items',
            'id_borrowed' => 'required|exists:borroweds,id_borrowed',
            'status_borrow' => 'required|string|max:50',
            'used_for' => 'nullable|string|max:255',
            'amount' => 'required|integer|min:1'
        ]);

        $detail = DetailsBorrow::findOrFail($id);
        $detail->update($request->all());

        return redirect()->route('details_borrow.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $detail = DetailsBorrow::findOrFail($id);
        $detail->delete();

        return redirect()->route('details_borrow.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
