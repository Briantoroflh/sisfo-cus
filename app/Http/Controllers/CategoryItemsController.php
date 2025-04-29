<?php

namespace App\Http\Controllers;

use App\Models\CategoryItems;
use Illuminate\Http\Request;

class CategoryItemsController extends Controller
{
    public function index()
    {
        $categories = CategoryItems::all();
        return view('category_items.index', compact('categories'));
    }

    public function create()
    {
        return view('category_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:category_items',
        ]);

        CategoryItems::create($request->all());

        return redirect()->route('category_items.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $category = CategoryItems::with('items')->findOrFail($id);
        return view('category_items.show', compact('category'));
    }

    public function edit($id)
    {
        $category = CategoryItems::findOrFail($id);
        return view('category_items.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = CategoryItems::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:category_items,category_name,' . $category->id_category . ',id_category',
        ]);

        $category->update($request->all());

        return redirect()->route('category_items.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = CategoryItems::findOrFail($id);
        $category->delete();

        return redirect()->route('category_items.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
