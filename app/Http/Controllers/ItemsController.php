<?php

namespace App\Http\Controllers;

use App\Models\items;
use App\Models\CategoryItems;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        $items = items::with('category')->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = CategoryItems::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'code_items' => 'required|string|max:100|unique:items',
            'id_category' => 'required|exists:category_items,id_category',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'status' => 'required|string',
            'item_condition' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('item_image')) {
            $data['item_image'] = $request->file('item_image')->store('item_images', 'public');
        }

        items::create($data);

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = items::with('category')->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = items::findOrFail($id);
        $categories = CategoryItems::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = items::findOrFail($id);

        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'code_items' => 'required|string|max:100|unique:items,code_items,' . $item->id_items . ',id_items',
            'id_category' => 'required|exists:category_items,id_category',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'status' => 'required|string',
            'item_condition' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('item_image')) {
            $data['item_image'] = $request->file('item_image')->store('item_images', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = items::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.');
    }
}
