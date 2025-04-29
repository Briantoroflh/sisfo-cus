<?php

namespace App\Http\Controllers;

use App\Models\borrowed;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowedController extends Controller
{
    public function index()
    {
        $borroweds = borrowed::with(['user', 'detailsBorrow'])->get();
        return view('borrowed.index', compact('borroweds'));
    }

    public function create()
    {
        $users = User::all();
        return view('borrowed.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'date_borrowed' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date_borrowed',
            'status' => 'required|string|max:50'
        ]);

        borrowed::create($request->all());

        return redirect()->route('borrowed.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function show($id)
    {
        $borrow = borrowed::with(['user', 'detailsBorrow'])->findOrFail($id);
        return view('borrowed.show', compact('borrow'));
    }

    public function edit($id)
    {
        $borrow = borrowed::findOrFail($id);
        $users = User::all();
        return view('borrowed.edit', compact('borrow', 'users'));
    }

    public function update(Request $request, $id)
    {
        $borrow = borrowed::findOrFail($id);

        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'date_borrowed' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date_borrowed',
            'status' => 'required|string|max:50'
        ]);

        $borrow->update($request->all());

        return redirect()->route('borrowed.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $borrow = borrowed::findOrFail($id);
        $borrow->delete();

        return redirect()->route('borrowed.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
